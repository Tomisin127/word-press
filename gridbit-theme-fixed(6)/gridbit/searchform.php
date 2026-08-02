<?php
/**
* The file for displaying the search form
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/
?>

<form role="search" method="get" class="gridbit-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<label>
    <span class="gridbit-sr-only"><?php echo esc_html_x( 'Search for:', 'label', 'gridbit' ); ?></span>
    <input type="search" class="gridbit-search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'gridbit' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
</label>
<input type="submit" class="gridbit-search-submit" value="<?php echo esc_attr_x( '&#xf002;', 'submit button', 'gridbit' ); ?>" />
</form>