<?php
/**
* Other options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_other_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_other_options', array( 'title' => esc_html__( 'Other Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 600 ) );

    $wp_customize->add_setting( 'gridbit_options[enable_widgets_block_editor]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_enable_widgets_block_editor_control', array( 'label' => esc_html__( 'Enable Gutenberg Widget Block Editor', 'gridbit' ), 'section' => 'gridbit_section_other_options', 'settings' => 'gridbit_options[enable_widgets_block_editor]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[disable_loading_animation]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_loading_animation_control', array( 'label' => esc_html__( 'Disable Site Loading Animation', 'gridbit' ), 'section' => 'gridbit_section_other_options', 'settings' => 'gridbit_options[disable_loading_animation]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[enable_fitvids]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_enable_fitvids_control', array( 'label' => esc_html__( 'Enable FitVids.JS', 'gridbit' ), 'description' => esc_html__( 'You can enable fitvids.js script if you are using videos on your website and if you want fluid width videos in your post content.', 'gridbit' ), 'section' => 'gridbit_section_other_options', 'settings' => 'gridbit_options[enable_fitvids]', 'type' => 'checkbox', ) );

}