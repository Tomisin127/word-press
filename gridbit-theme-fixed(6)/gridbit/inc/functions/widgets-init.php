<?php
/**
* Register widget area.
*
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_widgets_init() {

register_sidebar(array(
    'id' => 'gridbit-home-fullwidth-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Default HomePage)', 'gridbit' ),
    'description' => esc_html__( 'This full-width widget area is located after the header of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-fullwidth-widgets',
    'name' => esc_html__( 'Top Full Width Widgets (Everywhere)', 'gridbit' ),
    'description' => esc_html__( 'This full-width widget area is located after the header of your website. Widgets of this widget area are displayed on every page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-home-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Default HomePage)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content (above posts) of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-top-widgets',
    'name' => esc_html__( 'Above Content Widgets (Everywhere)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the top of the main content (above posts) of your website. Widgets of this widget area are displayed on every page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-home-left-top-widgets',
    'name' => esc_html__( 'Top Left Widgets (Default HomePage)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the left top of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-left-top-widgets',
    'name' => esc_html__( 'Top Left Widgets (Everywhere)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the left top of your website. Widgets of this widget area are displayed on every page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-home-right-top-widgets',
    'name' => esc_html__( 'Top Right Widgets (Default HomePage)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the right top of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-right-top-widgets',
    'name' => esc_html__( 'Top Right Widgets (Everywhere)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the right top of your website. Widgets of this widget area are displayed on every page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-home-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Default HomePage)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content (below posts) of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-bottom-widgets',
    'name' => esc_html__( 'Below Content Widgets (Everywhere)', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the bottom of the main content (below posts) of your website. Widgets of this widget area are displayed on every page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-home-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Default HomePage)', 'gridbit' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on the default homepage of your website (when you are showing your latest posts on homepage).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-fullwidth-bottom-widgets',
    'name' => esc_html__( 'Bottom Full Width Widgets (Everywhere)', 'gridbit' ),
    'description' => esc_html__( 'This full-width widget area is located before the footer of your website. Widgets of this widget area are displayed on every page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-single-post-bottom-widgets',
    'name' => esc_html__( 'Single Post Bottom Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located at the bottom of single post of any post type (except attachments and pages).', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

register_sidebar(array(
    'id' => 'gridbit-top-footer',
    'name' => esc_html__( 'Footer Top Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located on the top of the footer of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridbit-footer-1',
    'name' => esc_html__( 'Footer 1 Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is the column 1 of the footer of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridbit-footer-2',
    'name' => esc_html__( 'Footer 2 Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is the column 2 of the footer of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridbit-footer-3',
    'name' => esc_html__( 'Footer 3 Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is the column 3 of the footer of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridbit-bottom-footer',
    'name' => esc_html__( 'Footer Bottom Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located on the bottom of the footer of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2>'));

register_sidebar(array(
    'id' => 'gridbit-404-widgets',
    'name' => esc_html__( '404 Page Widgets', 'gridbit' ),
    'description' => esc_html__( 'This widget area is located on the 404(not found) page of your website.', 'gridbit' ),
    'before_widget' => '<div id="%1$s" class="gridbit-main-widget widget gridbit-widget-box %2$s"><div class="gridbit-widget-box-inside">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="gridbit-widget-header"><div class="gridbit-widget-header-inside"><h2 class="gridbit-widget-title"><span class="gridbit-widget-title-inside">',
    'after_title' => '</span></h2></div></div>'));

}
add_action( 'widgets_init', 'gridbit_widgets_init' );

function gridbit_top_wide_widgets() { ?>

<?php if ( is_active_sidebar( 'gridbit-home-fullwidth-widgets' ) || is_active_sidebar( 'gridbit-fullwidth-widgets' ) ) : ?>
<div class="gridbit-outer-wrapper">
<div class="gridbit-top-wrapper-outer gridbit-clearfix">
<div class="gridbit-featured-posts-area gridbit-top-wrapper gridbit-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridbit-home-fullwidth-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridbit-fullwidth-widgets' ); ?>
</div>
</div>
</div>
<?php endif; ?>

<?php }


function gridbit_top_widgets() { ?>

<?php if ( is_active_sidebar( 'gridbit-home-top-widgets' ) || is_active_sidebar( 'gridbit-top-widgets' ) ) : ?>
<div class="gridbit-featured-posts-area gridbit-featured-posts-area-top gridbit-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridbit-home-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridbit-top-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function gridbit_top_left_right_widgets() { ?>

<div class="gridbit-left-right-wrapper gridbit-clearfix">

<?php if ( is_active_sidebar( 'gridbit-home-left-top-widgets' ) || is_active_sidebar( 'gridbit-left-top-widgets' ) ) : ?>
<div class="gridbit-left-top-wrapper">
<div class="gridbit-featured-posts-area gridbit-featured-posts-area-top gridbit-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridbit-home-left-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridbit-left-top-widgets' ); ?>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'gridbit-home-right-top-widgets' ) || is_active_sidebar( 'gridbit-right-top-widgets' ) ) : ?>
<div class="gridbit-right-top-wrapper">
<div class="gridbit-featured-posts-area gridbit-featured-posts-area-top gridbit-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridbit-home-right-top-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridbit-right-top-widgets' ); ?>
</div>
</div>
<?php endif; ?>

</div>

<?php }


function gridbit_bottom_widgets() { ?>

<?php if ( is_active_sidebar( 'gridbit-home-bottom-widgets' ) || is_active_sidebar( 'gridbit-bottom-widgets' ) ) : ?>
<div class='gridbit-featured-posts-area gridbit-featured-posts-area-bottom gridbit-clearfix'>
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridbit-home-bottom-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridbit-bottom-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function gridbit_bottom_wide_widgets() { ?>

<?php if ( is_active_sidebar( 'gridbit-home-fullwidth-bottom-widgets' ) || is_active_sidebar( 'gridbit-fullwidth-bottom-widgets' ) ) : ?>
<div class="gridbit-outer-wrapper">
<div class="gridbit-bottom-wrapper-outer gridbit-clearfix">
<div class="gridbit-featured-posts-area gridbit-bottom-wrapper gridbit-clearfix">
<?php if ( is_front_page() && is_home() && !is_paged() ) { ?>
<?php dynamic_sidebar( 'gridbit-home-fullwidth-bottom-widgets' ); ?>
<?php } ?>

<?php dynamic_sidebar( 'gridbit-fullwidth-bottom-widgets' ); ?>
</div>
</div>
</div>
<?php endif; ?>

<?php }


function gridbit_404_widgets() { ?>

<?php if ( is_active_sidebar( 'gridbit-404-widgets' ) ) : ?>
<div class="gridbit-featured-posts-area gridbit-featured-posts-area-top gridbit-clearfix">
<?php dynamic_sidebar( 'gridbit-404-widgets' ); ?>
</div>
<?php endif; ?>

<?php }


function gridbit_post_bottom_widgets() {
    if ( is_singular() ) {
        global $post;
        if ( is_active_sidebar( 'gridbit-single-post-bottom-widgets' ) ) : ?>
            <div class="gridbit-featured-posts-area gridbit-clearfix">
            <?php dynamic_sidebar( 'gridbit-single-post-bottom-widgets' ); ?>
            </div>
        <?php endif;
    }
}