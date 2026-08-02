<?php
/**
* The template for displaying all single posts.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

<?php while (have_posts()) : the_post();

    get_template_part( 'template-parts/content-single' );

    gridbit_post_navigation();

    gridbit_post_bottom_widgets();

    // If comments are open or we have at least one comment, load up the comment template
    if ( comments_open() || get_comments_number() ) :
            comments_template();
    endif;

endwhile; ?>

<div class="clear"></div>
</div><!--/#gridbit-posts-wrapper -->

<?php gridbit_after_main_content(); ?>

</div>
</div><!-- /#gridbit-main-wrapper -->

<?php get_footer(); ?>