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
		<div class="gpc-desc-faq">
			<button type="button" class="gpc-desc-faq-trigger" aria-expanded="false">
				<span class="gpc-desc-faq-icon">📄</span>
				<span class="gpc-desc-faq-label">Description</span>
				<span class="gpc-desc-faq-chevron">⌄</span>
			</button>
			<div class="gpc-desc-faq-panel">
				<div class="gpc-desc-faq-inner"><?php echo $content; ?></div>
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

		ob_start();
		?>
		<div class="gpc-prop-block" style="position:relative;">
			<?php if ( 'sold' === $status ) : ?>
				<span class="gpc-ad-ribbon gpc-sold-ribbon">SOLD</span>
			<?php elseif ( $is_ad ) : ?>
				<span class="gpc-ad-ribbon">AD</span>
			<?php endif; ?>

			<?php
			$my_previous = isset( $_COOKIE[ 'gpc_rated_' . $post_id ] ) ? absint( $_COOKIE[ 'gpc_rated_' . $post_id ] ) : 0;
			$show_rating = ! is_singular( 'post' ); // listing page only, per explicit request
			if ( $show_rating ) :
			?>
				<div class="gpc-rating gpc-rating-interactive" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-my-rating="<?php echo esc_attr( $my_previous ); ?>">
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

			<?php if ( $location !== '' ) : ?>
				<div class="gpc-prop-location">
					<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
					<span><?php echo esc_html( $location ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( $bedrooms !== '' || $bathrooms !== '' || $toilets !== '' ) : ?>
				<div class="gpc-prop-stats">
					<?php if ( $bedrooms !== '' ) : ?>
						<span class="gpc-prop-stat" title="Bedrooms">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6"></path><path d="M3 18h18"></path><path d="M5 10V7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v3"></path><path d="M13 10V8a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path></svg>
							<?php echo esc_html( $bedrooms ); ?>
						</span>
					<?php endif; ?>

					<?php if ( $bathrooms !== '' ) : ?>
						<span class="gpc-prop-stat" title="Bathrooms">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12h16v3a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-3z"></path><path d="M6 12V6a2 2 0 0 1 3.2-1.6"></path><line x1="9" y1="19" x2="9" y2="21"></line><line x1="15" y1="19" x2="15" y2="21"></line></svg>
							<?php echo esc_html( $bathrooms ); ?>
						</span>
					<?php endif; ?>

					<?php if ( $toilets !== '' ) : ?>
						<span class="gpc-prop-stat" title="Toilets">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4h6l1 5H6l1-5z"></path><path d="M6 9h8l-.6 4.5A3 3 0 0 1 10.4 16H9.6a3 3 0 0 1-3-2.5L6 9z"></path><path d="M9 16v2a1 1 0 0 0 2 0v-2"></path></svg>
							<?php echo esc_html( $toilets ); ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $price !== '' ) : ?>
				<div class="gpc-prop-price"><?php echo esc_html( $price ); ?></div>
			<?php endif; ?>
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
