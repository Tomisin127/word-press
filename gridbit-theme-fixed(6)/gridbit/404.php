<?php
/**
* The template for displaying 404 pages (not found).
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

get_header(); ?>

<div class='gridbit-main-wrapper gridbit-clearfix' id='gridbit-main-wrapper' itemscope='itemscope' itemtype='http://schema.org/Blog' role='main'>
<div class="gridbit-main-wrapper-inside gridbit-clearfix">

<div class='gridbit-posts-wrapper' id='gridbit-posts-wrapper'>

<div class='gridbit-posts gridbit-box'>
<div class="gridbit-box-inside">

<div class="gridbit-page-header-outside">
<header class="gridbit-page-header">
<div class="gridbit-page-header-inside">
    <?php if ( gridbit_get_option('error_404_heading') ) : ?>
    <h1 class="page-title"><?php echo esc_html( gridbit_get_option('error_404_heading') ); ?></h1>
    <?php else : ?>
    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'gridbit' ); ?></h1>
    <?php endif; ?>
</div>
</header><!-- .gridbit-page-header -->
</div>

<div class='gridbit-posts-content'>

    <?php if ( gridbit_get_option('error_404_message') ) : ?>
    <p><?php echo wp_kses_post( force_balance_tags( gridbit_get_option('error_404_message') ) ); ?></p>
    <?php else : ?>
    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'gridbit' ); ?></p>
    <?php endif; ?>

    <?php if ( !(gridbit_get_option('hide_404_search')) ) { ?><?php get_search_form(); ?><?php } ?>

</div>

</div>
</div>

</div><!--/#gridbit-posts-wrapper -->

<?php gridbit_404_widgets(); ?>

</div>
</div><!-- /#gridbit-main-wrapper -->

<?php get_footer(); ?>