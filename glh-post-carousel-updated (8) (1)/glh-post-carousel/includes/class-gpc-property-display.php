<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shows a bedrooms / bathrooms / location / price icon row, an optional
 * red "AD" ribbon, and a Google-listing-style star rating on property
 * posts — works on the blog listing page and the single post page alike.
 * Only appears on posts that actually have property meta saved, so it
 * never shows on non-property posts.
 *
 * IMPORTANT: all CSS/JS here is loaded via wp_enqueue_style/script, never
 * injected as an inline <style> tag through the_content/the_excerpt —
 * WordPress's wpautop() runs on both of those filters and mangles
 * multi-line <style> blocks (inserts stray <br>/<p> tags into the CSS),
 * which is what broke the icon row's layout before.
 */
class GPC_Property_Display {

	public function __construct() {
		add_filter( 'the_content', array( $this, 'wrap_description_faq' ), 4 );
		add_filter( 'the_content', array( $this, 'prepend_row' ), 5 );
		add_filter( 'the_excerpt', array( $this, 'prepend_row' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'wp_ajax_gpc_rate_post', array( $this, 'ajax_rate' ) );
		add_action( 'wp_ajax_nopriv_gpc_rate_post', array( $this, 'ajax_rate' ) );
	}

	/**
	 * Wraps a post's description in a collapsed, FAQ-style "tap to
	 * expand" panel instead of showing the full (sometimes very long)
	 * text everywhere by default. Runs on the single post page only —
	 * excerpts on listing/archive pages are already short and untouched.
	 */
	public function wrap_description_faq( $content ) {
		if ( doing_filter( 'get_the_excerpt' ) && current_filter() === 'the_content' ) {
			return $content;
		}
		if ( ! in_the_loop() || ! is_main_query() || ! is_singular( 'post' ) ) {
			return $content;
		}
		if ( trim( wp_strip_all_tags( $content ) ) === '' ) {
			return $content;
		}
		ob_start();
		?>
		<div class="gpc-faq-sections">
			<div class="gpc-faq-item">
				<button type="button" class="gpc-faq-trigger" aria-expanded="false">
					<span class="gpc-faq-label">Description</span>
					<svg class="gpc-faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
				</button>
				<div class="gpc-faq-panel">
					<div class="gpc-faq-content"><?php echo $content; ?></div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	public function assets() {
		wp_enqueue_style( 'gpc-property', GPC_URL . 'assets/css/gpc-property.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-property', GPC_URL . 'assets/js/gpc-property.js', array(), GPC_VERSION, true );
		wp_localize_script( 'gpc-property', 'gpcPropertyData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'gpc_rate_post' ),
		) );
	}

	public function prepend_row( $content ) {
		if ( doing_filter( 'get_the_excerpt' ) && current_filter() === 'the_content' ) {
			return $content; // avoid the internal excerpt-generation leak
		}
		if ( ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		$post_id = get_the_ID();
		if ( ! $post_id ) return $content;

		$bedrooms  = get_post_meta( $post_id, '_gpc_bedrooms', true );
		$bathrooms = get_post_meta( $post_id, '_gpc_bathrooms', true );
		$toilets   = get_post_meta( $post_id, '_gpc_toilets', true );
		$location  = get_post_meta( $post_id, '_gpc_location', true );
		$price     = get_post_meta( $post_id, '_gpc_price', true );
		$is_ad     = get_post_meta( $post_id, '_gpc_is_ad', true );
		$status    = get_post_meta( $post_id, '_glh_listing_status', true ); // '', 'available', or 'sold' — set from the owner's My Listings dashboard

		if ( $bedrooms === '' && $bathrooms === '' && $toilets === '' && $location === '' && $price === '' && ! $is_ad ) {
			return $content; // not a property post (or no details saved) — leave untouched
		}

		return $this->render_row( $post_id, $bedrooms, $bathrooms, $toilets, $location, $price, $is_ad, $status ) . $content;
	}

	private function render_row( $post_id, $bedrooms, $bathrooms, $toilets, $location, $price, $is_ad, $status = '' ) {
		$sum   = (int) get_post_meta( $post_id, '_gpc_rating_sum', true );
		$count = (int) get_post_meta( $post_id, '_gpc_rating_count', true );
		$avg   = $count > 0 ? $sum / $count : 0;

		$is_single = is_singular( 'post' );

		// Work out the status badge text. Prefer the explicit listing status
		// saved from the owner's dashboard; otherwise infer a sensible label
		// from the listing's category (rentals => FOR RENT, everything else
		// that has property details => FOR SALE). Pulled dynamically so the
		// badge always reflects the real listing state.
		$status_map = array(
			'available' => 'FOR SALE',
			'sold'      => 'SOLD',
			'rented'    => 'LEASED',
			'leased'    => 'LEASED',
			'taken'     => 'TAKEN',
			'rent'      => 'FOR RENT',
		);
		if ( isset( $status_map[ $status ] ) ) {
			$status_text  = $status_map[ $status ];
			$status_class = $status;
		} elseif ( $status ) {
			$status_text  = strtoupper( $status );
			$status_class = sanitize_html_class( $status );
		} elseif ( has_category( array( 'rent', 'short-let', 'hotel' ), $post_id ) ) {
			$status_text  = 'FOR RENT';
			$status_class = 'rent';
		} else {
			$status_text  = 'FOR SALE';
			$status_class = 'available';
		}

		// "Featured" uses WordPress's native sticky-post flag — no extra meta
		// to maintain. Per the design, its text is shown in red.
		$is_featured = is_sticky( $post_id );

		// Gallery image count for the "image counter" action icon, and whether
		// a map is available for the "map" action icon. Both reuse the
		// carousel plugin's own data so they always match the hero gallery.
		$image_count = 0;
		if ( class_exists( 'GPC_Carousel' ) ) {
			$image_count = count( GPC_Carousel::get_gallery_image_ids( $post_id ) );
		}
		$lat       = get_post_meta( $post_id, '_gpc_lat', true );
		$lng       = get_post_meta( $post_id, '_gpc_lng', true );
		$has_map   = ( ( $lat !== '' && $lng !== '' ) || $location !== '' );
		$video_url = get_post_meta( $post_id, '_gpc_video_url', true );

		ob_start();
		?>
		<div class="gpc-prop-info-block">

			<?php // Action icons — shown on the single property page only, directly beneath the hero gallery. ?>
			<?php if ( $is_single ) : ?>
				<div class="gpc-action-icons" role="group" aria-label="Property actions">
					<?php if ( $image_count > 0 ) : ?>
						<button type="button" class="gpc-action-btn gpc-action-gallery is-active" aria-label="<?php echo esc_attr( sprintf( 'View all %d photos', $image_count ) ); ?>">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>
							<span class="gpc-action-count"><?php echo esc_html( $image_count ); ?></span>
						</button>
					<?php endif; ?>

					<?php if ( $video_url !== '' ) : ?>
						<a href="<?php echo esc_url( $video_url ); ?>" target="_blank" rel="noopener" class="gpc-action-btn gpc-action-video" aria-label="Watch video">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="14" height="16" rx="2"></rect><path d="M16 9l6-3v12l-6-3"></path></svg>
						</a>
					<?php endif; ?>

					<?php if ( $has_map ) : ?>
						<button type="button" class="gpc-action-btn gpc-action-map" aria-label="Show location on map">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 8 3 16 6 23 3 23 18 16 21 8 18 1 21 1 6"></polygon><line x1="8" y1="3" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="21"></line></svg>
						</button>
					<?php endif; ?>

					<button type="button" class="gpc-action-btn gpc-action-share" aria-label="Share this listing" data-share-title="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" data-share-url="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
					</button>
				</div>
			<?php endif; ?>

			<!-- Status Badges -->
			<div class="gpc-status-badges">
				<?php if ( $is_featured ) : ?>
					<span class="gpc-status-badge gpc-status-featured">FEATURED</span>
				<?php endif; ?>
				<?php if ( $status_text ) : ?>
					<span class="gpc-status-badge gpc-status-<?php echo esc_attr( $status_class ); ?>">
						<?php echo esc_html( $status_text ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $is_ad ) : ?>
					<span class="gpc-status-badge gpc-status-ad">AD</span>
				<?php endif; ?>
			</div>

			<!-- Property Info Container -->
			<div class="gpc-prop-info-container">
				<!-- Title & Location -->
				<div class="gpc-prop-header">
					<?php if ( $is_single ) : ?>
						<h1 class="gpc-prop-title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>
					<?php endif; ?>
					<?php if ( $location !== '' ) : ?>
						<div class="gpc-prop-location-main">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
							<span><?php echo esc_html( $location ); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<!-- Price & Stats Row -->
				<div class="gpc-prop-top-row">
					<?php if ( $price !== '' ) : ?>
						<div class="gpc-prop-price-main"><?php echo esc_html( $price ); ?></div>
					<?php endif; ?>

					<?php if ( $bedrooms !== '' || $bathrooms !== '' || $toilets !== '' ) : ?>
						<div class="gpc-prop-stats-row">
							<?php if ( $bedrooms !== '' ) : ?>
								<span class="gpc-prop-stat-item" title="Bedrooms">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6"></path><path d="M3 18h18"></path><path d="M5 10V7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v3"></path><path d="M13 10V8a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path></svg>
									<span><?php echo esc_html( $bedrooms ); ?></span>
								</span>
							<?php endif; ?>

							<?php if ( $bathrooms !== '' ) : ?>
								<span class="gpc-prop-stat-item" title="Bathrooms">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12h16v3a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-3z"></path><path d="M6 12V6a2 2 0 0 1 3.2-1.6"></path><line x1="9" y1="19" x2="9" y2="21"></line><line x1="15" y1="19" x2="15" y2="21"></line></svg>
									<span><?php echo esc_html( $bathrooms ); ?></span>
								</span>
							<?php endif; ?>

							<?php if ( $toilets !== '' ) : ?>
								<span class="gpc-prop-stat-item" title="Toilets">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 4h6l1 5H6l1-5z"></path><path d="M6 9h8l-.6 4.5A3 3 0 0 1 10.4 16H9.6a3 3 0 0 1-3-2.5L6 9z"></path><path d="M9 16v2a1 1 0 0 0 2 0v-2"></path></svg>
									<span><?php echo esc_html( $toilets ); ?></span>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Rating (Listing page only) -->
				<?php
				$my_previous = isset( $_COOKIE[ 'gpc_rated_' . $post_id ] ) ? absint( $_COOKIE[ 'gpc_rated_' . $post_id ] ) : 0;
				$show_rating = ! is_singular( 'post' );
				if ( $show_rating ) :
				?>
					<div class="gpc-rating-row gpc-rating-interactive" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-my-rating="<?php echo esc_attr( $my_previous ); ?>">
						<span class="gpc-rating-stars">
							<?php for ( $i = 1; $i <= 5; $i++ ) :
								$filled = $i <= round( $avg );
							?>
								<svg viewBox="0 0 24 24" stroke-width="1.5" class="<?php echo $filled ? 'is-filled' : 'is-empty'; ?>" data-stars="<?php echo esc_attr( $i ); ?>"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
							<?php endfor; ?>
						</span>
						<span class="gpc-rating-score"><?php echo $count > 0 ? esc_html( number_format( $avg, 1 ) ) : ''; ?></span>
						<span class="gpc-rating-count"><?php echo $count > 0 ? '(' . esc_html( number_format( $count ) ) . ')' : 'Rate this listing'; ?></span>
						<span class="gpc-rating-mine"><?php echo $my_previous ? 'Your rating: ' . esc_html( $my_previous ) . '★ (tap to change)' : ''; ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * One rating per visitor per post, tracked via a cookie (not
	 * bulletproof against a determined person clearing cookies, but
	 * enough to stop accidental repeat clicks/casual gaming).
	 */
	public function ajax_rate() {
		check_ajax_referer( 'gpc_rate_post', 'nonce' );
		$post_id = absint( $_POST['post_id'] ?? 0 );
		$stars   = absint( $_POST['stars'] ?? 0 );
		if ( ! $post_id || $stars < 1 || $stars > 5 ) {
			wp_send_json_error( array( 'message' => 'Invalid rating.' ) );
		}

		$cookie_name = 'gpc_rated_' . $post_id;
		$previous = isset( $_COOKIE[ $cookie_name ] ) ? absint( $_COOKIE[ $cookie_name ] ) : 0;

		$sum   = (int) get_post_meta( $post_id, '_gpc_rating_sum', true );
		$count = (int) get_post_meta( $post_id, '_gpc_rating_count', true );

		if ( $previous >= 1 && $previous <= 5 ) {
			// This visitor already rated it — update their existing vote
			// (swap the old value for the new one) rather than adding a
			// second vote or refusing the request.
			if ( $previous === $stars ) {
				wp_send_json_success( array(
					'average'   => $count > 0 ? round( $sum / $count, 1 ) : 0,
					'count'     => $count,
					'unchanged' => true,
				) );
			}
			$sum = $sum - $previous + $stars;
		} else {
			$sum += $stars;
			$count++;
		}
		$sum = max( 0, $sum );

		update_post_meta( $post_id, '_gpc_rating_sum', $sum );
		update_post_meta( $post_id, '_gpc_rating_count', $count );

		$cookie_path   = defined( 'COOKIEPATH' ) ? COOKIEPATH : '/';
		$cookie_domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
		setcookie( $cookie_name, (string) $stars, time() + YEAR_IN_SECONDS, $cookie_path, $cookie_domain );

		$average = $count > 0 ? round( $sum / $count, 1 ) : 0;
		$this->notify_author( $post_id, $stars, $average, $count );

		wp_send_json_success( array(
			'average' => $average,
			'count'   => $count,
		) );
	}

	/**
	 * Lets the post author know their listing was rated. We don't know
	 * which (if any) notification plugin is installed on this site, so
	 * this does three things to cover the realistic cases:
	 *  1. Fires a generic action hook (`gpc_post_rated`) any notification
	 *     plugin or custom code can attach to.
	 *  2. Auto-supports BuddyPress's notification system if it's active.
	 *  3. Always sends a direct email to the author as a guaranteed
	 *     fallback that works regardless of what else is installed.
	 */
	private function notify_author( $post_id, $stars, $average, $count ) {
		$post = get_post( $post_id );
		if ( ! $post ) return;
		$author_id = (int) $post->post_author;
		if ( ! $author_id ) return;

		do_action( 'gpc_post_rated', $post_id, $stars, $average, $count, $author_id );

		if ( function_exists( 'bp_notifications_add_notification' ) ) {
			bp_notifications_add_notification( array(
				'user_id'          => $author_id,
				'item_id'          => $post_id,
				'component_name'   => 'gpc_property',
				'component_action' => 'gpc_new_rating',
				'date_notified'    => function_exists( 'bp_core_current_time' ) ? bp_core_current_time() : current_time( 'mysql' ),
				'is_new'           => 1,
			) );
		}

		$author = get_userdata( $author_id );
		if ( $author && is_email( $author->user_email ) ) {
			$subject = sprintf( 'Your listing "%s" was just rated %d★', get_the_title( $post_id ), $stars );
			$body = sprintf(
				"Hi %s,\n\nSomeone rated your listing \"%s\" %d out of 5 stars.\nIt now averages %s★ from %d rating%s.\n\nView it: %s\n",
				$author->display_name,
				get_the_title( $post_id ),
				$stars,
				$average,
				$count,
				( 1 === $count ? '' : 's' ),
				get_permalink( $post_id )
			);
			wp_mail( $author->user_email, $subject, $body );
		}
	}
}
