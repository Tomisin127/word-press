<?php
/**
* Template part for displaying posts.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gridbit-post-singular gridbit-post-nongrid gridbit-box'); ?>>
<div class="gridbit-box-inside">

    <?php gridbit_before_nongrid_post_title(); ?>

    <header class="entry-header">
    <div class="entry-header-inside gridbit-clearfix">
        <?php the_title( sprintf( '<h1 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

        <?php gridbit_nongrid_postmeta(); ?>
    </div>
    </header><!-- .entry-header -->

    <?php gridbit_after_nongrid_post_title(); ?>

    <div class="entry-content gridbit-clearfix">
            <?php
            the_content( sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="gridbit-sr-only"> "%s"</span> <span class="meta-nav">&rarr;</span>', 'gridbit' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ) );

            wp_link_pages( array(
             'before'      => '<div class="gridbit-clearfix"></div><div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'gridbit' ) . '</span>',
             'after'       => '</div>',
             'link_before' => '<span>',
             'link_after'  => '</span>',
             ) );
            ?>
    </div><!-- .entry-content -->

    <?php if ( !(gridbit_get_option('hide_post_tags_home')) && has_tag() ) { ?>
    <footer class="entry-footer gridbit-entry-footer">
    <div class="gridbit-entry-footer-inside">
        <?php gridbit_post_tags(); ?>
    </div>
    </footer><!-- .entry-footer -->
    <?php } ?>

</div>
</article>