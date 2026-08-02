<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GPC_Bulk_Publisher {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_ajax_gpc_bulk_create_single', array( $this, 'ajax_create_single' ) );
		add_action( 'admin_init', array( $this, 'maybe_install_table' ) );
		add_action( 'admin_post_gpc_export_batches', array( $this, 'handle_export' ) );
		add_action( 'admin_post_gpc_import_batches', array( $this, 'handle_import' ) );
		add_action( 'admin_post_gpc_republish_batch', array( $this, 'handle_republish' ) );
		add_action( 'admin_post_gpc_delete_batch', array( $this, 'handle_delete' ) );
	}

	/* ---------------------------------------------------------- storage table */

	private static function table_name() {
		global $wpdb;
		return $wpdb->prefix . 'gpc_listing_batches';
	}

	/**
	 * Creates (or updates) the plugin's own "Saved Listings" table. Every
	 * post made through the Bulk Publisher — title, description, author
	 * details, category, and the image URLs used — is stored here, so the
	 * whole batch can be exported as a portable JSON file and imported +
	 * republished on a completely different WordPress install without
	 * retyping anything.
	 */
	public static function install_table() {
		global $wpdb;
		$table           = self::table_name();
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE {$table} (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
			title TEXT NOT NULL,
			description LONGTEXT NULL,
			author_name VARCHAR(190) NULL,
			author_email VARCHAR(190) NULL,
			author_bio TEXT NULL,
			category_name VARCHAR(190) NULL,
			post_status VARCHAR(20) NOT NULL DEFAULT 'draft',
			image_urls LONGTEXT NULL,
			source_site VARCHAR(190) NULL,
			local_post_id BIGINT UNSIGNED NULL,
			created_at DATETIME NOT NULL,
			PRIMARY KEY  (id)
		) {$charset_collate};";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		update_option( 'gpc_listings_table_installed', GPC_VERSION );
	}

	/**
	 * Safety net: if the plugin was copied into a new install without the
	 * activation hook firing (e.g. some one-click installers skip it),
	 * create the table the first time an admin screen loads.
	 */
	public function maybe_install_table() {
		if ( get_option( 'gpc_listings_table_installed' ) ) {
			return;
		}
		self::install_table();
	}

	/**
	 * Save one generated (or republished) listing into the plugin's own
	 * table so it survives independently of the WordPress post — this is
	 * what makes it exportable to another site.
	 */
	private function save_batch_record( $data ) {
		global $wpdb;
		$wpdb->insert(
			self::table_name(),
			array(
				'title'         => $data['title'],
				'description'   => $data['description'],
				'author_name'   => $data['author_name'],
				'author_email'  => $data['author_email'],
				'author_bio'    => $data['author_bio'],
				'category_name' => $data['category_name'],
				'post_status'   => $data['post_status'],
				'image_urls'    => wp_json_encode( $data['image_urls'] ),
				'source_site'   => $data['source_site'],
				'local_post_id' => $data['local_post_id'],
				'created_at'    => current_time( 'mysql' ),
			)
		);
		return $wpdb->insert_id;
	}

	public function add_menu() {
		add_submenu_page( 'gpc-settings', 'Bulk Publisher', 'Bulk Publisher', 'manage_options', 'gpc-bulk', array( $this, 'render' ) );
		add_submenu_page( 'gpc-settings', 'Saved Listings', 'Saved Listings', 'manage_options', 'gpc-saved-listings', array( $this, 'render_saved_listings' ) );
	}

	public function enqueue( $hook ) {
		if ( strpos( $hook, 'gpc-bulk' ) === false ) return;
		wp_enqueue_style( 'gpc-bulk-admin', GPC_URL . 'assets/css/gpc-bulk-admin.css', array(), GPC_VERSION );
		wp_enqueue_script( 'gpc-bulk-admin', GPC_URL . 'assets/js/gpc-bulk-admin.js', array(), GPC_VERSION, true );
		wp_localize_script( 'gpc-bulk-admin', 'gpcBulkData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'gpc_bulk_nonce' ),
			'siteDomain' => wp_parse_url( home_url(), PHP_URL_HOST ),
		) );
	}

	public function render() {
		if ( ! current_user_can( 'manage_options' ) ) return;

		$categories = get_categories( array( 'hide_empty' => false ) );
		$default_cat = (int) get_option( 'gpc_category_id', 0 );
		$roles = get_editable_roles();
		?>
		<div class="wrap gpc-bulk-wrap">
			<h1>Bulk Publisher</h1>
			<p>Paste as many titles and descriptions as you want, add pictures from your phone in batches, and this creates a real post with a real author (with their own email, password, avatar, and bio) for every single one. Nothing is uploaded to the server until you press Generate at the bottom, so building a batch of a hundred is just as safe as building a batch of two.</p>
			<p style="background:#f0f6ff;border:1px solid #cfe0ff;border-radius:8px;padding:10px 16px;">
				📦 Every post generated here is automatically saved to this plugin's own
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=gpc-saved-listings' ) ); ?>"><strong>Saved Listings</strong></a>
				page — so you can export the whole batch as a file and re-publish it on another site with one click, no retyping needed.
			</p>

			<h2>1. Batch settings</h2>
			<table class="form-table">
				<tr>
					<th>Category to assign</th>
					<td>
						<select id="gpcBatchCategory">
							<option value="0">No category</option>
							<?php foreach ( $categories as $c ) : ?>
								<option value="<?php echo esc_attr( $c->term_id ); ?>" <?php selected( $default_cat, $c->term_id ); ?>><?php echo esc_html( $c->name ); ?></option>
							<?php endforeach; ?>
						</select>
						<p class="description">Choose the category your carousel watches, so these posts qualify automatically.</p>
					</td>
				</tr>
				<tr>
					<th>Post status</th>
					<td>
						<select id="gpcBatchStatus">
							<option value="draft">Draft, review before publishing</option>
							<option value="publish">Publish immediately</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Role for new authors</th>
					<td>
						<select id="gpcBatchRole">
							<?php foreach ( $roles as $slug => $role ) : ?>
								<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $slug, 'author' ); ?>><?php echo esc_html( $role['name'] ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>Images per property</th>
					<td>
						<input type="number" id="gpcImagesPerRow" min="2" max="11" value="5">
						<p class="description">The gallery photo pool below gets split into consecutive groups of this size, one group per property, in the order you added them.</p>
					</td>
				</tr>
				<tr>
					<th>Notify new authors by email</th>
					<td><label><input type="checkbox" id="gpcBatchNotify"> Send the standard WordPress new-account email</label>
					<p class="description">Leave this off if you did not paste real email addresses below — auto-generated placeholder addresses cannot receive mail.</p></td>
				</tr>
			</table>

			<h2>2. Titles <span class="gpc-count-badge" id="gpcTitleCount">0</span></h2>
			<p class="description">One title per line. This is the only field that decides how many posts get created — everything else lines up against this list in order.</p>
			<textarea id="gpcBulkTitles" class="gpc-big-textarea" placeholder="3 Bedroom Duplex in Lekki
Executive Mini Flat in Yaba
Luxury Terrace House in Ikoyi
..."></textarea>

			<h2>3. Descriptions <span class="gpc-count-badge" id="gpcDescCount">0</span></h2>
			<p class="description">Separate each description with a line containing only <code>---</code>, so a description can span several lines. If you provide fewer descriptions than titles, the extra posts are created with an empty description you can fill in later.</p>
			<textarea id="gpcBulkDescriptions" class="gpc-big-textarea" placeholder="A beautiful modern duplex located in the heart of Lekki, close to major roads and shopping centres.
---
A cosy mini flat perfect for a single professional, walking distance to the market.
---
..."></textarea>

			<h2>4. Author names <span class="gpc-count-badge" id="gpcNameCount">0</span></h2>
			<p class="description">One full name per line. A WordPress account is created for each, reusing an existing account if the email already exists.</p>
			<textarea id="gpcBulkNames" class="gpc-big-textarea gpc-medium-textarea" placeholder="Adaeze Okafor
Chinedu Balogun
Grace Adeyemi
..."></textarea>

			<h2>5. Author emails <span class="gpc-count-badge" id="gpcEmailCount">0</span></h2>
			<p class="description">Optional. One per line, matched to the names above in order. Leave blank and a placeholder address is generated automatically for any name without one.</p>
			<textarea id="gpcBulkEmails" class="gpc-big-textarea gpc-medium-textarea" placeholder="adaeze@example.com (optional, leave blank to auto-generate)"></textarea>

			<h2>6. Author bios <span class="gpc-count-badge" id="gpcBioCount">0</span></h2>
			<p class="description">Optional. Separate each bio with a line containing only <code>---</code>. Any author without one gets a simple auto-generated bio, so nobody is left blank.</p>
			<textarea id="gpcBulkBios" class="gpc-big-textarea" placeholder="Adaeze is a real estate consultant with five years of experience helping families find their first home.
---
..."></textarea>

			<h2>7. Avatar photos <span class="gpc-count-badge" id="gpcAvatarCount">0</span></h2>
			<p class="description">Select up to twenty photos at a time, as many times as you like, straight from your phone's gallery. Assigned to authors in the order you add them.</p>
			<div class="gpc-drop-zone" id="gpcAvatarDropZone">
				<input type="file" id="gpcAvatarInput" accept="image/*" multiple style="display:none;">
				<button type="button" class="button button-large" id="gpcAvatarPickBtn">Add up to 20 avatar photos</button>
			</div>
			<div class="gpc-pool-grid" id="gpcAvatarPoolGrid"></div>

			<h2>8. Property gallery photos <span class="gpc-count-badge" id="gpcGalleryCount">0</span></h2>
			<p class="description">Select up to twenty photos at a time, as many times as you like. These get split into groups automatically based on "Images per property" above.</p>
			<div class="gpc-drop-zone" id="gpcGalleryDropZone">
				<input type="file" id="gpcGalleryInput" accept="image/*" multiple style="display:none;">
				<button type="button" class="button button-large" id="gpcGalleryPickBtn">Add up to 20 gallery photos</button>
			</div>
			<div class="gpc-pool-grid" id="gpcGalleryPoolGrid"></div>

			<h2>9. Generate</h2>
			<div class="gpc-summary-box" id="gpcSummaryBox">
				<p>Fill in the fields above to see a summary here.</p>
			</div>

			<p>
				<button type="button" class="button button-primary button-hero" id="gpcRunBatch">Generate all posts now</button>
			</p>

			<div id="gpcProgress" style="display:none;">
				<div style="background:#e2e2e2;border-radius:8px;overflow:hidden;height:22px;max-width:500px;">
					<div id="gpcProgressBar" style="background:#f0a500;height:100%;width:0%;transition:width 0.3s;"></div>
				</div>
				<p id="gpcProgressText"></p>
			</div>

			<table class="widefat striped" id="gpcResultsTable" style="display:none;">
				<thead><tr><th>Title</th><th>Author</th><th>Result</th></tr></thead>
				<tbody id="gpcResultsBody"></tbody>
			</table>

		</div>
		<?php
	}

	/* ---------------------------------------------------------- ajax */

	public function ajax_create_single() {
		check_ajax_referer( 'gpc_bulk_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'You do not have permission to do this' ) );
		}

		$title       = sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) );
		$description = sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) );
		$author_name = sanitize_text_field( wp_unslash( $_POST['author_name'] ?? '' ) );
		$author_email= sanitize_email( wp_unslash( $_POST['author_email'] ?? '' ) );
		$bio         = sanitize_textarea_field( wp_unslash( $_POST['author_bio'] ?? '' ) );
		$category_id = (int) ( $_POST['category_id'] ?? 0 );
		$status      = in_array( $_POST['status'] ?? 'draft', array( 'draft', 'publish' ), true ) ? $_POST['status'] : 'draft';
		$role        = sanitize_text_field( wp_unslash( $_POST['role'] ?? 'author' ) );
		$notify      = ! empty( $_POST['notify'] );

		if ( $title === '' ) {
			wp_send_json_error( array( 'message' => 'A title is required' ) );
		}

		// Email is optional from the bulk UI — auto-generate a unique
		// placeholder using the site's own domain if none was pasted in.
		if ( $author_email === '' || ! is_email( $author_email ) ) {
			$site_host = wp_parse_url( home_url(), PHP_URL_HOST ) ?: 'example.com';
			$slug      = sanitize_user( strtolower( str_replace( ' ', '.', $author_name ?: 'author' ) ), true );
			$slug      = $slug !== '' ? $slug : 'author';
			$author_email = $slug . '.' . wp_generate_password( 6, false, false ) . '@' . $site_host;
		}

		// A bio is optional too — nobody is left with a blank profile.
		if ( $bio === '' ) {
			$bio = ( $author_name ?: 'This author' ) . ' is a member of the ' . get_bloginfo( 'name' ) . ' community.';
		}

		$warnings = array();

		// Find or create the author.
		list( $user, $is_new_user ) = $this->find_or_create_author( $author_name, $author_email, $bio, $role, $notify );
		if ( is_wp_error( $user ) ) {
			wp_send_json_error( array( 'message' => $user->get_error_message() ) );
		}

		// Avatar.
		if ( ! empty( $_FILES['avatar'] ) && ! empty( $_FILES['avatar']['name'] ) ) {
			$avatars = new GPC_Avatars();
			$result = $avatars->assign_from_upload( $user->ID, $_FILES['avatar'] );
			if ( is_wp_error( $result ) ) {
				$warnings[] = 'Avatar could not be uploaded: ' . $result->get_error_message();
			}
		}

		// Create the post.
		$post_id = wp_insert_post( array(
			'post_title'   => $title,
			'post_content' => $description,
			'post_status'  => $status,
			'post_author'  => $user->ID,
			'post_type'    => 'post',
			'post_category'=> $category_id ? array( $category_id ) : array(),
		), true );

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error( array( 'message' => $post_id->get_error_message() ) );
		}

		// Gallery images, attached only to this post.
		$gallery_files = $this->reorganize_files_array( 'gallery' );
		$gallery_files = array_slice( $gallery_files, 0, 11 );

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attached_ids = array();
		foreach ( $gallery_files as $file ) {
			$attachment_id = media_handle_sideload( $file, $post_id );
			if ( ! is_wp_error( $attachment_id ) ) {
				$attached_ids[] = $attachment_id;
			}
		}

		if ( ! empty( $attached_ids ) ) {
			set_post_thumbnail( $post_id, $attached_ids[0] );
		}

		if ( count( $attached_ids ) < 2 ) {
			$warnings[] = 'Only ' . count( $attached_ids ) . ' image(s) attached. The carousel needs at least two, so it will not show on this post yet.';
		}

		// Save into the plugin's own Saved Listings table so this post can be
		// exported and republished on another site without retyping anything.
		$this->save_batch_record( array(
			'title'         => $title,
			'description'   => $description,
			'author_name'   => $author_name ?: $user->display_name,
			'author_email'  => $author_email,
			'author_bio'    => $bio,
			'category_name' => $category_id ? ( get_term( $category_id ) ? get_term( $category_id )->name : '' ) : '',
			'post_status'   => $status,
			'image_urls'    => array_map( 'wp_get_attachment_url', $attached_ids ),
			'source_site'   => wp_parse_url( home_url(), PHP_URL_HOST ),
			'local_post_id' => $post_id,
		) );

		wp_send_json_success( array(
			'post_id'    => $post_id,
			'edit_link'  => get_edit_post_link( $post_id, 'raw' ),
			'author'     => $user->display_name,
			'new_user'   => $is_new_user,
			'images'     => count( $attached_ids ),
			'warnings'   => $warnings,
		) );
	}

	/**
	 * Find an existing user by email, or create a new one. Shared by both
	 * the live Bulk Publisher form and the Saved Listings "Republish"
	 * action, so an author is created/matched the same way either time.
	 *
	 * @return array{0: WP_User|WP_Error, 1: bool} [ user, is_new_user ]
	 */
	private function find_or_create_author( $author_name, $author_email, $bio, $role = 'author', $notify = false ) {
		if ( $author_email === '' || ! is_email( $author_email ) ) {
			$site_host    = wp_parse_url( home_url(), PHP_URL_HOST ) ?: 'example.com';
			$slug         = sanitize_user( strtolower( str_replace( ' ', '.', $author_name ?: 'author' ) ), true );
			$slug         = $slug !== '' ? $slug : 'author';
			$author_email = $slug . '.' . wp_generate_password( 6, false, false ) . '@' . $site_host;
		}
		if ( $bio === '' ) {
			$bio = ( $author_name ?: 'This author' ) . ' is a member of the ' . get_bloginfo( 'name' ) . ' community.';
		}

		$user        = get_user_by( 'email', $author_email );
		$is_new_user = false;
		if ( ! $user ) {
			$username = $this->unique_username_from( $author_name ?: $author_email );
			$password = wp_generate_password( 16, true );
			$user_id  = wp_create_user( $username, $password, $author_email );
			if ( is_wp_error( $user_id ) ) {
				return array( $user_id, false );
			}
			$is_new_user = true;
			wp_update_user( array(
				'ID'           => $user_id,
				'display_name' => $author_name ?: $username,
				'first_name'   => $author_name ?: '',
				'description'  => $bio,
				'role'         => $role,
			) );
			$user = get_user_by( 'id', $user_id );
			if ( $notify ) {
				wp_new_user_notification( $user_id, null, 'user' );
			}
		} elseif ( $bio !== '' ) {
			wp_update_user( array( 'ID' => $user->ID, 'description' => $bio ) );
		}

		return array( $user, $is_new_user );
	}

	private function unique_username_from( $seed ) {
		$base = sanitize_user( strtolower( str_replace( ' ', '.', $seed ) ), true );
		$base = $base !== '' ? $base : 'author';
		$username = $base;
		$i = 1;
		while ( username_exists( $username ) ) {
			$username = $base . $i;
			$i++;
		}
		return $username;
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

	/* ---------------------------------------------------------- Saved Listings page */

	public function render_saved_listings() {
		if ( ! current_user_can( 'manage_options' ) ) return;
		global $wpdb;
		$table = self::table_name();
		$rows  = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY id DESC" );
		?>
		<div class="wrap gpc-bulk-wrap">
			<h1>Saved Listings</h1>
			<p>Every post created through the Bulk Publisher is kept here, independent of the post itself. Export them to a file, then import that file on another WordPress site and republish with one click — no retyping.</p>

			<?php if ( isset( $_GET['gpc_notice'] ) ) : ?>
				<div class="notice notice-<?php echo esc_attr( $_GET['gpc_notice'] === 'error' ? 'error' : 'success' ); ?> is-dismissible">
					<p><?php echo esc_html( wp_unslash( $_GET['gpc_message'] ?? '' ) ); ?></p>
				</div>
			<?php endif; ?>

			<div style="display:flex;gap:32px;flex-wrap:wrap;margin:18px 0 26px;">
				<div>
					<h2>Export</h2>
					<p class="description">Download every saved listing below as one JSON file.</p>
					<a class="button button-primary" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=gpc_export_batches' ), 'gpc_export_batches' ) ); ?>">Export all as JSON</a>
				</div>
				<div>
					<h2>Import</h2>
					<p class="description">Upload a JSON file exported from this plugin on any site. Imported listings appear below — nothing is published until you press Republish on each one.</p>
					<form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="gpc_import_batches">
						<?php wp_nonce_field( 'gpc_import_batches' ); ?>
						<input type="file" name="gpc_import_file" accept="application/json" required>
						<button type="submit" class="button button-primary">Import JSON</button>
					</form>
				</div>
			</div>

			<table class="widefat striped">
				<thead>
					<tr>
						<th>Title</th>
						<th>Author</th>
						<th>Category</th>
						<th>Images</th>
						<th>Origin site</th>
						<th>Status</th>
						<th>Saved</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $rows ) ) : ?>
						<tr><td colspan="8">No saved listings yet — generate some posts on the Bulk Publisher page, or import a JSON file above.</td></tr>
					<?php else : foreach ( $rows as $row ) :
						$images = json_decode( $row->image_urls, true );
						$images = is_array( $images ) ? $images : array();
					?>
						<tr>
							<td><strong><?php echo esc_html( $row->title ); ?></strong></td>
							<td><?php echo esc_html( $row->author_name ?: $row->author_email ); ?></td>
							<td><?php echo esc_html( $row->category_name ?: '—' ); ?></td>
							<td><?php echo (int) count( $images ); ?></td>
							<td><?php echo esc_html( $row->source_site ?: '—' ); ?></td>
							<td><?php echo esc_html( $row->post_status ); ?></td>
							<td><?php echo esc_html( $row->created_at ); ?></td>
							<td style="white-space:nowrap;">
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline;">
									<input type="hidden" name="action" value="gpc_republish_batch">
									<input type="hidden" name="batch_id" value="<?php echo (int) $row->id; ?>">
									<?php wp_nonce_field( 'gpc_republish_batch_' . $row->id ); ?>
									<button type="submit" class="button button-small button-primary">Republish here</button>
								</form>
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline;" onsubmit="return confirm('Remove this saved listing? This does not delete the WordPress post itself, only the saved copy.');">
									<input type="hidden" name="action" value="gpc_delete_batch">
									<input type="hidden" name="batch_id" value="<?php echo (int) $row->id; ?>">
									<?php wp_nonce_field( 'gpc_delete_batch_' . $row->id ); ?>
									<button type="submit" class="button button-small">Remove</button>
								</form>
							</td>
						</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	private function redirect_to_saved_listings( $message, $is_error = false ) {
		wp_safe_redirect( add_query_arg( array(
			'page'        => 'gpc-saved-listings',
			'gpc_notice'  => $is_error ? 'error' : 'success',
			'gpc_message' => rawurlencode( $message ),
		), admin_url( 'admin.php' ) ) );
		exit;
	}

	public function handle_export() {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
		check_admin_referer( 'gpc_export_batches' );

		global $wpdb;
		$table = self::table_name();
		$rows  = $wpdb->get_results( "SELECT title, description, author_name, author_email, author_bio, category_name, post_status, image_urls, source_site, created_at FROM {$table} ORDER BY id ASC", ARRAY_A );
		foreach ( $rows as &$row ) {
			$row['image_urls'] = json_decode( $row['image_urls'], true );
		}
		unset( $row );

		$payload = array(
			'plugin'       => 'glh-post-carousel',
			'exported_at'  => current_time( 'mysql' ),
			'exported_from'=> wp_parse_url( home_url(), PHP_URL_HOST ),
			'listings'     => $rows,
		);

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="gpc-saved-listings-' . gmdate( 'Y-m-d' ) . '.json"' );
		echo wp_json_encode( $payload, JSON_PRETTY_PRINT );
		exit;
	}

	public function handle_import() {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
		check_admin_referer( 'gpc_import_batches' );

		if ( empty( $_FILES['gpc_import_file']['tmp_name'] ) ) {
			$this->redirect_to_saved_listings( 'No file was uploaded.', true );
		}

		$raw  = file_get_contents( $_FILES['gpc_import_file']['tmp_name'] );
		$data = json_decode( $raw, true );

		$listings = $data['listings'] ?? ( is_array( $data ) ? $data : null );
		if ( ! is_array( $listings ) ) {
			$this->redirect_to_saved_listings( 'That file does not look like a valid Saved Listings export.', true );
		}

		$imported = 0;
		foreach ( $listings as $item ) {
			if ( empty( $item['title'] ) ) continue;
			$this->save_batch_record( array(
				'title'         => sanitize_text_field( $item['title'] ),
				'description'   => wp_kses_post( $item['description'] ?? '' ),
				'author_name'   => sanitize_text_field( $item['author_name'] ?? '' ),
				'author_email'  => sanitize_email( $item['author_email'] ?? '' ),
				'author_bio'    => sanitize_textarea_field( $item['author_bio'] ?? '' ),
				'category_name' => sanitize_text_field( $item['category_name'] ?? '' ),
				'post_status'   => in_array( $item['post_status'] ?? 'draft', array( 'draft', 'publish' ), true ) ? $item['post_status'] : 'draft',
				'image_urls'    => array_map( 'esc_url_raw', (array) ( $item['image_urls'] ?? array() ) ),
				'source_site'   => sanitize_text_field( $item['source_site'] ?? 'imported' ),
				'local_post_id' => null,
			) );
			$imported++;
		}

		$this->redirect_to_saved_listings( $imported . ' listing(s) imported. Press "Republish here" on each one to actually create the post on this site.' );
	}

	public function handle_republish() {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
		$id = (int) ( $_POST['batch_id'] ?? 0 );
		check_admin_referer( 'gpc_republish_batch_' . $id );

		global $wpdb;
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . self::table_name() . " WHERE id = %d", $id ) );
		if ( ! $row ) {
			$this->redirect_to_saved_listings( 'That saved listing could not be found.', true );
		}

		list( $user, $is_new_user ) = $this->find_or_create_author( $row->author_name, $row->author_email, $row->author_bio, 'author', false );
		if ( is_wp_error( $user ) ) {
			$this->redirect_to_saved_listings( 'Could not create/find author: ' . $user->get_error_message(), true );
		}

		// Match or create the category by name — categories are not
		// portable by ID between sites, only by name.
		$category_id = 0;
		if ( $row->category_name ) {
			$term = get_term_by( 'name', $row->category_name, 'category' );
			if ( ! $term ) {
				$new_term = wp_insert_term( $row->category_name, 'category' );
				$category_id = is_wp_error( $new_term ) ? 0 : $new_term['term_id'];
			} else {
				$category_id = $term->term_id;
			}
		}

		$post_id = wp_insert_post( array(
			'post_title'    => $row->title,
			'post_content'  => $row->description,
			'post_status'   => $row->post_status ?: 'draft',
			'post_author'   => $user->ID,
			'post_type'     => 'post',
			'post_category' => $category_id ? array( $category_id ) : array(),
		), true );

		if ( is_wp_error( $post_id ) ) {
			$this->redirect_to_saved_listings( 'Could not create post: ' . $post_id->get_error_message(), true );
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$image_urls   = json_decode( $row->image_urls, true );
		$image_urls   = is_array( $image_urls ) ? $image_urls : array();
		$attached_ids = array();
		$failed       = 0;
		foreach ( array_slice( $image_urls, 0, 11 ) as $url ) {
			$attachment_id = media_sideload_image( $url, $post_id, $row->title, 'id' );
			if ( is_wp_error( $attachment_id ) ) {
				$failed++;
				continue;
			}
			$attached_ids[] = $attachment_id;
		}
		if ( ! empty( $attached_ids ) ) {
			set_post_thumbnail( $post_id, $attached_ids[0] );
		}

		$message = 'Republished "' . $row->title . '" as a new post (' . count( $attached_ids ) . ' image(s) pulled in).';
		if ( $failed ) {
			$message .= ' ' . $failed . ' image(s) could not be downloaded — the original site may be offline.';
		}
		$this->redirect_to_saved_listings( $message );
	}

	public function handle_delete() {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
		$id = (int) ( $_POST['batch_id'] ?? 0 );
		check_admin_referer( 'gpc_delete_batch_' . $id );

		global $wpdb;
		$wpdb->delete( self::table_name(), array( 'id' => $id ) );

		$this->redirect_to_saved_listings( 'Saved listing removed.' );
	}
}
