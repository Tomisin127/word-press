<?php
/**
* Enqueue scripts and styles
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_scripts() {
    wp_enqueue_style('gridbit-maincss', get_stylesheet_uri(), array(), null);
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), null );
    wp_enqueue_style('gridbit-webfont', '//fonts.googleapis.com/css?family=Source+Serif+Pro:400,700&amp;display=swap', array(), null);

    /* Site-wide dark/light mode. Every rule inside dark-mode.css is
     * keyed off html[data-urs-theme='dark'], an attribute the URS plugin
     * already sets server-side with no flash. Every color falls back to
     * a hard-coded default via var(--x, #fallback), so this does not
     * depend on plugin load order — if URS is ever deactivated the
     * attribute is simply never set and the site just stays in its
     * normal light appearance. */
    wp_enqueue_style( 'gridbit-dark-mode', get_template_directory_uri() . '/assets/css/dark-mode.css', array(), null );

    /* Bumps up small default text sizes in widget areas (login/signup
     * forms, sidebars, etc.) for readability. Purely additive — see the
     * file header for details — loads last so it doesn't need to fight
     * any other stylesheet for priority. */
    wp_enqueue_style( 'gridbit-readability', get_template_directory_uri() . '/assets/css/readability.css', array( 'gridbit-maincss', 'gridbit-dark-mode' ), null );

    $gridbit_fitvids_active = false;
    if ( gridbit_is_fitvids_active() ) {
        $gridbit_fitvids_active = true;
    }
    if ( $gridbit_fitvids_active ) {
        wp_enqueue_script('fitvids', get_template_directory_uri() .'/assets/js/jquery.fitvids.min.js', array( 'jquery' ), null, true);
    }

    $gridbit_backtotop_active = false;
    if ( gridbit_is_backtotop_active() ) {
        $gridbit_backtotop_active = true;
    }

    $gridbit_primary_menu_active = false;
    if ( gridbit_is_primary_menu_active() ) {
        $gridbit_primary_menu_active = true;
    }
    $gridbit_secondary_menu_active = false;
    if ( gridbit_is_secondary_menu_active() ) {
        $gridbit_secondary_menu_active = true;
    }

    wp_enqueue_script('gridbit-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), null, true );
    wp_enqueue_script('gridbit-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), null, true );
    wp_enqueue_script('gridbit-customjs', get_template_directory_uri() .'/assets/js/custom.js', array( 'jquery', 'imagesloaded' ), null, true);

    wp_localize_script( 'gridbit-customjs', 'gridbit_ajax_object',
        array(
            'ajaxurl' => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
            'primary_menu_active' => $gridbit_primary_menu_active,
            'secondary_menu_active' => $gridbit_secondary_menu_active,
            'fitvids_active' => $gridbit_fitvids_active,
            'backtotop_active' => $gridbit_backtotop_active,
        )
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'gridbit_scripts' );

/**
 * Enqueue styles for the block-based editor.
 */
function gridbit_block_editor_styles() {
    wp_enqueue_style( 'gridbit-block-editor-style', get_template_directory_uri() . '/assets/css/editor-blocks.css', array(), null );
}
add_action( 'enqueue_block_editor_assets', 'gridbit_block_editor_styles' );

/**
 * Enqueue customizer styles.
 */
function gridbit_enqueue_customizer_styles() {
    wp_enqueue_style( 'gridbit-customizer-styles', get_template_directory_uri() . '/inc/admin/css/customizer-style.css', array(), null );
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), null );
}
add_action( 'customize_controls_enqueue_scripts', 'gridbit_enqueue_customizer_styles' );