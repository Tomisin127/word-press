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

<?php $gridbit_grid_post_content = get_the_content(); ?>
<div id="gridbit-grid-post-<?php the_ID(); ?>" class="gridbit-grid-post gridbit-3-col">
<div class="gridbit-grid-post-inside">

    <?php gridbit_media_content_grid(); ?>

    <?php gridbit_grid_footer_meta(); ?>

    <?php if ( !(gridbit_get_option('hide_post_title_home')) ) { ?>
    <?php if ( gridbit_get_option('post_title_link_home') == 'no' ) { ?>
        <div class="gridbit-grid-post-header gridbit-grid-post-block gridbit-clearfix"><div class="gridbit-grid-post-header-inside gridbit-clearfix"><?php the_title( '<h3 class="gridbit-grid-post-title">', '</h3>' ); ?></div></div>
    <?php } else { ?>
        <div class="gridbit-grid-post-header gridbit-grid-post-block gridbit-clearfix"><div class="gridbit-grid-post-header-inside gridbit-clearfix"><?php the_title( sprintf( '<h3 class="gridbit-grid-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?></div></div>
    <?php } ?>
    <?php } ?>

    <?php if ( !(gridbit_get_option('hide_post_snippet')) ) { ?>
    <?php if ( !empty( $gridbit_grid_post_content ) ) { ?><div class="gridbit-grid-post-snippet gridbit-grid-post-block"><div class="gridbit-grid-post-snippet-inside"><?php the_excerpt(); ?></div></div><?php } ?>
    <?php } ?>

</div>
</div>