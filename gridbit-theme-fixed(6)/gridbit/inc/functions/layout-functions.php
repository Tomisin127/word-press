<?php
/**
* Layout Functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_hide_footer_widgets() {
    $hide_footer_widgets = false;
    if ( gridbit_get_option('hide_footer_widgets') ) {
        $hide_footer_widgets = true;
    }
    return apply_filters( 'gridbit_hide_footer_widgets', $hide_footer_widgets );
}

function gridbit_is_header_content_active() {
    $header_content_active = true;
    if ( gridbit_get_option('hide_header_content') ) {
        $header_content_active = false;
    }
    return apply_filters( 'gridbit_is_header_content_active', $header_content_active );
}

function gridbit_is_primary_menu_active() {
    $primary_menu_active = true;
    if ( gridbit_get_option('disable_primary_menu') ) {
        $primary_menu_active = false;
    }
    return apply_filters( 'gridbit_is_primary_menu_active', $primary_menu_active );
}

function gridbit_is_menu_social_bar_active() {
    $menu_social_bar_active = true;
    if ( gridbit_get_option('disable_menu_social_bar') ) {
        $menu_social_bar_active = false;
    }
    return apply_filters( 'gridbit_is_menu_social_bar_active', $menu_social_bar_active );
}

function gridbit_is_secondary_menu_active() {
    $secondary_menu_active = true;
    if ( gridbit_get_option('disable_secondary_menu') ) {
        $secondary_menu_active = false;
    }
    return apply_filters( 'gridbit_is_secondary_menu_active', $secondary_menu_active );
}

function gridbit_is_social_buttons_active() {
    $social_buttons_active = true;
    if ( gridbit_get_option('hide_header_social_buttons') ) {
        $social_buttons_active = false;
    }
    return apply_filters( 'gridbit_is_social_buttons_active', $social_buttons_active );
}

function gridbit_is_fitvids_active() {
    $fitvids_active = false;
    if ( gridbit_get_option('enable_fitvids') ) {
        $fitvids_active = true;
    }
    return apply_filters( 'gridbit_is_fitvids_active', $fitvids_active );
}

function gridbit_is_backtotop_active() {
    $backtotop_active = true;
    if ( gridbit_get_option('disable_backtotop') ) {
        $backtotop_active = false;
    }
    return apply_filters( 'gridbit_is_backtotop_active', $backtotop_active );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gridbit_content_width() {
    $content_width = 1170;

    $GLOBALS['content_width'] = apply_filters( 'gridbit_content_width', $content_width ); /* phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound */
}
add_action( 'template_redirect', 'gridbit_content_width', 0 );

function gridbit_thumbnail_alignment_non_grid() {
    $alignment = 'gridbit-thumbnail-alignwide';

    if ( gridbit_get_option('thumbnail_alignment_non_grid') ) {
        $alignment = gridbit_get_option('thumbnail_alignment_non_grid');
    }

    return apply_filters( 'gridbit_thumbnail_alignment_non_grid', $alignment );
}

function gridbit_thumbnail_alignment_single() {
    $alignment = 'gridbit-thumbnail-alignwide';

    if ( gridbit_get_option('thumbnail_alignment_single') ) {
        $alignment = gridbit_get_option('thumbnail_alignment_single');
    }

    return apply_filters( 'gridbit_thumbnail_alignment_single', $alignment );
}

function gridbit_thumbnail_alignment_page() {
    $alignment = 'gridbit-thumbnail-alignwide';

    if ( gridbit_get_option('thumbnail_alignment_page') ) {
        $alignment = gridbit_get_option('thumbnail_alignment_page');
    }

    return apply_filters( 'gridbit_thumbnail_alignment_page', $alignment );
}