<?php
/**
* Template part for displaying single posts.
* Updated for premium property page layout with full-width hero gallery.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<?php gridbit_before_single_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gridbit-post-singular gridbit-property-post'); ?>>

	<!-- Full-Width Hero Carousel Section (No padding/margin) -->
	<div class="gpc-hero-gallery-section">
		<?php gridbit_top_single_post_content(); ?>
	</div>

	<!-- Property Information & Content Section -->
	<div class="gridbit-post-content-wrapper">
		<div class="gridbit-post-content-inside gridbit-clearfix">

			<?php gridbit_before_single_post_title(); ?>

			<!-- Property Header: Title & Key Info -->
			<?php if ( ! gridbit_get_option( 'hide_post_title' ) ) { ?>
			<header class="gpc-property-header">
				<div class="gpc-property-header-inside">
					<?php if ( gridbit_get_option( 'remove_post_title_link' ) ) { ?>
						<?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>
					<?php } else { ?>
						<?php the_title( sprintf( '<h1 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
					<?php } ?>
				</div>
			</header><!-- .gpc-property-header -->
			<?php } ?>

			<?php gridbit_after_single_post_title(); ?>

			<!-- Main Content: Description & FAQ Sections -->
			<div class="entry-content gridbit-clearfix gpc-property-content">
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

			<?php gridbit_after_single_post_content(); ?>

			<!-- Tags (if enabled) -->
			<?php if ( ! gridbit_get_option( 'hide_post_tags' ) && has_tag() ) { ?>
			<footer class="entry-footer gridbit-entry-footer gpc-property-footer">
				<div class="gridbit-entry-footer-inside">
					<?php gridbit_post_tags(); ?>
				</div>
			</footer><!-- .entry-footer -->
			<?php } ?>

			<!-- Author Bio Box (if enabled) -->
			<?php if ( ! gridbit_get_option( 'hide_author_bio_box' ) ) { 
				echo wp_kses_post( force_balance_tags( gridbit_add_author_bio_box() ) ); 
			} ?>

		</div><!-- .gridbit-post-content-inside -->
	</div><!-- .gridbit-post-content-wrapper -->

</article>

<?php gridbit_after_single_post(); ?>
