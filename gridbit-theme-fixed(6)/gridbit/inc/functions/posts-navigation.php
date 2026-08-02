<?php
/**
* Posts navigation functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

if ( ! function_exists( 'gridbit_wp_pagenavi' ) ) :
function gridbit_wp_pagenavi() {
    ?>
    <nav class="navigation posts-navigation gridbit-clearfix" role="navigation">
        <?php wp_pagenavi(); ?>
    </nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'gridbit_posts_navigation' ) ) :
function gridbit_posts_navigation() {
    if ( !(gridbit_get_option('hide_posts_navigation')) ) {
        if ( function_exists( 'wp_pagenavi' ) ) {
            gridbit_wp_pagenavi();
        } else {
            if ( gridbit_get_option('posts_navigation_type') === 'normalnavi' ) {
                the_posts_navigation(array('prev_text' => esc_html__( 'Older posts', 'gridbit' ), 'next_text' => esc_html__( 'Newer posts', 'gridbit' )));
            } else {
                the_posts_pagination(array('mid_size' => 2, 'prev_text' => esc_html__( '&larr; Newer posts', 'gridbit' ), 'next_text' => esc_html__( 'Older posts &rarr;', 'gridbit' )));
            }
        }
    }
}
endif;

if ( ! function_exists( 'gridbit_post_navigation' ) ) :
function gridbit_post_navigation() {
    global $post;
    if ( !(gridbit_get_option('hide_post_navigation')) ) {
            the_post_navigation(array('prev_text' => esc_html__( '%title &rarr;', 'gridbit' ), 'next_text' => esc_html__( '&larr; %title', 'gridbit' )));
    }
}
endif;