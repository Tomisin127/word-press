<?php
/**
* Css Classes Functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

// Category ids in post class
function gridbit_category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
        $classes[] = 'wpcat-' . $category->cat_ID . '-id';
    }
    return apply_filters( 'gridbit_category_id_class', $classes );
}
add_filter('post_class', 'gridbit_category_id_class');


// Adds custom classes to the array of body classes.
function gridbit_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'gridbit-group-blog';
    }

    if ( !(gridbit_get_option('disable_loading_animation')) ) {
        $classes[] = 'gridbit-animated gridbit-fadein';
    }

    $classes[] = 'gridbit-theme-is-active';

    if ( get_header_image() ) {
        $classes[] = 'gridbit-header-image-active';
    }

    if ( gridbit_get_option('header_image_cover') ) {
        $classes[] = 'gridbit-header-image-cover';
    }

    if ( has_custom_logo() ) {
        $classes[] = 'gridbit-custom-logo-active';
    }

    $classes[] = 'gridbit-layout-type-full';

    $classes[] = 'gridbit-masonry-inactive';

    if ( gridbit_get_option('disable_posts_grid') ) {
        $classes[] = 'gridbit-normal-post-style';
    } else {
        $classes[] = 'gridbit-grid-post-style';
    }

    $classes[] = 'gridbit-flexbox-grid';

    if ( gridbit_get_option('disable_underline_primary_menu') ) {
        $classes[] = 'gridbit-primary-menu-no-underline';
    }

    if ( is_singular() ) {
        $classes[] = 'gridbit-singular-page';
    } else {
        $classes[] = 'gridbit-plural-page';
    }

    if ( !(is_singular()) ) {
        if ( gridbit_get_option('featured_nongrid_media_above_post_title') ) {
            $classes[] = 'gridbit-nongrid-media-above-title';
        }
    }

    if ( is_singular() ) {

        global $post;

        if( is_single() ) {
            if ( gridbit_get_option('featured_media_above_post_title') ) {
                $classes[] = 'gridbit-single-media-above-title';
            }
        }
        if( is_page() ) {
            if ( gridbit_get_option('featured_media_above_page_title') ) {
                $classes[] = 'gridbit-single-media-above-title';
            }
        }

    }

    if ( !(gridbit_is_primary_menu_active()) ) {
        $classes[] = 'gridbit-header-full-active';
    } else {
        $classes[] = 'gridbit-header-menu-active';
    }

    if ( gridbit_get_option('hide_tagline') ) {
        $classes[] = 'gridbit-tagline-inactive';
    }

    if ( 'beside-title' === gridbit_get_option('logo_location') ) {
        $classes[] = 'gridbit-logo-beside-title';
    } elseif ( 'above-title' === gridbit_get_option('logo_location') ) {
        $classes[] = 'gridbit-logo-above-title';
    } else {
        $classes[] = 'gridbit-logo-above-title';
    }

    if ( gridbit_is_primary_menu_active() ) {
        $classes[] = 'gridbit-primary-menu-active';
    } else {
        $classes[] = 'gridbit-primary-menu-inactive';
    }
    $classes[] = 'gridbit-primary-mobile-menu-active';

    if ( gridbit_is_secondary_menu_active() ) {
        $classes[] = 'gridbit-secondary-menu-active';
    } else {
        $classes[] = 'gridbit-secondary-menu-inactive';
    }
    $classes[] = 'gridbit-secondary-mobile-menu-active';
    if ( gridbit_get_option('center_secondary_menu') ) {
        $classes[] = 'gridbit-secondary-menu-centered';
    }

    if ( 'before-header' === gridbit_secondary_menu_location() ) {
        $classes[] = 'gridbit-secondary-menu-before-header';
    } elseif ( 'after-header' === gridbit_secondary_menu_location() ) {
        $classes[] = 'gridbit-secondary-menu-after-header';
    } elseif ( 'before-footer' === gridbit_secondary_menu_location() ) {
        $classes[] = 'gridbit-secondary-menu-before-footer';
    } elseif ( 'after-footer' === gridbit_secondary_menu_location() ) {
        $classes[] = 'gridbit-secondary-menu-after-footer';
    } else {
        $classes[] = 'gridbit-secondary-menu-before-footer';
    }

    if ( gridbit_is_social_buttons_active() ) {
        $classes[] = 'gridbit-social-buttons-active';
    } else {
        $classes[] = 'gridbit-social-buttons-inactive';
    }

    if ( gridbit_get_option('no_underline_content_links') ) {
        $classes[] = 'gridbit-nouc-links';
    } else {
        $classes[] = 'gridbit-uc-links';
    }

    return apply_filters( 'gridbit_body_classes', $classes );
}
add_filter( 'body_class', 'gridbit_body_classes' );