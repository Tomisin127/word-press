<?php
/**
* Footer options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_footer_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_footer', array( 'title' => esc_html__( 'Footer Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 280 ) );

    $wp_customize->add_setting( 'gridbit_options[footer_text]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_html', ) );

    $wp_customize->add_control( 'gridbit_footer_text_control', array( 'label' => esc_html__( 'Footer copyright notice', 'gridbit' ), 'section' => 'gridbit_section_footer', 'settings' => 'gridbit_options[footer_text]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_footer_widgets]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_footer_widgets_control', array( 'label' => esc_html__( 'Hide Footer Widgets', 'gridbit' ), 'section' => 'gridbit_section_footer', 'settings' => 'gridbit_options[hide_footer_widgets]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[disable_backtotop]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_backtotop_control', array( 'label' => esc_html__( 'Disable Back to Top Button', 'gridbit' ), 'section' => 'gridbit_section_footer', 'settings' => 'gridbit_options[disable_backtotop]', 'type' => 'checkbox', ) );

}