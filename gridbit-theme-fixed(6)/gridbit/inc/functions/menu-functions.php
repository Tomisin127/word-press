<?php
/**
* Menu Functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a "Home" link as the first item
function gridbit_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'gridbit_page_menu_args' );

function gridbit_primary_menu_text() {
   $menu_text = esc_html__( 'Menu', 'gridbit' );
    if ( gridbit_get_option('primary_menu_text') ) {
        $menu_text = gridbit_get_option('primary_menu_text');
    }
   return apply_filters( 'gridbit_primary_menu_text', $menu_text );
}

function gridbit_secondary_menu_text() {
   $menu_text = esc_html__( 'Menu', 'gridbit' );
    if ( gridbit_get_option('secondary_menu_text') ) {
        $menu_text = gridbit_get_option('secondary_menu_text');
    }
   return apply_filters( 'gridbit_secondary_menu_text', $menu_text );
}

function gridbit_top_fallback_menu() {
   wp_page_menu( array(
        'sort_column'  => 'menu_order, post_title',
        'menu_id'      => 'gridbit-menu-secondary-navigation',
        'menu_class'   => 'gridbit-secondary-nav-menu gridbit-menu-secondary',
        'container'    => 'ul',
        'echo'         => true,
        'link_before'  => '',
        'link_after'   => '',
        'before'       => '',
        'after'        => '',
        'item_spacing' => 'discard',
        'walker'       => '',
    ) );
}

function gridbit_fallback_menu() {
   wp_page_menu( array(
        'sort_column'  => 'menu_order, post_title',
        'menu_id'      => 'gridbit-menu-primary-navigation',
        'menu_class'   => 'gridbit-primary-nav-menu gridbit-menu-primary',
        'container'    => 'ul',
        'echo'         => true,
        'link_before'  => '',
        'link_after'   => '',
        'before'       => '',
        'after'        => '',
        'item_spacing' => 'discard',
        'walker'       => '',
    ) );
}

function gridbit_secondary_menu_location() {
    $secondary_menu_location = 'before-footer';
    if ( gridbit_get_option('secondary_menu_location') ) {
        $secondary_menu_location = gridbit_get_option('secondary_menu_location');
    }
    return apply_filters( 'gridbit_secondary_menu_location', $secondary_menu_location );
}

function gridbit_secondary_menu_area() {
if ( gridbit_is_menu_social_bar_active() ) { ?>
<div class="gridbit-container gridbit-secondary-menu-container gridbit-clearfix">
<div class="gridbit-secondary-menu-container-inside gridbit-clearfix">
<nav class="gridbit-nav-secondary" id="gridbit-secondary-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation" aria-label="<?php esc_attr_e( 'Secondary Menu', 'gridbit' ); ?>">
<div class="gridbit-outer-wrapper">

<?php if ( gridbit_is_secondary_menu_active() ) { ?>
<button class="gridbit-secondary-responsive-menu-icon" aria-controls="gridbit-menu-secondary-navigation" aria-expanded="false"><?php echo esc_html( gridbit_secondary_menu_text() ); ?></button>
<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'gridbit-menu-secondary-navigation', 'menu_class' => 'gridbit-secondary-nav-menu gridbit-menu-secondary gridbit-clearfix', 'fallback_cb' => 'gridbit_top_fallback_menu', 'container' => '', ) ); ?>
<?php } ?>

<?php if ( gridbit_is_social_buttons_active() ) { ?>
<?php gridbit_social_buttons(); ?>

<?php if ( !(gridbit_get_option('hide_search_button')) ) { ?>
<div id="gridbit-search-overlay-wrap" class="gridbit-search-overlay">
  <div class="gridbit-search-overlay-content">
    <?php get_search_form(); ?>
  </div>
  <button class="gridbit-search-closebtn" aria-label="<?php esc_attr_e( 'Close Search', 'gridbit' ); ?>" title="<?php esc_attr_e('Close Search','gridbit'); ?>">&#xD7;</button>
</div>
<?php } ?>
<?php } ?>

</div>
</nav>
</div>
</div>
<?php }
}