<?php
/**
* Media functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_media_content_grid() {
    global $post; ?>
    <?php if ( !(gridbit_get_option('hide_thumbnail_home')) ) { ?>
    <?php if ( has_post_thumbnail($post->ID) ) { ?>
    <div class="gridbit-grid-post-thumbnail gridbit-grid-post-block">
        <?php if ( gridbit_get_option('thumbnail_link_home') == 'no' ) { ?>
            <?php the_post_thumbnail('gridbit-360w-270h-image', array('class' => 'gridbit-grid-post-thumbnail-img', 'title' => the_title_attribute('echo=0'))); ?>
        <?php } else { ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="gridbit-grid-post-thumbnail-link" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridbit' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail('gridbit-360w-270h-image', array('class' => 'gridbit-grid-post-thumbnail-img', 'title' => the_title_attribute('echo=0'))); ?></a>
        <?php } ?>
        <?php gridbit_grid_header_meta(); ?>
    </div>
    <?php } else { ?>
    <?php if ( !(gridbit_get_option('hide_default_thumbnail')) ) { ?>
    <div class="gridbit-grid-post-thumbnail gridbit-grid-post-thumbnail-default gridbit-grid-post-block">
        <?php if ( gridbit_get_option('thumbnail_link_home') == 'no' ) { ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/no-image-360-270.jpg' ); ?>" class="gridbit-grid-post-thumbnail-img"/>
        <?php } else { ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="gridbit-grid-post-thumbnail-link" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridbit' ), the_title_attribute( 'echo=0' ) ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/no-image-360-270.jpg' ); ?>" class="gridbit-grid-post-thumbnail-img"/></a>
        <?php } ?>
        <?php gridbit_grid_header_meta(); ?>
    </div>
    <?php } ?>
    <?php } ?>
    <?php } ?>
<?php }

function gridbit_media_content_single() {
    global $post;
    if ( has_post_thumbnail() ) {
        if ( !(gridbit_get_option('hide_thumbnail')) ) {
            if ( gridbit_get_option('thumbnail_link') == 'no' ) { ?>
                <div class="gridbit-post-thumbnail-single <?php echo esc_attr( gridbit_thumbnail_alignment_single() ); ?>">
                <?php the_post_thumbnail('gridbit-770w-autoh-image', array('class' => 'gridbit-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?>
                </div>
            <?php } else { ?>
                <div class="gridbit-post-thumbnail-single <?php echo esc_attr( gridbit_thumbnail_alignment_single() ); ?>">
                <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridbit' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridbit-post-thumbnail-single-link"><?php the_post_thumbnail('gridbit-770w-autoh-image', array('class' => 'gridbit-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                </div>
    <?php   }
        }
    }
}

function gridbit_media_content_single_location() {
    global $post;
    if( gridbit_get_option('featured_media_above_post_title') ) {
        add_action('gridbit_before_single_post_title', 'gridbit_media_content_single', 10 );
    } else {
        add_action('gridbit_after_single_post_title', 'gridbit_media_content_single', 10 );
    }
}
add_action('template_redirect', 'gridbit_media_content_single_location', 100 );

function gridbit_media_content_page() {
    global $post; ?>
    <?php
    if ( has_post_thumbnail() ) {
        if ( !(gridbit_get_option('hide_page_thumbnail')) ) {
            if ( gridbit_get_option('thumbnail_link_page') == 'no' ) { ?>
                <div class="gridbit-post-thumbnail-single <?php echo esc_attr( gridbit_thumbnail_alignment_page() ); ?>">
                <?php the_post_thumbnail('gridbit-770w-autoh-image', array('class' => 'gridbit-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?>
                </div>
            <?php } else { ?>
                <div class="gridbit-post-thumbnail-single <?php echo esc_attr( gridbit_thumbnail_alignment_page() ); ?>">
                <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridbit' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridbit-post-thumbnail-single-link"><?php the_post_thumbnail('gridbit-770w-autoh-image', array('class' => 'gridbit-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                </div>
    <?php   }
        }
    }
    ?>
<?php }

function gridbit_media_content_page_location() {
    global $post;
    if( gridbit_get_option('featured_media_above_page_title') ) {
        add_action('gridbit_before_single_page_title', 'gridbit_media_content_page', 10 );
    } else {
        add_action('gridbit_after_single_page_title', 'gridbit_media_content_page', 10 );
    }
}
add_action('template_redirect', 'gridbit_media_content_page_location', 110 );

function gridbit_media_content_nongrid() {
    global $post;
    if ( has_post_thumbnail() ) {
        if ( !(gridbit_get_option('hide_thumbnail_home')) ) {
            if ( gridbit_get_option('thumbnail_link_home') == 'no' ) { ?>
                <div class="gridbit-post-thumbnail-single <?php echo esc_attr( gridbit_thumbnail_alignment_non_grid() ); ?>">
                <?php the_post_thumbnail('gridbit-770w-autoh-image', array('class' => 'gridbit-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?>
                </div>
            <?php } else { ?>
                <div class="gridbit-post-thumbnail-single <?php echo esc_attr( gridbit_thumbnail_alignment_non_grid() ); ?>">
                <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php /* translators: %s: post title. */ echo esc_attr( sprintf( __( 'Permanent Link to %s', 'gridbit' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="gridbit-post-thumbnail-single-link"><?php the_post_thumbnail('gridbit-770w-autoh-image', array('class' => 'gridbit-post-thumbnail-single-img', 'title' => the_title_attribute('echo=0'))); ?></a>
                </div>
    <?php   }
        }
    }
}

function gridbit_media_content_nongrid_location() {
    if( gridbit_get_option('featured_nongrid_media_above_post_title') ) {
        add_action('gridbit_before_nongrid_post_title', 'gridbit_media_content_nongrid', 10 );
    } else {
        add_action('gridbit_after_nongrid_post_title', 'gridbit_media_content_nongrid', 10 );
    }
}
add_action('template_redirect', 'gridbit_media_content_nongrid_location', 120 );