<?php
/**
* The main template file.
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query.
* E.g., it puts together the home page when no home.php file exists.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

get_header(); ?>

<div class="gridbit-main-wrapper gridbit-clearfix" id="gridbit-main-wrapper" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
<div class="gridbit-main-wrapper-inside gridbit-clearfix">

<?php gridbit_before_main_content(); ?>

<div class="gridbit-posts-wrapper" id="gridbit-posts-wrapper">

<?php if ( !(gridbit_get_option('hide_posts_heading')) ) { ?>
<?php if(is_home() && !is_paged()) { ?>
<?php if ( gridbit_get_option('posts_heading') ) : ?>
<div class="gridbit-posts-header"><div class="gridbit-posts-header-inside"><h2 class="gridbit-posts-heading"><span class="gridbit-posts-heading-inside"><?php echo esc_html( gridbit_get_option('posts_heading') ); ?></span></h2></div></div>
<?php else : ?>
<div class="gridbit-posts-header"><div class="gridbit-posts-header-inside"><h2 class="gridbit-posts-heading"><span class="gridbit-posts-heading-inside"><?php esc_html_e( 'Recent Posts', 'gridbit' ); ?></span></h2></div></div>
<?php endif; ?>
<?php } ?>
<?php } ?>

<div class="gridbit-posts-content">

<?php if (have_posts()) : ?>

    <?php if ( !(gridbit_get_option('disable_posts_grid')) ) { ?>

    <div class="gridbit-posts gridbit-posts-grid">
    <?php $gridbit_post_counter=1; while (have_posts()) : the_post(); ?>

        <?php get_template_part( 'template-parts/content-grid' ); ?>

    <?php $gridbit_post_counter++; endwhile; ?>
    </div>

    <?php } else { ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'template-parts/content-nongrid' ); ?>
    <?php endwhile; ?>

    <?php } ?>

    <div class="clear"></div>

    <?php gridbit_posts_navigation(); ?>

<?php else : ?>

  <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

</div>

</div><!--/#gridbit-posts-wrapper -->

<?php gridbit_after_main_content(); ?>

</div>
</div><!-- /#gridbit-main-wrapper -->

<?php get_footer(); ?>