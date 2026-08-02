<?php
/**
* The template for displaying author archive pages.
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

<?php if ( !(gridbit_get_option('hide_author_title')) ) { ?>
<div class="gridbit-page-header-outside">
<header class="gridbit-page-header">
<div class="gridbit-page-header-inside">
<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
<?php if ( !(gridbit_get_option('hide_author_description')) ) { ?><?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?><?php } ?>
</div>
</header>
</div>
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