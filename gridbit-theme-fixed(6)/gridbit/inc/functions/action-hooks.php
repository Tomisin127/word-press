<?php
/**
* Custom Hooks
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_before_header() {
    do_action('gridbit_before_header');
}

function gridbit_after_header() {
    do_action('gridbit_after_header');
}

function gridbit_before_main_content() {
    do_action('gridbit_before_main_content');
}
add_action('gridbit_before_main_content', 'gridbit_top_widgets', 20 );
add_action('gridbit_before_main_content', 'gridbit_top_left_right_widgets', 40 );

function gridbit_after_main_content() {
    do_action('gridbit_after_main_content');
}
add_action('gridbit_after_main_content', 'gridbit_bottom_widgets', 10 );

function gridbit_sidebar_one() {
    do_action('gridbit_sidebar_one');
}

function gridbit_sidebar_two() {
    do_action('gridbit_sidebar_two');
}

function gridbit_before_single_post() {
    do_action('gridbit_before_single_post');
}

function gridbit_before_single_post_title() {
    do_action('gridbit_before_single_post_title');
}

function gridbit_after_single_post_title() {
    do_action('gridbit_after_single_post_title');
}

function gridbit_top_single_post_content() {
    do_action('gridbit_top_single_post_content');
}

function gridbit_bottom_single_post_content() {
    do_action('gridbit_bottom_single_post_content');
}

function gridbit_after_single_post_content() {
    do_action('gridbit_after_single_post_content');
}

function gridbit_after_single_post() {
    do_action('gridbit_after_single_post');
}

function gridbit_before_single_page() {
    do_action('gridbit_before_single_page');
}

function gridbit_before_single_page_title() {
    do_action('gridbit_before_single_page_title');
}

function gridbit_after_single_page_title() {
    do_action('gridbit_after_single_page_title');
}

function gridbit_after_single_page_content() {
    do_action('gridbit_after_single_page_content');
}

function gridbit_after_single_page() {
    do_action('gridbit_after_single_page');
}

function gridbit_before_comments() {
    do_action('gridbit_before_comments');
}

function gridbit_after_comments() {
    do_action('gridbit_after_comments');
}

function gridbit_before_footer() {
    do_action('gridbit_before_footer');
}

function gridbit_after_footer() {
    do_action('gridbit_after_footer');
}

function gridbit_before_nongrid_post_title() {
    do_action('gridbit_before_nongrid_post_title');
}

function gridbit_after_nongrid_post_title() {
    do_action('gridbit_after_nongrid_post_title');
}

if ( ! function_exists( 'gridbit_remove_theme_support' ) ) :
function gridbit_remove_theme_support() {

    if ( gridbit_is_fitvids_active() ) {
        // Remove responsive embedded content support.
        remove_theme_support( 'responsive-embeds' );
    }

}
endif;
add_action( 'after_setup_theme', 'gridbit_remove_theme_support', 1000 );