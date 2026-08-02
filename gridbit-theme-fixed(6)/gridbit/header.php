<?php
/**
* The header for GridBit theme.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="gridbit-site-body" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#gridbit-posts-wrapper"><?php esc_html_e( 'Skip to content', 'gridbit' ); ?></a>

<div class="gridbit-site-container">
<?php if ( 'before-header' === gridbit_secondary_menu_location() ) { ?><?php gridbit_secondary_menu_area(); ?><?php } ?>

<?php gridbit_before_header(); ?>

<?php gridbit_header_image(); ?>

<div class="gridbit-site-header gridbit-container" id="gridbit-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
<div class="gridbit-head-content gridbit-clearfix" id="gridbit-head-content">

<?php if ( gridbit_is_header_content_active() ) { ?>
<div class="gridbit-header-inside gridbit-clearfix">
<div class="gridbit-header-inside-content gridbit-clearfix">
<div class="gridbit-outer-wrapper">
<div class="gridbit-header-inside-container">

<div class="gridbit-logo">
<?php if ( has_custom_logo() ) : ?>
    <div class="site-branding site-branding-full">
    <div class="gridbit-custom-logo-image">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="gridbit-logo-img-link">
        <img src="<?php echo esc_url( gridbit_custom_logo() ); ?>" alt="" class="gridbit-logo-img"/>
    </a>
    </div>
    <div class="gridbit-custom-logo-info"><?php gridbit_site_title(); ?></div>
    </div>
<?php else: ?>
    <div class="site-branding">
      <?php gridbit_site_title(); ?>
    </div>
<?php endif; ?>
</div>

<?php if ( gridbit_is_primary_menu_active() ) { ?>
<div class="gridbit-header-menu">
<div class="gridbit-container gridbit-primary-menu-container gridbit-clearfix">
<div class="gridbit-primary-menu-container-inside gridbit-clearfix">
<nav class="gridbit-nav-primary" id="gridbit-primary-navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'gridbit' ); ?>">
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'gridbit-menu-primary-navigation', 'menu_class' => 'gridbit-primary-nav-menu gridbit-menu-primary gridbit-clearfix', 'fallback_cb' => 'gridbit_fallback_menu', 'container' => '', ) ); ?>


</nav>
</div>
</div>
</div>
<?php } ?>

</div>
</div>
</div>
</div>
<?php } else { ?>
<div class="gridbit-no-header-content">
  <?php gridbit_site_title(); ?>
</div>
<?php } ?>

</div><!--/#gridbit-head-content -->
</div><!--/#gridbit-header -->

<?php if ( 'after-header' === gridbit_secondary_menu_location() ) { ?><?php gridbit_secondary_menu_area(); ?><?php } ?>

<?php gridbit_after_header(); ?>

<div id="gridbit-header-end"></div>

<?php gridbit_top_wide_widgets(); ?>

<div class="gridbit-outer-wrapper" id="gridbit-wrapper-outside">

<div class="gridbit-container gridbit-clearfix" id="gridbit-wrapper">
<div class="gridbit-content-wrapper gridbit-clearfix" id="gridbit-content-wrapper">