<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lets any visitor — logged in or not — submit their own post from the
 * frontend: a property, a "looking for tenants" listing, car rental,
 * investment opportunity, or a general post, through a floating button.
 *
 * Submissions default to "pending" status (held for admin review before
 * going live) unless the admin turns on auto-publish in Settings. This
 * is a real anti-spam default, not an inconvenience — anyone can submit
 * a form, so nothing goes live unreviewed unless the admin chooses that.
 */
class GPC_Frontend_Submit {

	public function __construct() {
		add_action( 'wp_footer', array( $this, 'render_button_and_modal' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue' ) );
		add_action( 'wp_ajax_gpc_frontend_submit', array( $this, 'ajax_submit' ) );
		add_action( 'wp_ajax_nopriv_gpc_frontend_submit', array( $this, 'ajax_submit' ) );
		add_action( 'wp_ajax_gpc_frontend_edit_fetch', array( $this, 'ajax_edit_fetch' ) );
	}

	private function should_show() {
		if ( is_admin() ) {
			return false;
		}
		return (bool) get_option( 'gpc_frontend_submit_enabled', 1 );
	}

	public function maybe_enqueue() {
		if ( ! $this->should_show() ) {
			return;
		}
		wp_enqueue_style( 'gpc-frontend-submit', GPC_URL . 'assets/css/gpc-frontend-submit.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-frontend-submit', GPC_URL . 'assets/js/gpc-frontend-submit.js', array(), GPC_VERSION, true );

		// Location picker: Leaflet is free/open-source and needs no API key
		// (unlike Google's JS Maps API), which is why it's used here for the
		// interactive pin-drop in the submission form.
		wp_enqueue_style( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'gpc-leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
		wp_enqueue_style( 'gpc-map-picker', GPC_URL . 'assets/css/gpc-map-picker.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-map-picker', GPC_URL . 'assets/js/gpc-map-picker.js', array( 'gpc-leaflet' ), GPC_VERSION, true );

		$plans   = get_option( 'glh_ad_pricing_plans', array() );
		$subcats = $this->subcat_options();
		wp_localize_script( 'gpc-frontend-submit', 'gpcSubmitData', array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'nonce'        => wp_create_nonce( 'gpc_frontend_submit_nonce' ),
			'maxImages'    => 11,
			'minImages'    => 2,
			'adPlans'      => is_array( $plans ) ? array_values( $plans ) : array(),
			'propertyTypeSlugs' => array( 'properties', 'rent', 'housing', 'short-let', 'hotel' ),
			'subcats'      => $subcats,
		) );
	}

	/**
	 * Property Type dropdown options. Configurable under 🎠 Property
	 * Carousel → Settings → "Property sub-categories". Falls back to a
	 * full, sensible default list so the dropdown is never empty on a
	 * fresh install — before this fix, an unconfigured site got zero
	 * options and users had nothing to pick from.
	 */
	private function subcat_options() {
		$saved = get_option( 'gpc_subcat_rows', array() );
		if ( is_array( $saved ) && $saved ) {
			$rows = array_values( array_filter( $saved, function ( $r ) { return ! empty( $r['label'] ); } ) );
			if ( $rows ) return $rows;
		}
		return array(
			array( 'label' => 'Detached House',      'slug' => 'detached-house' ),
			array( 'label' => 'Semi-Detached House',  'slug' => 'semi-detached-house' ),
			array( 'label' => 'Terrace / Row House',  'slug' => 'terrace-house' ),
			array( 'label' => 'Duplex',                'slug' => 'duplex' ),
			array( 'label' => 'Bungalow',              'slug' => 'bungalow' ),
			array( 'label' => 'Flat / Apartment',      'slug' => 'flat-apartment' ),
			array( 'label' => 'Mini Flat / Self-Con',  'slug' => 'mini-flat' ),
			array( 'label' => 'Studio Apartment',      'slug' => 'studio-apartment' ),
			array( 'label' => 'Penthouse',             'slug' => 'penthouse' ),
			array( 'label' => 'Land / Plot',           'slug' => 'land-plot' ),
			array( 'label' => 'Commercial Property',   'slug' => 'commercial-property' ),
			array( 'label' => 'Office Space',          'slug' => 'office-space' ),
			array( 'label' => 'Shop / Store',          'slug' => 'shop-store' ),
			array( 'label' => 'Warehouse',             'slug' => 'warehouse' ),
			array( 'label' => 'Hotel / Shortlet',      'slug' => 'hotel-shortlet' ),
		);
	}

	private function post_type_options() {
		// Label => category slug. Configurable under 🎠 Property Carousel →
		// Settings → "Post type options". Falls back to sensible defaults
		// for a property/community site if nothing has been saved yet.
		$saved = get_option( 'gpc_type_rows', array() );
		if ( is_array( $saved ) && $saved ) {
			$out = array();
			foreach ( $saved as $row ) {
				if ( empty( $row['label'] ) ) continue;
				$out[ $row['label'] ] = $row['slug'];
			}
			if ( $out ) return $out;
		}
		return array(
			'Property (For Sale)'    => 'properties',
			'Rent'                   => 'rent',
			'Housing'                => 'housing',
			'Short-Let'              => 'short-let',
			'Hotel / Room'           => 'hotel',
			'Looking for Tenants'    => 'looking-for-tenants',
			'Car Rental'             => 'car-rentals',
			'Investment Opportunity' => 'investment-opportunities',
			'General Post'          => 'general',
		);
	}

	public function render_button_and_modal() {
		if ( ! $this->should_show() ) {
			return;
		}
		$types = $this->post_type_options();
		?>
		<button type="button" id="gpcSubmitFab" class="gpc-submit-fab" aria-label="Add a post">
			<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
		</button>

		<div class="gpc-submit-overlay" id="gpcSubmitOverlay">
			<div class="gpc-submit-modal">
				<button type="button" class="gpc-submit-close" id="gpcSubmitClose" aria-label="Close">✕</button>
				<h2 id="gpcSubmitHeading">Add a post</h2>
				<p class="gpc-submit-note" id="gpcSubmitNote">Your post will be reviewed before it appears on the site.</p>

				<form id="gpcSubmitForm" enctype="multipart/form-data">
					<input type="hidden" id="gpcEditPostId" value="">
					<label class="gpc-submit-label">What kind of post is this</label>
					<select id="gpcSubmitType" class="gpc-submit-input" required>
						<?php foreach ( $types as $label => $slug ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
						<option value="ads">📢 Advertise (Banner Ad)</option>
					</select>

					<label class="gpc-submit-label">Title</label>
					<input type="text" id="gpcSubmitTitle" class="gpc-submit-input" placeholder="e.g. 3 Bedroom Duplex in Lekki" required>

					<label class="gpc-submit-label">Description</label>
					<textarea id="gpcSubmitDescription" class="gpc-submit-input gpc-submit-textarea" placeholder="Describe it..." required></textarea>

					<div id="gpcRegularFields">
					<?php if ( current_user_can( 'manage_options' ) ) : ?>
						<label class="gpc-submit-label" style="display:flex;align-items:center;gap:8px;">
							<input type="checkbox" id="gpcMarkAsAd" value="1"> Tag this as an ad <span class="gpc-submit-optional">(shows a red "AD" ribbon on the post — admin only)</span>
						</label>
					<?php endif; ?>

						<label class="gpc-submit-label" id="gpcSubcatLabel" style="display:none;">Property type</label>
						<select id="gpcSubcat" class="gpc-submit-input" style="display:none;"></select>

						<div id="gpcPropertyFields" style="display:none;">
							<label class="gpc-submit-label">Bedrooms <span class="gpc-submit-optional">(leave blank if not applicable)</span></label>
							<input type="number" min="0" id="gpcBedrooms" class="gpc-submit-input" placeholder="e.g. 4">

							<label class="gpc-submit-label">Bathrooms <span class="gpc-submit-optional">(leave blank if not applicable)</span></label>
							<input type="number" min="0" id="gpcBathrooms" class="gpc-submit-input" placeholder="e.g. 3">

							<label class="gpc-submit-label">Toilets <span class="gpc-submit-optional">(leave blank if not applicable)</span></label>
							<input type="number" min="0" id="gpcToilets" class="gpc-submit-input" placeholder="e.g. 5">

							<label class="gpc-submit-label">Location</label>
							<input type="text" id="gpcLocation" class="gpc-submit-input" placeholder="e.g. Lekki Phase 1, Lagos">

							<div class="gpc-map-picker" id="gpcMapPicker">
								<div class="gpc-map-picker-row">
									<button type="button" class="gpc-submit-btn-secondary gpc-map-picker-btn" id="gpcMapFindBtn">Find on map</button>
									<button type="button" class="gpc-submit-btn-secondary gpc-map-picker-btn" id="gpcMapMyLocationBtn">Use my current location</button>
								</div>
								<p class="gpc-submit-optional gpc-map-picker-hint">Optional — drag the pin to your exact spot for a more accurate map on your listing. If you skip this, the typed address above is used instead.</p>
								<div class="gpc-map-picker-map" id="gpcMapPickerMap"></div>
								<input type="hidden" id="gpcLat" value="">
								<input type="hidden" id="gpcLng" value="">
							</div>

							<label class="gpc-submit-label">Price</label>
							<input type="text" id="gpcPrice" class="gpc-submit-input" placeholder="e.g. ₦45,000,000 or ₦2,500,000/year">
						</div>

						<label class="gpc-submit-label">Tags <span class="gpc-submit-optional">(optional, comma separated)</span></label>
						<input type="text" id="gpcSubmitTags" class="gpc-submit-input" placeholder="lekki, duplex, furnished">

						<label class="gpc-submit-label">Link <span class="gpc-submit-optional">(optional — a website, WhatsApp link, or similar)</span></label>
						<input type="url" id="gpcSubmitLink" class="gpc-submit-input" placeholder="https://">

						<label class="gpc-submit-label" id="gpcPhotosLabel">Photos <span class="gpc-submit-optional">(2 to 11 — the first becomes the featured image and the carousel uses all of them)</span></label>
						<div class="gpc-submit-pool-grid" id="gpcExistingPhotosGrid" style="display:none;"></div>
						<div class="gpc-submit-drop-zone" id="gpcSubmitDropZone">
							<input type="file" id="gpcSubmitImages" accept="image/*" multiple style="display:none;">
							<button type="button" class="gpc-submit-btn-secondary" id="gpcSubmitPickBtn">Choose photos</button>
						</div>
						<div class="gpc-submit-pool-grid" id="gpcSubmitPoolGrid"></div>
					</div>

					<div id="gpcAdFields" style="display:none;">
						<label class="gpc-submit-label">Brand Name</label>
						<input type="text" id="gpcAdBrand" class="gpc-submit-input" placeholder="e.g. OpinionMarket">

						<label class="gpc-submit-label">Redirect Link <span class="gpc-submit-optional">(where people go when they tap your ad)</span></label>
						<input type="url" id="gpcAdLink" class="gpc-submit-input" placeholder="https://yourbrand.com">

						<label class="gpc-submit-label">Banner Image <span class="gpc-submit-optional">(required — this is what shows as your ad)</span></label>
						<div class="gpc-submit-drop-zone" id="gpcAdBannerZone">
							<input type="file" id="gpcAdBanner" accept="image/*" style="display:none;">
							<button type="button" class="gpc-submit-btn-secondary" id="gpcAdBannerPickBtn">Choose banner image</button>
						</div>
						<div class="gpc-submit-pool-grid" id="gpcAdBannerPreview"></div>

						<label class="gpc-submit-label">Plan</label>
						<select id="gpcAdPlan" class="gpc-submit-input">
							<option value="">Loading plans…</option>
						</select>

						<label class="gpc-submit-label">Who should see this ad? — Age range <span class="gpc-submit-optional">(optional)</span></label>
						<div style="display:flex;gap:10px;">
							<input type="number" min="0" max="120" id="gpcAdAgeMin" class="gpc-submit-input" placeholder="Min age e.g. 18" style="flex:1;">
							<input type="number" min="0" max="120" id="gpcAdAgeMax" class="gpc-submit-input" placeholder="Max age, blank = unlimited" style="flex:1;">
						</div>

						<label class="gpc-submit-label">Who should see this ad? — Country <span class="gpc-submit-optional">(optional)</span></label>
						<input type="text" id="gpcAdCountry" class="gpc-submit-input" placeholder="e.g. Nigeria — leave blank for all countries">

						<p class="gpc-submit-note">Your ad goes live once the admin confirms your payment.</p>
					</div>

					<button type="submit" class="gpc-submit-btn-primary" id="gpcSubmitBtn">Submit for review</button>
					<div id="gpcSubmitMsg" class="gpc-submit-msg"></div>
				</form>
			</div>
		</div>
		<?php
	}

	/* ---------------------------------------------------------- ajax */

	/**
	 * Feeds the frontend edit modal the current data for a listing so it
	 * can prefill itself, instead of sending the person to wp-admin.
	 * Only the listing's own author or an admin may fetch it.
	 */
	public function ajax_edit_fetch() {
		check_ajax_referer( 'gpc_frontend_submit_nonce', 'nonce' );

		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'You need to be logged in to edit a post.' ) );
		}

		$post_id = absint( $_POST['post_id'] ?? 0 );
		$post    = $post_id ? get_post( $post_id ) : null;

		if ( ! $post || 'post' !== $post->post_type ) {
			wp_send_json_error( array( 'message' => 'That post could not be found.' ) );
		}

		$current_uid = get_current_user_id();
		if ( (int) $post->post_author !== $current_uid && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'You can only edit your own posts.' ) );
		}

		// Work out which "type" (top-level category) and, if it's a
		// property, which subcategory this post belongs to, so the form
		// can restore the same dropdown selections it was created with.
		$types_map    = $this->post_type_options();
		$known_slugs  = array_values( $types_map );
		$type_slug    = 'general';
		$subcat_slug  = '';
		$cats         = get_the_category( $post_id );
		foreach ( $cats as $cat ) {
			if ( in_array( $cat->slug, $known_slugs, true ) ) {
				$type_slug = $cat->slug;
			}
		}
		foreach ( $cats as $cat ) {
			if ( $cat->parent ) {
				$parent = get_term( $cat->parent, 'category' );
				if ( $parent && ! is_wp_error( $parent ) && $parent->slug === $type_slug ) {
					$subcat_slug = $cat->slug;
				}
			}
		}

		// Existing photos, for the read-only "current photos" preview.
		$photos = array();
		$thumb_id = get_post_thumbnail_id( $post_id );
		$attachments = get_attached_media( 'image', $post_id );
		$seen = array();
		if ( $thumb_id ) {
			$photos[] = array( 'id' => $thumb_id, 'url' => wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) );
			$seen[ $thumb_id ] = true;
		}
		foreach ( $attachments as $att ) {
			if ( isset( $seen[ $att->ID ] ) ) continue;
			$photos[] = array( 'id' => $att->ID, 'url' => wp_get_attachment_image_url( $att->ID, 'thumbnail' ) );
			$seen[ $att->ID ] = true;
		}

		// Description shown for editing is the raw content minus the
		// separately-tracked link (if this post was created/edited after
		// the _gpc_link meta was introduced), so re-saving doesn't
		// duplicate the link inside the text.
		$stored_link = get_post_meta( $post_id, '_gpc_link', true );
		$description = $this->plain_text_description( $post->post_content );
		if ( $stored_link ) {
			$description = preg_replace( '/\s*' . preg_quote( $stored_link, '/' ) . '\s*$/', '', $description );
		}

		wp_send_json_success( array(
			'title'       => $post->post_title,
			'description' => $description,
			'type'        => $type_slug,
			'subcat'      => $subcat_slug,
			'bedrooms'    => get_post_meta( $post_id, '_gpc_bedrooms', true ),
			'bathrooms'   => get_post_meta( $post_id, '_gpc_bathrooms', true ),
			'toilets'     => get_post_meta( $post_id, '_gpc_toilets', true ),
			'location'    => get_post_meta( $post_id, '_gpc_location', true ),
			'price'       => get_post_meta( $post_id, '_gpc_price', true ),
			'lat'         => get_post_meta( $post_id, '_gpc_lat', true ),
			'lng'         => get_post_meta( $post_id, '_gpc_lng', true ),
			'link'        => $stored_link,
			'tags'        => implode( ', ', wp_list_pluck( get_the_tags( $post_id ) ?: array(), 'name' ) ),
			'photos'      => $photos,
		) );
	}

	/**
	 * Converts a post's stored content — which may be plain text (posts
	 * created through this plugin) or full Gutenberg block markup (posts
	 * created/edited in wp-admin, including WordPress's own default
	 * posts) — into clean plain text suitable for a plain <textarea>.
	 */
	private function plain_text_description( $content ) {
		$text = preg_replace( '/<!--\s*\/?wp:.*?-->/s', '', $content );
		$text = preg_replace( '/<(br|\/p|\/div|\/li)\s*\/?>/i', "\n", $text );
		$text = wp_strip_all_tags( $text );
		$text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
		$text = preg_replace( "/\n{3,}/", "\n\n", $text );
		return trim( $text );
	}

	public function ajax_submit() {
		check_ajax_referer( 'gpc_frontend_submit_nonce', 'nonce' );

		$title       = sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) );
		$description = sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) );
		$type_slug   = sanitize_title( wp_unslash( $_POST['type'] ?? 'general' ) );

		if ( $title === '' || $description === '' ) {
			wp_send_json_error( array( 'message' => 'A title and description are required' ) );
		}

		// Editing an existing listing rather than creating a new one.
		$edit_post_id = absint( $_POST['edit_post_id'] ?? 0 );
		$editing_post = null;
		if ( $edit_post_id ) {
			$editing_post = get_post( $edit_post_id );
			if ( ! $editing_post || 'post' !== $editing_post->post_type ) {
				wp_send_json_error( array( 'message' => 'That post could not be found.' ) );
			}
			if ( (int) $editing_post->post_author !== get_current_user_id() && ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => 'You can only edit your own posts.' ) );
			}
		}

		if ( 'ads' !== $type_slug && ! $edit_post_id ) {
			$duplicate_of = $this->find_duplicate_listing( $title, $description, $type_slug );
			if ( $duplicate_of ) {
				wp_send_json_error( array(
					'message' => 'A listing with this exact title or description already exists on the site. Please make sure your title and description are unique before submitting.',
				) );
			}
		}

		if ( 'ads' === $type_slug ) {
			$this->handle_ad_submission( $title, $description );
			return; // handle_ad_submission always sends the JSON response itself
		}

		$tags_raw    = sanitize_text_field( wp_unslash( $_POST['tags'] ?? '' ) );
		$link        = esc_url_raw( wp_unslash( $_POST['link'] ?? '' ) );
		$subcat_slug = sanitize_title( wp_unslash( $_POST['subcat'] ?? '' ) );
		$bedrooms    = sanitize_text_field( wp_unslash( $_POST['bedrooms'] ?? '' ) );
		$bathrooms   = sanitize_text_field( wp_unslash( $_POST['bathrooms'] ?? '' ) );
		$toilets     = sanitize_text_field( wp_unslash( $_POST['toilets'] ?? '' ) );
		$location    = sanitize_text_field( wp_unslash( $_POST['location'] ?? '' ) );
		$price       = sanitize_text_field( wp_unslash( $_POST['price'] ?? '' ) );
		$is_property = in_array( $type_slug, array( 'properties', 'rent', 'housing', 'short-let', 'hotel' ), true );

		// Optional exact pin from the map picker. Only trusted if both
		// values are present and within real-world coordinate ranges —
		// otherwise the listing just falls back to the typed address text.
		$lat_raw = wp_unslash( $_POST['lat'] ?? '' );
		$lng_raw = wp_unslash( $_POST['lng'] ?? '' );
		$lat = ( $lat_raw !== '' && is_numeric( $lat_raw ) ) ? (float) $lat_raw : null;
		$lng = ( $lng_raw !== '' && is_numeric( $lng_raw ) ) ? (float) $lng_raw : null;
		if ( null !== $lat && ( $lat < -90 || $lat > 90 ) )    $lat = null;
		if ( null !== $lng && ( $lng < -180 || $lng > 180 ) )  $lng = null;
		if ( null === $lat || null === $lng ) { $lat = null; $lng = null; }

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		// Property listings must have at least one real photo — checked
		// before the post is even created, so nothing gets published
		// with WordPress's default placeholder image.
		$files = $this->reorganize_files_array( 'images' );
		$files = array_slice( $files, 0, 11 );
		$valid_files = array_values( array_filter( $files, function ( $f ) { return strpos( $f['type'], 'image/' ) === 0; } ) );

		$has_existing_photo = $edit_post_id ? (bool) get_post_thumbnail_id( $edit_post_id ) : false;
		if ( $is_property && empty( $valid_files ) && ! $has_existing_photo ) {
			wp_send_json_error( array( 'message' => 'Please add at least one photo — a featured image is required for property listings.' ) );
		}
		if ( $is_property && $location === '' && null === $lat ) {
			wp_send_json_error( array( 'message' => 'Location is required for property listings — type an address or drop a pin on the map.' ) );
		}
		if ( $is_property && $price === '' ) {
			wp_send_json_error( array( 'message' => 'Price is required for property listings.' ) );
		}

		$auto_publish = (bool) get_option( 'gpc_frontend_submit_autopublish', 0 );

		$content = $description;
		if ( $link ) {
			$content .= "\n\n" . esc_url( $link );
		}

		if ( $edit_post_id ) {
			$post_id = wp_update_post( array(
				'ID'           => $edit_post_id,
				'post_title'   => $title,
				'post_content' => $content,
			), true );
		} else {
			$post_id = wp_insert_post( array(
				'post_title'   => $title,
				'post_content' => $content,
				'post_status'  => $auto_publish ? 'publish' : 'pending',
				'post_author'  => get_current_user_id(),
				'post_type'    => 'post',
			), true );
		}

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error( array( 'message' => $post_id->get_error_message() ) );
		}

		update_post_meta( $post_id, '_gpc_link', $link );

		// Category — created on first use if it doesn't already exist.
		$term_ids = array();
		$term = get_term_by( 'slug', $type_slug, 'category' );
		if ( ! $term ) {
			$label = str_replace( '-', ' ', $type_slug );
			$new_term = wp_insert_term( ucwords( $label ), 'category', array( 'slug' => $type_slug ) );
			if ( ! is_wp_error( $new_term ) ) {
				$term_ids[] = (int) $new_term['term_id'];
			}
		} else {
			$term_ids[] = (int) $term->term_id;
		}

		// Property sub-category, nested under the Property term above.
		if ( $is_property && $subcat_slug !== '' ) {
			$parent_id = $term_ids ? $term_ids[0] : 0;
			$sub_term = get_term_by( 'slug', $subcat_slug, 'category' );
			if ( ! $sub_term ) {
				$sub_rows = $this->subcat_options();
				$sub_label = ucwords( str_replace( '-', ' ', $subcat_slug ) );
				foreach ( $sub_rows as $row ) {
					if ( isset( $row['slug'] ) && $row['slug'] === $subcat_slug ) { $sub_label = $row['label']; break; }
				}
				$new_sub = wp_insert_term( $sub_label, 'category', array( 'slug' => $subcat_slug, 'parent' => $parent_id ) );
				if ( ! is_wp_error( $new_sub ) ) $term_ids[] = (int) $new_sub['term_id'];
			} else {
				$term_ids[] = (int) $sub_term->term_id;
			}
		}
		if ( $term_ids ) wp_set_post_categories( $post_id, $term_ids );

		// Property details. On edit, an emptied field clears the stored
		// value instead of silently leaving the old one behind.
		if ( $is_property ) {
			if ( $bedrooms !== '' )  { update_post_meta( $post_id, '_gpc_bedrooms', $bedrooms ); }
			elseif ( $edit_post_id ) { delete_post_meta( $post_id, '_gpc_bedrooms' ); }
			if ( $bathrooms !== '' ) { update_post_meta( $post_id, '_gpc_bathrooms', $bathrooms ); }
			elseif ( $edit_post_id ) { delete_post_meta( $post_id, '_gpc_bathrooms' ); }
			if ( $toilets !== '' )   { update_post_meta( $post_id, '_gpc_toilets', $toilets ); }
			elseif ( $edit_post_id ) { delete_post_meta( $post_id, '_gpc_toilets' ); }
			if ( $location !== '' )  update_post_meta( $post_id, '_gpc_location', $location );
			if ( $price !== '' )     update_post_meta( $post_id, '_gpc_price', $price );
			if ( null !== $lat && null !== $lng ) {
				update_post_meta( $post_id, '_gpc_lat', $lat );
				update_post_meta( $post_id, '_gpc_lng', $lng );
			}
		}

		// "Mark as ad" ribbon — only ever honored for admins, never trust
		// the client-sent flag alone (the checkbox is hidden from non-admins
		// in the form, but a tampered request could still send it).
		if ( current_user_can( 'manage_options' ) && '1' === sanitize_text_field( wp_unslash( $_POST['is_ad'] ?? '' ) ) ) {
			update_post_meta( $post_id, '_gpc_is_ad', '1' );
		}

		// Tags.
		if ( $tags_raw !== '' ) {
			$tags = array_filter( array_map( 'trim', explode( ',', $tags_raw ) ) );
			if ( $tags ) {
				wp_set_post_tags( $post_id, $tags );
			}
		}

		// Photos — first one becomes the featured image, all of them
		// become the carousel's source.
		$attached_ids = array();
		foreach ( $valid_files as $file ) {
			$attachment_id = media_handle_sideload( $file, $post_id );
			if ( ! is_wp_error( $attachment_id ) ) {
				$attached_ids[] = $attachment_id;
			}
		}
		if ( $attached_ids && ! $has_existing_photo ) {
			set_post_thumbnail( $post_id, $attached_ids[0] );
		}

		$total_photos = $has_existing_photo ? ( count( $attached_ids ) + 1 ) : count( $attached_ids );
		$warning = '';
		if ( $total_photos < 2 ) {
			$warning = ' Add at least one more photo later so this post gets a carousel.';
		}

		if ( $edit_post_id ) {
			wp_send_json_success( array( 'message' => 'Your listing has been updated.' . $warning ) );
		}

		wp_send_json_success( array(
			'message' => $auto_publish
				? ( 'Your post is live.' . $warning )
				: ( 'Thanks, your post has been submitted and is waiting for review.' . $warning ),
		) );
	}

	/**
	 * Handles submissions where the user chose "Advertise (Banner Ad)".
	 * Creates a glh_ad_campaign post (the same CPT the admin's Ad
	 * Campaigns screen manages) with _glh_ad_active left OFF — it stays
	 * invisible on the site until the admin confirms payment and
	 * switches it on from the Ad Campaigns editor.
	 */
	private function handle_ad_submission( $title, $description ) {
		if ( ! post_type_exists( 'glh_ad_campaign' ) ) {
			wp_send_json_error( array( 'message' => 'Ads aren\'t available on this site right now — the Ad Campaigns plugin isn\'t active.' ) );
		}

		$brand   = sanitize_text_field( wp_unslash( $_POST['brand'] ?? '' ) );
		$link    = esc_url_raw( wp_unslash( $_POST['link'] ?? '' ) );
		$age_min = sanitize_text_field( wp_unslash( $_POST['age_min'] ?? '' ) );
		$age_max = sanitize_text_field( wp_unslash( $_POST['age_max'] ?? '' ) );
		$age = '';
		if ( $age_min !== '' && $age_max !== '' )      $age = $age_min . '–' . $age_max;
		elseif ( $age_min !== '' )                     $age = $age_min . '+';
		elseif ( $age_max !== '' )                     $age = 'Up to ' . $age_max;
		$country = sanitize_text_field( wp_unslash( $_POST['country'] ?? '' ) );
		$plan_idx = isset( $_POST['plan_index'] ) ? absint( $_POST['plan_index'] ) : -1;

		if ( $brand === '' )        wp_send_json_error( array( 'message' => 'Brand name is required' ) );
		if ( $link === '' )         wp_send_json_error( array( 'message' => 'A redirect link is required' ) );
		if ( empty( $_FILES['banner'] ) || empty( $_FILES['banner']['name'] ) ) {
			wp_send_json_error( array( 'message' => 'A banner image is required for ads' ) );
		}

		$plans = get_option( 'glh_ad_pricing_plans', array() );
		$plans = is_array( $plans ) ? array_values( $plans ) : array();
		$plan  = isset( $plans[ $plan_idx ] ) ? $plans[ $plan_idx ] : null;
		if ( ! $plan ) {
			wp_send_json_error( array( 'message' => 'Please choose a plan' ) );
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		if ( strpos( $_FILES['banner']['type'], 'image/' ) !== 0 ) {
			wp_send_json_error( array( 'message' => 'The banner file must be an image' ) );
		}

		$post_id = wp_insert_post( array(
			'post_type'   => 'glh_ad_campaign',
			'post_title'  => $title,
			'post_status' => 'publish', // visible in the admin's Ad Campaigns list; NOT live on the site until Active is switched on
		), true );

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error( array( 'message' => $post_id->get_error_message() ) );
		}

		$attachment_id = media_handle_upload( 'banner', $post_id );
		if ( is_wp_error( $attachment_id ) ) {
			wp_delete_post( $post_id, true );
			wp_send_json_error( array( 'message' => 'Could not upload the banner image: ' . $attachment_id->get_error_message() ) );
		}
		set_post_thumbnail( $post_id, $attachment_id );

		update_post_meta( $post_id, '_glh_ad_brand',           $brand );
		update_post_meta( $post_id, '_glh_ad_image_id',        $attachment_id );
		update_post_meta( $post_id, '_glh_ad_link',             $link );
		update_post_meta( $post_id, '_glh_ad_active',           '0' ); // admin turns this on after confirming payment
		update_post_meta( $post_id, '_glh_ad_order',            10 );
		update_post_meta( $post_id, '_glh_ad_pay_brand',        (float) $plan['amount'] );
		update_post_meta( $post_id, '_glh_ad_pay_user',         0 );
		update_post_meta( $post_id, '_glh_ad_days',             (int) $plan['days'] );
		update_post_meta( $post_id, '_glh_ad_plan_label',       $plan['label'] );
		update_post_meta( $post_id, '_glh_ad_target_age',       $age );
		update_post_meta( $post_id, '_glh_ad_target_country',   $country );
		update_post_meta( $post_id, '_glh_ad_submitted_by',     get_current_user_id() );
		update_post_meta( $post_id, '_glh_ad_description',      $description );

		wp_send_json_success( array(
			'message' => 'Thanks! Your ad has been submitted. It will go live once the admin confirms your payment (' . esc_html( $plan['label'] ) . ' — ₦' . number_format( (float) $plan['amount'], 2 ) . ').',
		) );
	}

	/**
	 * Case/whitespace-insensitive normalization so "3 Bedroom Duplex,
	 * Lekki" and "3  bedroom duplex, lekki " are recognized as the same
	 * listing rather than slipping through as "different" text.
	 */
	private function normalize_text( $text ) {
		$text = wp_strip_all_tags( (string) $text );
		$text = strtolower( $text );
		$text = preg_replace( '/\s+/', ' ', $text );
		return trim( $text );
	}

	/**
	 * Blocks a submission whose title or description exactly matches
	 * (after normalizing) an existing listing of the same type — this is
	 * what stops two different users (or the same user twice) from
	 * listing what is really the same property. Scoped to the same
	 * listing type so an identical title in "Car Rental" doesn't block
	 * an unrelated "General Post".
	 *
	 * @return int Post ID of the conflicting listing, or 0 if none found.
	 */
	private function find_duplicate_listing( $title, $description, $type_slug ) {
		$norm_title = $this->normalize_text( $title );
		$norm_desc  = $this->normalize_text( $description );

		$candidates = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => array( 'publish', 'pending', 'future', 'private' ),
			'category_name'  => $type_slug,
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		) );

		foreach ( $candidates as $candidate_id ) {
			$candidate = get_post( $candidate_id );
			if ( ! $candidate ) continue;

			if ( $this->normalize_text( $candidate->post_title ) === $norm_title ) {
				return $candidate_id;
			}
			if ( $norm_desc !== '' ) {
				$candidate_desc = $this->normalize_text( $candidate->post_content );
				if ( $candidate_desc === $norm_desc ) {
					return $candidate_id;
				}
			}
		}
		return 0;
	}

	private function reorganize_files_array( $field ) {
		$files = array();
		if ( empty( $_FILES[ $field ] ) || ! isset( $_FILES[ $field ]['name'] ) ) {
			return $files;
		}
		$raw = $_FILES[ $field ];
		if ( ! is_array( $raw['name'] ) ) {
			if ( $raw['name'] !== '' ) {
				$files[] = $raw;
			}
			return $files;
		}
		$count = count( $raw['name'] );
		for ( $i = 0; $i < $count; $i++ ) {
			if ( empty( $raw['name'][ $i ] ) ) continue;
			$files[] = array(
				'name'     => $raw['name'][ $i ],
				'type'     => $raw['type'][ $i ],
				'tmp_name' => $raw['tmp_name'][ $i ],
				'error'    => $raw['error'][ $i ],
				'size'     => $raw['size'][ $i ],
			);
		}
		return $files;
	}
}
