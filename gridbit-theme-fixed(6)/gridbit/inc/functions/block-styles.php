<?php
/**
* Block Styles
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

/**
 * Register Custom Block Styles
 */

if ( function_exists( 'register_block_style' ) ) :
    function gridbit_register_block_styles() {

        /**
         * Register block style
         */
        register_block_style( 'core/button', array( 'name' => 'gridbit-button', 'label' => __( 'GridBit Button', 'gridbit' ), 'is_default' => true, 'style_handle' => 'gridbit-maincss', ) ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style

    }
    add_action( 'init', 'gridbit_register_block_styles' );
endif;