<?php
/**
* GridBit functions and definitions.
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

define( 'GRIDBIT_PROURL', 'https://themesdna.com/gridbit-pro-wordpress-theme/' );
define( 'GRIDBIT_CONTACTURL', 'https://themesdna.com/contact/' );
define( 'GRIDBIT_THEMEOPTIONSDIR', get_template_directory() . '/inc/admin' );

// Add new constant that returns true if WooCommerce is active
define( 'GRIDBIT_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );

require_once( GRIDBIT_THEMEOPTIONSDIR . '/customizer.php' );

/**
 * This function return a value of given theme option name from database.
 *
 * @since 1.0.0
 *
 * @param string $option Theme option to return.
 * @return mixed The value of theme option.
 */
function gridbit_get_option($option) {
    $gridbit_options = get_option('gridbit_options');
    if ((is_array($gridbit_options)) && (array_key_exists($option, $gridbit_options))) {
        return $gridbit_options[$option];
    }
    else {
        return '';
    }
}

function gridbit_is_option_set($option) {
    $gridbit_options = get_option('gridbit_options');
    if ((is_array($gridbit_options)) && (array_key_exists($option, $gridbit_options))) {
        return true;
    } else {
        return false;
    }
}

if ( ! function_exists( 'gridbit_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gridbit_setup() {
    
    global $wp_version;

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on GridBit, use a find and replace
     * to change 'gridbit' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'gridbit', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'gridbit-770w-autoh-image', 770, 9999, false );
        add_image_size( 'gridbit-360w-autoh-image', 360, 9999, false );
        add_image_size( 'gridbit-360w-270h-image', 360, 270, true );
    }

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
    'primary' => esc_html__('Primary Menu', 'gridbit'),
    'secondary' => esc_html__('Secondary Menu', 'gridbit')
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    $markup = array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'navigation-widgets' );
    add_theme_support( 'html5', $markup );

    add_theme_support( 'custom-logo', array(
        'height'      => 37,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    // Support for Custom Header
    add_theme_support( 'custom-header', apply_filters( 'gridbit_custom_header_args', array(
    'default-image'          => '',
    'default-text-color'     => 'ffffff',
    'width'                  => 1920,
    'height'                 => 400,
    'flex-width'            => true,
    'flex-height'            => true,
    'wp-head-callback'       => 'gridbit_header_style',
    'uploads'                => true,
    ) ) );

    // Set up the WordPress core custom background feature.
    $background_args = array(
            'default-color'          => 'ffffff',
            'default-image'          => '',
            'default-repeat'         => 'repeat',
            'default-position-x'     => 'left',
            'default-position-y'     => 'top',
            'default-size'     => 'auto',
            'default-attachment'     => 'fixed',
            'wp-head-callback'       => '_custom_background_cb',
            'admin-head-callback'    => 'admin_head_callback_func',
            'admin-preview-callback' => 'admin_preview_callback_func',
    );
    add_theme_support( 'custom-background', apply_filters( 'gridbit_custom_background_args', $background_args) );
    
    // Support for Custom Editor Style
    add_editor_style( 'assets/css/editor-style.css' );

    // Add support for responsive embedded content.
    add_theme_support( 'responsive-embeds' );

    // Add support for Block Styles.
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align blocks.
    add_theme_support( 'align-wide' );

    if ( !(gridbit_get_option('enable_widgets_block_editor')) ) {
        remove_theme_support( 'widgets-block-editor' );
    }

}
endif;
add_action( 'after_setup_theme', 'gridbit_setup' );

require_once( trailingslashit( get_template_directory() ) . 'inc/functions/layout-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/widgets-init.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/social-buttons.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/post-author-bio-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/postmeta-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/posts-navigation.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/menu-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/header-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/css-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/other-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/action-hooks.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/media-functions.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/enqueue-scripts.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/functions/block-styles.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/admin/custom.php' );

/**
 * Hide the default WordPress admin toolbar on the front end for everyone,
 * including logged-in admins. It was showing up as a stray "admin" pill
 * with a placeholder avatar on top of front-end pages (e.g. the signup
 * page) whenever an admin/editor was logged in while browsing the site.
 * Users can still access wp-admin normally; this only hides the toolbar
 * overlay on the public-facing site.
 *
 * NOTE: a plain add_filter() here can be overridden by another plugin
 * that hooks 'show_admin_bar' at a later priority, or that calls
 * show_admin_bar(true) directly. To make this stick no matter what else
 * is active, we (1) use the highest possible filter priority so we run
 * last and win, and (2) also force it off directly on 'init', which is
 * the same mechanism WordPress itself uses and beats any later
 * show_admin_bar(true) call from a plugin that hasn't fired yet.
 */
add_filter( 'show_admin_bar', '__return_false', PHP_INT_MAX );
add_action( 'init', 'gridbit_force_hide_admin_bar', PHP_INT_MAX );
function gridbit_force_hide_admin_bar() {
    if ( function_exists( 'show_admin_bar' ) ) {
        show_admin_bar( false );
    }
}