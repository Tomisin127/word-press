<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GPC_Carousel {

	private $carousel_html = null;
	private $rendered_via_theme_hook = false;

	public function __construct() {
		add_action( 'template_redirect', array( $this, 'maybe_start' ) );

		// GridBit's theme provides a real action hook that fires exactly
		// after the post title's header block and before the content —
		// exactly where the carousel should sit. When it's available, use
		// it directly: no HTML parsing needed, guaranteed correct position.
		add_action( 'gridbit_after_single_post_title', array( $this, 'output_via_theme_hook' ) );

		// Blog listing / archive / category pages: the carousel goes into
		// the excerpt block, above the property details row (priority 6
		// runs after that row's priority 5, and since each hook prepends,
		// running later means ending up on top — carousel, then details,
		// then text).
		add_filter( 'the_excerpt', array( $this, 'prepend_to_listing_excerpt' ), 6 );
	}

	public function prepend_to_listing_excerpt( $excerpt ) {
		if ( is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $excerpt;
		}
		$post_id = get_the_ID();
		if ( ! $post_id ) return $excerpt;

		$image_ids = $this->is_eligible_post( $post_id );
		if ( ! $image_ids ) return $excerpt;

		wp_enqueue_style( 'gpc-carousel', GPC_URL . 'assets/css/gpc-carousel.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-carousel', GPC_URL . 'assets/js/gpc-carousel.js', array( 'gpc-leaflet' ), GPC_VERSION, true );
		// Same free OpenStreetMap/Leaflet setup used by the submission form's
		// pin picker — reusing the same handle names means WP just shares
		// the one script/style if both happen to load on the same page.
		wp_enqueue_style( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
		return $this->build_html( $post_id, $image_ids, true ) . $excerpt;
	}

	public function output_via_theme_hook() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		$post_id = get_queried_object_id();
		$image_ids = $this->is_eligible_post( $post_id );
		if ( ! $image_ids ) {
			return;
		}
		$this->rendered_via_theme_hook = true;
		wp_enqueue_style( 'gpc-carousel', GPC_URL . 'assets/css/gpc-carousel.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-carousel', GPC_URL . 'assets/js/gpc-carousel.js', array( 'gpc-leaflet' ), GPC_VERSION, true );
		// Same free OpenStreetMap/Leaflet setup used by the submission form's
		// pin picker — reusing the same handle names means WP just shares
		// the one script/style if both happen to load on the same page.
		wp_enqueue_style( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
		echo $this->build_html( $post_id, $image_ids );
	}

	/* ---------------------------------------------------------- eligibility */

	private function get_settings() {
		return array(
			'category_id'    => (int) get_option( 'gpc_category_id', 0 ),
			'min_images'     => max( 2, (int) get_option( 'gpc_min_images', 2 ) ),
			'max_images'     => min( 11, max( 2, (int) get_option( 'gpc_max_images', 11 ) ) ),
			'autoplay'       => (bool) get_option( 'gpc_autoplay', 1 ),
			'autoplay_speed' => (int) get_option( 'gpc_autoplay_speed', 4000 ),
			'show_arrows'    => (bool) get_option( 'gpc_show_arrows', 1 ),
			'show_dots'      => (bool) get_option( 'gpc_show_dots', 1 ),
			'height'         => (int) get_option( 'gpc_height', 460 ),
			'grid_height'    => (int) get_option( 'gpc_grid_height', 200 ),
		);
	}

	/**
	 * Featured image first, then any other images uploaded directly into
	 * this post, deduplicated, capped at the configured maximum.
	 */
	public static function get_gallery_image_ids( $post_id, $max = 11 ) {
		$ids = array();
		$thumb_id = get_post_thumbnail_id( $post_id );
		if ( $thumb_id ) {
			$ids[] = (int) $thumb_id;
		}

		$attached = get_posts( array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'post_parent'    => $post_id,
			'numberposts'    => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'fields'         => 'ids',
		) );

		foreach ( $attached as $id ) {
			$ids[] = (int) $id;
		}

		$ids = array_values( array_unique( $ids ) );
		return array_slice( $ids, 0, $max );
	}

	private function is_eligible_post( $post_id ) {
		$settings = $this->get_settings();
		if ( $settings['category_id'] && ! has_category( $settings['category_id'], $post_id ) ) {
			return false;
		}
		$ids = self::get_gallery_image_ids( $post_id, $settings['max_images'] );
		return count( $ids ) >= $settings['min_images'] ? $ids : false;
	}

	/* ---------------------------------------------------------- markup */

	private function build_html( $post_id, $image_ids, $is_grid = false ) {
		$settings = $this->get_settings();
		$uid = 'gpc-' . $post_id . ( $is_grid ? '-grid' : '' );
		$height = $is_grid ? $settings['grid_height'] : $settings['height'];

		// The poster's own address text, typed into the "Location" field on
		// the frontend submission form (class-gpc-frontend-submit.php) and
		// saved as _gpc_location — plus, if they used the map picker, the
		// exact pin they dropped/dragged, saved as _gpc_lat/_gpc_lng. The
		// pin is preferred when present since it's the poster's actual
		// chosen spot rather than a guess at what their typed address means;
		// listings submitted before the map picker existed simply won't
		// have it, and fall back to resolving the text address instead.
		$location = get_post_meta( $post_id, '_gpc_location', true );
		$lat = get_post_meta( $post_id, '_gpc_lat', true );
		$lng = get_post_meta( $post_id, '_gpc_lng', true );
		$has_pin = ( $lat !== '' && $lng !== '' && is_numeric( $lat ) && is_numeric( $lng ) );
		$has_map = ( $has_pin || $location !== '' );
		$map_title = $location !== '' ? sprintf( 'Map showing %s', $location ) : 'Map showing this listing\'s location';

		ob_start();
		?>
		<div class="gpc-carousel-outer<?php echo $is_grid ? ' gpc-carousel-grid' : ''; ?>" id="<?php echo esc_attr( $uid ); ?>"
			data-autoplay="<?php echo $settings['autoplay'] ? '1' : '0'; ?>"
			data-speed="<?php echo esc_attr( $settings['autoplay_speed'] ); ?>"
			style="--gpc-height:<?php echo esc_attr( $height ); ?>px;">
			<div class="gpc-track">
				<?php foreach ( $image_ids as $i => $id ) : ?>
					<div class="gpc-slide <?php echo $i === 0 ? 'is-active' : ''; ?>">
						<?php echo wp_get_attachment_image( $id, 'large', false, array( 'loading' => 'eager', 'class' => 'gpc-slide-img' ) ); ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $has_map ) : ?>
				<!-- Map pane sits inset:0 inside this same box, so it can never
				     render bigger than the carousel already is — it swaps in
				     over the photos instead of opening anything larger. The
				     Leaflet/OpenStreetMap map itself is only initialized once
				     someone actually taps the Map button (see gpc-carousel.js) —
				     no Google Maps embed, no API key, nothing to silently break. -->
				<div class="gpc-map-pane">
					<div class="gpc-leaflet-embed"
						data-lat="<?php echo $has_pin ? esc_attr( $lat ) : ''; ?>"
						data-lng="<?php echo $has_pin ? esc_attr( $lng ) : ''; ?>"
						data-location="<?php echo esc_attr( $location ); ?>"
						title="<?php echo esc_attr( $map_title ); ?>"></div>
				</div>
				<button type="button" class="gpc-map-toggle" aria-label="Show this listing's location on a map">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
					<span class="gpc-map-toggle-label">Map</span>
				</button>
			<?php endif; ?>

			<?php if ( $settings['show_arrows'] && count( $image_ids ) > 1 ) : ?>
				<button type="button" class="gpc-arrow gpc-prev" aria-label="Previous image">&#10094;</button>
				<button type="button" class="gpc-arrow gpc-next" aria-label="Next image">&#10095;</button>
			<?php endif; ?>

			<?php if ( $settings['show_dots'] && count( $image_ids ) > 1 ) : ?>
				<div class="gpc-dots">
					<?php foreach ( $image_ids as $i => $id ) : ?>
						<button type="button" class="gpc-dot <?php echo $i === 0 ? 'is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>" aria-label="Go to image <?php echo esc_attr( $i + 1 ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/* ---------------------------------------------------------- injection */

	public function maybe_start() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		$post_id = get_queried_object_id();
		$image_ids = $this->is_eligible_post( $post_id );
		if ( ! $image_ids ) {
			return;
		}

		$this->carousel_html = $this->build_html( $post_id, $image_ids );

		wp_enqueue_style( 'gpc-carousel', GPC_URL . 'assets/css/gpc-carousel.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-carousel', GPC_URL . 'assets/js/gpc-carousel.js', array( 'gpc-leaflet' ), GPC_VERSION, true );
		// Same free OpenStreetMap/Leaflet setup used by the submission form's
		// pin picker — reusing the same handle names means WP just shares
		// the one script/style if both happen to load on the same page.
		wp_enqueue_style( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );

		// Fallback for any theme without GridBit's after-title hook: the
		// content block always renders after the title, so prepending
		// here naturally lands the carousel below the title too. If the
		// theme hook already fired (checked inside prepend_to_content),
		// this is skipped so the carousel never shows twice.
		add_filter( 'the_content', array( $this, 'prepend_to_content' ), 1 );
	}

	public function prepend_to_content( $content ) {
		if ( doing_filter( 'get_the_excerpt' ) ) {
			return $content; // WordPress runs the_content a second time internally while auto-building excerpts — don't inject there.
		}
		if ( $this->rendered_via_theme_hook || ! $this->carousel_html ) {
			return $content;
		}
		$html = $this->carousel_html;
		$this->carousel_html = null; // only once
		return $html . $content;
	}
}
