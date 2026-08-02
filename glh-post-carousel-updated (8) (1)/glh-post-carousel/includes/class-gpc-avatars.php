<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GPC_Avatars {

	const META_KEY = 'gpc_avatar_id';

	public function __construct() {
		add_filter( 'get_avatar_url', array( $this, 'filter_avatar_url' ), 10, 3 );
		add_filter( 'get_avatar', array( $this, 'filter_avatar' ), 10, 6 );
		add_action( 'show_user_profile', array( $this, 'profile_field' ) );
		add_action( 'edit_user_profile', array( $this, 'profile_field' ) );
		add_action( 'personal_options_update', array( $this, 'save_profile_field' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_profile_field' ) );
	}

	/**
	 * Uploads a file (from $_FILES style array) into the media library and
	 * assigns it as the given user's avatar. Returns the attachment id or
	 * a WP_Error.
	 */
	public function assign_from_upload( $user_id, $file ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attachment_id = media_handle_sideload( $file, 0 );
		if ( is_wp_error( $attachment_id ) ) {
			return $attachment_id;
		}

		update_user_meta( $user_id, self::META_KEY, $attachment_id );
		return $attachment_id;
	}

	public function get_user_avatar_id( $user_id ) {
		return (int) get_user_meta( $user_id, self::META_KEY, true );
	}

	private function resolve_user_id_from_id_or_email( $id_or_email ) {
		if ( is_numeric( $id_or_email ) ) {
			return (int) $id_or_email;
		}
		if ( is_object( $id_or_email ) ) {
			if ( ! empty( $id_or_email->user_id ) ) {
				return (int) $id_or_email->user_id;
			}
			if ( ! empty( $id_or_email->comment_author_email ) ) {
				$user = get_user_by( 'email', $id_or_email->comment_author_email );
				return $user ? $user->ID : 0;
			}
		}
		if ( is_string( $id_or_email ) && is_email( $id_or_email ) ) {
			$user = get_user_by( 'email', $id_or_email );
			return $user ? $user->ID : 0;
		}
		return 0;
	}

	public function filter_avatar_url( $url, $id_or_email, $args ) {
		$user_id = $this->resolve_user_id_from_id_or_email( $id_or_email );
		if ( ! $user_id ) {
			return $url;
		}
		$attachment_id = $this->get_user_avatar_id( $user_id );
		if ( ! $attachment_id ) {
			return $url;
		}
		$size = isset( $args['size'] ) ? (int) $args['size'] : 96;
		$image = wp_get_attachment_image_src( $attachment_id, array( $size, $size ) );
		return $image ? $image[0] : $url;
	}

	public function filter_avatar( $avatar, $id_or_email, $size, $default, $alt, $args ) {
		$user_id = $this->resolve_user_id_from_id_or_email( $id_or_email );
		if ( ! $user_id ) {
			return $avatar;
		}
		$attachment_id = $this->get_user_avatar_id( $user_id );
		if ( ! $attachment_id ) {
			return $avatar;
		}
		$image = wp_get_attachment_image_src( $attachment_id, array( $size, $size ) );
		if ( ! $image ) {
			return $avatar;
		}
		return sprintf(
			'<img alt="%s" src="%s" class="avatar avatar-%d gpc-local-avatar" height="%d" width="%d" loading="lazy">',
			esc_attr( $alt ), esc_url( $image[0] ), (int) $size, (int) $size, (int) $size
		);
	}

	/* ---------------------------------------------------------- profile screen field */

	public function profile_field( $user ) {
		if ( ! current_user_can( 'edit_user', $user->ID ) ) return;
		$attachment_id = $this->get_user_avatar_id( $user->ID );
		$preview = $attachment_id ? wp_get_attachment_image( $attachment_id, array( 80, 80 ) ) : '';
		wp_nonce_field( 'gpc_avatar_save', 'gpc_avatar_nonce' );
		?>
		<h2>Profile picture</h2>
		<table class="form-table">
			<tr>
				<th>Avatar image</th>
				<td>
					<?php echo $preview; ?>
					<p><input type="file" name="gpc_avatar_file" accept="image/*"></p>
					<p class="description">Upload a real picture to use as this person's avatar instead of a generic icon.</p>
				</td>
			</tr>
		</table>
		<?php
	}

	public function save_profile_field( $user_id ) {
		if ( ! isset( $_POST['gpc_avatar_nonce'] ) || ! wp_verify_nonce( $_POST['gpc_avatar_nonce'], 'gpc_avatar_save' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_user', $user_id ) ) return;
		if ( empty( $_FILES['gpc_avatar_file'] ) || empty( $_FILES['gpc_avatar_file']['name'] ) ) {
			return;
		}
		$this->assign_from_upload( $user_id, $_FILES['gpc_avatar_file'] );
	}
}
