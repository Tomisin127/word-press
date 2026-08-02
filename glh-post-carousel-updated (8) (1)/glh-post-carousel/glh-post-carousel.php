<?php
/**
 * Plugin Name: GetLegacyHomes Property Carousel and Bulk Publisher
 * Description: Adds an automatic image carousel above the title of single property posts, plus a bulk tool to create many posts, authors, avatars and bios at once.
 * Version: 2.7.2
 * Author: GetLegacyHomes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GPC_VERSION', '2.7.2' );
define( 'GPC_PATH', plugin_dir_path( __FILE__ ) );
define( 'GPC_URL', plugin_dir_url( __FILE__ ) );

require_once GPC_PATH . 'includes/class-gpc-settings.php';
require_once GPC_PATH . 'includes/class-gpc-carousel.php';
require_once GPC_PATH . 'includes/class-gpc-avatars.php';
require_once GPC_PATH . 'includes/class-gpc-bulk-publisher.php';
require_once GPC_PATH . 'includes/class-gpc-frontend-submit.php';
require_once GPC_PATH . 'includes/class-gpc-property-display.php';

add_action( 'plugins_loaded', 'gpc_init' );
function gpc_init() {
	new GPC_Settings();
	new GPC_Carousel();
	new GPC_Avatars();
	new GPC_Bulk_Publisher();
	new GPC_Frontend_Submit();
	new GPC_Property_Display();
}

/* Create the "Saved Listings" table on activation, so every post made
   through the Bulk Publisher is stored inside the plugin's own database
   and can be exported and re-imported on another site install. */
register_activation_hook( __FILE__, array( 'GPC_Bulk_Publisher', 'install_table' ) );
