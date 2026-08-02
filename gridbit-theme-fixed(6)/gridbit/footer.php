<?php
/**
* The template for displaying the footer
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

</div>

</div><!--/#gridbit-content-wrapper -->
</div><!--/#gridbit-wrapper -->

<?php gridbit_bottom_wide_widgets(); ?>

<?php /* Secondary menu bar (Menu button + search) removed per site request */ ?>

<?php gridbit_before_footer(); ?>

<?php /* Footer widget areas (Archives, Categories, etc.) removed per site request */ ?>

<?php gridbit_after_footer(); ?>

<?php /* Copyright bar (getlegacyhomes.com text) removed per site request */ ?>

<?php if ( gridbit_is_backtotop_active() ) { ?><button class="gridbit-scroll-top" title="<?php esc_attr_e('Scroll to Top','gridbit'); ?>"><i class="fas fa-arrow-up" aria-hidden="true"></i><span class="gridbit-sr-only"><?php esc_html_e('Scroll to Top', 'gridbit'); ?></span></button><?php } ?>

<?php wp_footer(); ?>
</div>
</body>
</html>