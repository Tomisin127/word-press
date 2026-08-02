<?php
/**
* Menu options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_menu_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_menu_options', array( 'title' => esc_html__( 'Menu Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 100 ) );

    $wp_customize->add_setting( 'gridbit_options[primary_menu_text]', array( 'default' => esc_html__( 'Menu', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'gridbit_primary_menu_text_control', array( 'label' => esc_html__( 'Primary Menu Mobile Text', 'gridbit' ), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[primary_menu_text]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridbit_options[disable_primary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_primary_menu_control', array( 'label' => esc_html__( 'Disable Primary Menu', 'gridbit' ), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[disable_primary_menu]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_header_search_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_header_search_button_control', array( 'label' => esc_html__( 'Hide Search Button from Primary Menu', 'gridbit' ), 'description' => esc_html__('This option has no effect if you have checked the option: "Disable Primary Menu".', 'gridbit'), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[hide_header_search_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[disable_underline_primary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_underline_primary_menu_control', array( 'label' => esc_html__( 'Disable Links Underline from Primary Menu', 'gridbit' ), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[disable_underline_primary_menu]', 'type' => 'checkbox', ) );


    $wp_customize->add_setting( 'gridbit_options[secondary_menu_text]', array( 'default' => esc_html__( 'Menu', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'gridbit_secondary_menu_text_control', array( 'label' => esc_html__( 'Secondary Menu Mobile Text', 'gridbit' ), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[secondary_menu_text]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'gridbit_options[disable_menu_social_bar]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_menu_social_bar_control', array( 'label' => esc_html__( 'Disable Secondary Menu + Social Area', 'gridbit' ), 'description' => esc_html__('If you checked this option, secondary menu and all buttons will disappear. There is no any effect from these options: "Disable Secondary Menu", "Hide Social Area", "Hide Search Button", "Show Login/Logout Button", "Show Random Post Button".', 'gridbit'), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[disable_menu_social_bar]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[disable_secondary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_secondary_menu_control', array( 'label' => esc_html__( 'Disable Secondary Menu', 'gridbit' ), 'description' => esc_html__('This option has no effect if you have checked the option: "Disable Secondary Menu + Social Area".', 'gridbit'), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[disable_secondary_menu]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[secondary_menu_location]', array( 'default' => 'before-footer', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_secondary_menu_location' ) );

    $wp_customize->add_control( 'gridbit_secondary_menu_location_control', array( 'label' => esc_html__( 'Select Secondary Menu Location', 'gridbit' ), 'description' => esc_html__('Select where you want to display secondary menu.', 'gridbit'), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[secondary_menu_location]', 'type' => 'select', 'choices' => array( 'before-header' => esc_html__('Before Header', 'gridbit'), 'after-header' => esc_html__('After Header', 'gridbit'), 'before-footer' => esc_html__('Before Footer', 'gridbit'), 'after-footer' => esc_html__('After Footer', 'gridbit') ) ) );

    $wp_customize->add_setting( 'gridbit_options[center_secondary_menu]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_center_secondary_menu_control', array( 'label' => esc_html__( 'Center Secondary Menu', 'gridbit' ), 'section' => 'gridbit_section_menu_options', 'settings' => 'gridbit_options[center_secondary_menu]', 'type' => 'checkbox', ) );

}