<?php
/**
* Header Functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function gridbit_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'gridbit_pingback_header' );

// Get custom-logo URL
function gridbit_custom_logo() {
    if ( ! has_custom_logo() ) {return;}
    $gridbit_custom_logo_id = get_theme_mod( 'custom_logo' );
    $gridbit_logo = wp_get_attachment_image_src( $gridbit_custom_logo_id , 'full' );
    $gridbit_logo_src = $gridbit_logo[0];
    return apply_filters( 'gridbit_custom_logo', $gridbit_logo_src );
}

// Site Title
function gridbit_site_title() {
    if ( is_front_page() && is_home() ) { ?>
            <h1 class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_home() ) { ?>
            <h1 class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_singular() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_category() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_tag() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_author() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_archive() && !is_category() && !is_tag() && !is_author() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_search() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } elseif ( is_404() ) { ?>
            <p class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php } else { ?>
            <h1 class="gridbit-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( !(gridbit_get_option('hide_tagline')) ) { ?><p class="gridbit-site-description"><?php bloginfo( 'description' ); ?></p><?php } ?>
    <?php }
}

function gridbit_header_image_destination() {
    $url = home_url( '/' );
    if ( gridbit_get_option('header_image_destination') ) {
        $url = gridbit_get_option('header_image_destination');
    }
    return apply_filters( 'gridbit_header_image_destination', $url );
}

function gridbit_header_image_markup() {
    if ( get_header_image() ) {
        if ( gridbit_get_option('remove_header_image_link') ) {
            the_header_image_tag( array( 'class' => 'gridbit-header-img', 'alt' => '' ) );
        } else { ?>
            <a href="<?php echo esc_url( gridbit_header_image_destination() ); ?>" rel="home" class="gridbit-header-img-link"><?php the_header_image_tag( array( 'class' => 'gridbit-header-img', 'alt' => '' ) ); ?></a>
        <?php }
    }
}

function gridbit_header_image_details() {
    $header_image_custom_title = '';
    if ( gridbit_get_option('header_image_custom_title') ) {
        $header_image_custom_title = gridbit_get_option('header_image_custom_title');
    }

    $header_image_custom_description = '';
    if ( gridbit_get_option('header_image_custom_description') ) {
        $header_image_custom_description = gridbit_get_option('header_image_custom_description');
    }

    if ( !(gridbit_get_option('hide_header_image_details')) ) {
    if ( gridbit_get_option('header_image_custom_text') ) {
        if ( $header_image_custom_title || $header_image_custom_description ) { ?>
            <div class="gridbit-header-image-info">
            <div class="gridbit-header-image-info-inside">
                <?php if ( !(gridbit_get_option('hide_header_image_title')) ) { ?><?php if ( $header_image_custom_title ) { ?><p class="gridbit-header-image-site-title gridbit-header-image-block"><?php echo wp_kses_post( force_balance_tags( do_shortcode($header_image_custom_title) ) ); ?></p><?php } ?><?php } ?>
                <?php if ( !(gridbit_get_option('hide_header_image_description')) ) { ?><?php if ( $header_image_custom_description ) { ?><p class="gridbit-header-image-site-description gridbit-header-image-block"><?php echo wp_kses_post( force_balance_tags( do_shortcode($header_image_custom_description) ) ); ?></p><?php } ?><?php } ?>
            </div>
            </div>
        <?php }
    } else { ?>
        <div class="gridbit-header-image-info">
        <div class="gridbit-header-image-info-inside">
            <?php if ( !(gridbit_get_option('hide_header_image_title')) ) { ?><p class="gridbit-header-image-site-title gridbit-header-image-block"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p><?php } ?>
            <?php if ( !(gridbit_get_option('hide_header_image_description')) ) { ?><p class="gridbit-header-image-site-description gridbit-header-image-block"><?php bloginfo( 'description' ); ?></p><?php } ?>
        </div>
        </div>
    <?php }
    }
}

function gridbit_header_image_wrapper() { ?>
    <div class="gridbit-header-image gridbit-clearfix">
    <?php gridbit_header_image_markup(); ?>
    <?php gridbit_header_image_details(); ?>
    </div>
<?php }

function gridbit_header_image() {
    if ( gridbit_get_option('hide_header_image') ) { return; }
    if ( get_header_image() ) {
        gridbit_header_image_wrapper();
    }
}