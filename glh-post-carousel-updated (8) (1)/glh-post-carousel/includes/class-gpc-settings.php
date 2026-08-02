<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GPC_Settings {

	const OPTION_GROUP = 'gpc_settings_group';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function add_menu() {
		add_menu_page( 'Property Carousel', 'Property Carousel', 'manage_options', 'gpc-settings', array( $this, 'render' ), 'dashicons-images-alt2', 59 );
		add_submenu_page( 'gpc-settings', 'Settings', 'Settings', 'manage_options', 'gpc-settings', array( $this, 'render' ) );
	}

	public function register_settings() {
		$fields = array(
			'gpc_category_id'     => 'absint',
			'gpc_min_images'      => 'absint',
			'gpc_max_images'      => 'absint',
			'gpc_autoplay'        => 'absint',
			'gpc_autoplay_speed'  => 'absint',
			'gpc_show_arrows'     => 'absint',
			'gpc_show_dots'       => 'absint',
			'gpc_height'          => 'absint',
			'gpc_grid_height'     => 'absint',
			'gpc_frontend_submit_enabled'    => 'absint',
			'gpc_frontend_submit_autopublish'=> 'absint',
		);
		foreach ( $fields as $option => $sanitize ) {
			register_setting( self::OPTION_GROUP, $option, array( 'sanitize_callback' => $sanitize ) );
		}
	}

	public function render() {
		if ( ! current_user_can( 'manage_options' ) ) return;

		if ( isset( $_POST['gpc_types_nonce'] ) && wp_verify_nonce( $_POST['gpc_types_nonce'], 'gpc_types_save' ) ) {
			$this->save_type_options();
			echo '<div class="notice notice-success is-dismissible"><p>Post type options saved.</p></div>';
		}

		$categories = get_categories( array( 'hide_empty' => false ) );
		$get = function ( $key, $default ) { return get_option( $key, $default ); };

		$default_cat = 0;
		foreach ( $categories as $c ) {
			if ( $c->slug === 'properties' ) { $default_cat = $c->term_id; break; }
		}
		?>
		<div class="wrap">
			<h1>Property Carousel Settings</h1>
			<p>This section controls the image carousel that appears below the title on single property posts. Nothing shows unless a post has at least the minimum number of images below, and nothing shows on posts outside the chosen category.</p>

			<h2>Post type options (shown in the "Add a post" dropdown)</h2>
			<p class="description">The type whose slug is exactly <code>properties</code> is treated as the Property type — pick it below and its sub-categories become a second dropdown on the form (e.g. Houses, Flats &amp; Apartments, Land, Commercial, Shortlets). Leave a row blank to skip it. This table is saved separately — use its own "Save post types" button below.</p>
			<form method="post">
				<?php wp_nonce_field( 'gpc_types_save', 'gpc_types_nonce' ); ?>
				<table class="widefat" style="max-width:600px;">
					<thead><tr><th>Label (shown to users)</th><th style="width:200px;">Slug</th></tr></thead>
					<tbody>
					<?php foreach ( $this->get_type_rows() as $row ) : ?>
						<tr>
							<td><input type="text" name="gpc_type_label[]" value="<?php echo esc_attr( $row['label'] ); ?>" style="width:100%;"></td>
							<td><input type="text" name="gpc_type_slug[]" value="<?php echo esc_attr( $row['slug'] ); ?>" style="width:100%;" placeholder="auto from label if blank"></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>

				<h3 style="margin-top:24px;">Property sub-categories</h3>
				<p class="description">Shown as a second dropdown only when the user picks the Property type above.</p>
				<table class="widefat" style="max-width:600px;">
					<thead><tr><th>Label</th><th style="width:200px;">Slug</th></tr></thead>
					<tbody>
					<?php foreach ( $this->get_subcat_rows() as $row ) : ?>
						<tr>
							<td><input type="text" name="gpc_subcat_label[]" value="<?php echo esc_attr( $row['label'] ); ?>" style="width:100%;"></td>
							<td><input type="text" name="gpc_subcat_slug[]" value="<?php echo esc_attr( $row['slug'] ); ?>" style="width:100%;" placeholder="auto from label if blank"></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<p><button type="submit" class="button button-primary">Save post types</button></p>
			</form>

			<hr>

			<form method="post" action="options.php">
				<?php settings_fields( self::OPTION_GROUP ); ?>

				<h2>Which posts get a carousel</h2>
				<table class="form-table">
					<tr>
						<th>Category</th>
						<td>
							<select name="gpc_category_id">
								<option value="0">Any category</option>
								<?php foreach ( $categories as $c ) : ?>
									<option value="<?php echo esc_attr( $c->term_id ); ?>" <?php selected( $get( 'gpc_category_id', $default_cat ), $c->term_id ); ?>><?php echo esc_html( $c->name ); ?></option>
								<?php endforeach; ?>
							</select>
							<p class="description">Only posts filed under this category will ever show a carousel. Choose Properties, or whichever category holds your listings.</p>
						</td>
					</tr>
					<tr>
						<th>Minimum images required</th>
						<td>
							<input type="number" min="2" max="11" name="gpc_min_images" value="<?php echo esc_attr( $get( 'gpc_min_images', 2 ) ); ?>">
							<p class="description">A post needs at least this many images, counting the featured image, before a carousel appears. Anything below this and the post displays normally with no carousel at all.</p>
						</td>
					</tr>
					<tr>
						<th>Maximum images shown</th>
						<td>
							<input type="number" min="2" max="11" name="gpc_max_images" value="<?php echo esc_attr( $get( 'gpc_max_images', 11 ) ); ?>">
							<p class="description">Even if a post has more pictures attached than this, only this many will be included in the carousel. The highest allowed value is eleven.</p>
						</td>
					</tr>
				</table>


				<table class="form-table">
					<tr>
						<th>Height (single post page)</th>
						<td><input type="number" min="200" max="900" name="gpc_height" value="<?php echo esc_attr( $get( 'gpc_height', 460 ) ); ?>"> pixels</td>
					</tr>
					<tr>
						<th>Height (blog listing card)</th>
						<td><input type="number" min="100" max="500" name="gpc_grid_height" value="<?php echo esc_attr( $get( 'gpc_grid_height', 200 ) ); ?>"> pixels — kept small and contained, like a Google search result's photo strip</td>
					</tr>
					<tr>
						<th>Automatic sliding</th>
						<td><label><input type="checkbox" name="gpc_autoplay" value="1" <?php checked( $get( 'gpc_autoplay', 1 ), 1 ); ?>> Slide automatically</label></td>
					</tr>
					<tr>
						<th>Time between slides</th>
						<td><input type="number" min="1500" max="15000" step="500" name="gpc_autoplay_speed" value="<?php echo esc_attr( $get( 'gpc_autoplay_speed', 4000 ) ); ?>"> milliseconds</td>
					</tr>
					<tr>
						<th>Arrows</th>
						<td><label><input type="checkbox" name="gpc_show_arrows" value="1" <?php checked( $get( 'gpc_show_arrows', 1 ), 1 ); ?>> Show left and right arrows</label></td>
					</tr>
					<tr>
						<th>Dots</th>
						<td><label><input type="checkbox" name="gpc_show_dots" value="1" <?php checked( $get( 'gpc_show_dots', 1 ), 1 ); ?>> Show the small dots below the carousel</label></td>
					</tr>
				</table>

				<h2>Letting users submit their own posts</h2>
				<table class="form-table">
					<tr>
						<th>Frontend submit button</th>
						<td>
							<label><input type="checkbox" name="gpc_frontend_submit_enabled" value="1" <?php checked( $get( 'gpc_frontend_submit_enabled', 1 ), 1 ); ?>> Show a floating button that lets visitors submit their own post</label>
							<p class="description">Covers properties, looking for tenants, car rentals, investment opportunities, and general posts, with photos, a link, tags, and a category, all from the frontend. Available to every visitor, logged in or not.</p>
						</td>
					</tr>
					<tr>
						<th>Publishing</th>
						<td>
							<label><input type="checkbox" name="gpc_frontend_submit_autopublish" value="1" <?php checked( $get( 'gpc_frontend_submit_autopublish', 0 ), 1 ); ?>> Publish submissions immediately</label>
							<p class="description">Off by default. While off, every submission is held as a draft awaiting your review before it goes live, which is the safer choice for a public submission form.</p>
						</td>
					</tr>
				</table>

				<?php submit_button( 'Save settings' ); ?>
			</form>

			<hr>
			<h2>Where images come from</h2>
			<p>For every qualifying post, the carousel uses the featured image first, followed by any other pictures that were uploaded directly into that post. Nothing needs to be configured for this to work with posts you create by hand. The Bulk Publisher page can also create these posts for you with their own separate pictures already attached, ready to go.</p>
		</div>
		<?php
	}

	/** Default post type rows (used until the admin saves their own list). */
	public function get_type_rows() {
		$saved = get_option( 'gpc_type_rows', '' );
		if ( $saved && is_array( $saved ) && $saved ) {
			$rows = $saved;
		} else {
			$rows = array(
				array( 'label' => 'Property',               'slug' => 'properties' ),
				array( 'label' => 'Looking for Tenants',     'slug' => 'looking-for-tenants' ),
				array( 'label' => 'Car Rental',               'slug' => 'car-rentals' ),
				array( 'label' => 'Investment Opportunity',  'slug' => 'investment-opportunities' ),
				array( 'label' => 'General Post',            'slug' => 'general' ),
			);
		}
		while ( count( $rows ) < 8 ) $rows[] = array( 'label' => '', 'slug' => '' );
		return $rows;
	}

	/** Default Property sub-category rows. */
	public function get_subcat_rows() {
		$saved = get_option( 'gpc_subcat_rows', '' );
		if ( $saved && is_array( $saved ) && $saved ) {
			$rows = $saved;
		} else {
			$rows = array(
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
			);
		}
		while ( count( $rows ) < 10 ) $rows[] = array( 'label' => '', 'slug' => '' );
		return $rows;
	}

	private function save_type_options() {
		$labels = wp_unslash( $_POST['gpc_type_label'] ?? array() );
		$slugs  = wp_unslash( $_POST['gpc_type_slug'] ?? array() );
		$rows = array();
		for ( $i = 0; $i < count( $labels ); $i++ ) {
			$label = sanitize_text_field( $labels[ $i ] ?? '' );
			if ( $label === '' ) continue;
			$slug = sanitize_title( $slugs[ $i ] ?? '' );
			if ( $slug === '' ) $slug = sanitize_title( $label );
			$rows[] = array( 'label' => $label, 'slug' => $slug );
		}
		update_option( 'gpc_type_rows', $rows );

		$sub_labels = wp_unslash( $_POST['gpc_subcat_label'] ?? array() );
		$sub_slugs  = wp_unslash( $_POST['gpc_subcat_slug'] ?? array() );
		$sub_rows = array();
		for ( $i = 0; $i < count( $sub_labels ); $i++ ) {
			$label = sanitize_text_field( $sub_labels[ $i ] ?? '' );
			if ( $label === '' ) continue;
			$slug = sanitize_title( $sub_slugs[ $i ] ?? '' );
			if ( $slug === '' ) $slug = sanitize_title( $label );
			$sub_rows[] = array( 'label' => $label, 'slug' => $slug );
		}
		update_option( 'gpc_subcat_rows', $sub_rows );
	}
}
