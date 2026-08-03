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

	<!--
	Full-Width Hero Gallery Section.
	The Post Carousel plugin renders the property image carousel (with its
	built-in image slides, arrows, dots and map toggle) into the
	`gridbit_after_single_post_title` hook, so calling that hook here — at
	the very top, before any title — places the gallery as the full-width
	hero. The visible <h1> title is intentionally NOT printed here; the
	plugin's property info block renders the title (plus badges, price and
	action icons) directly beneath the gallery, matching the reference
	real-estate layout and avoiding a duplicate title.
	-->
	<div class="gpc-hero-gallery-section">
		<?php
		gridbit_before_single_post_title();
		gridbit_after_single_post_title();
		?>
	</div>

	<!-- Property Information & Content Section -->
	<div class="gridbit-post-content-wrapper">
		<div class="gridbit-post-content-inside gridbit-clearfix">

			<!-- Main Content: Property info block + Description/FAQ sections -->
			<div class="entry-content gridbit-clearfix gpc-property-content">
				<?php
				gridbit_top_single_post_content();

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
