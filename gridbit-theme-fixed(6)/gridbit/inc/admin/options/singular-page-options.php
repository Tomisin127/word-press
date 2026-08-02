<?php
/**
* Page options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_page_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_page', array( 'title' => esc_html__( 'Page Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 190 ) );

    $wp_customize->add_setting( 'gridbit_options[thumbnail_alignment_page]', array( 'default' => 'gridbit-thumbnail-alignwide', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_thumbnail_alignment' ) );

    $wp_customize->add_control( 'gridbit_thumbnail_alignment_page_control', array( 'label' => esc_html__( 'Featured Image Alignment', 'gridbit' ), 'description' => esc_html__('Select the alignment of featured image in single page.', 'gridbit'), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[thumbnail_alignment_page]', 'type' => 'select', 'choices' => array( 'gridbit-thumbnail-aligncenter' => esc_html__('Center', 'gridbit'), 'gridbit-thumbnail-alignwide' => esc_html__('Wide', 'gridbit'), 'gridbit-thumbnail-alignfull' => esc_html__('Full', 'gridbit') ) ) );

    $wp_customize->add_setting( 'gridbit_options[thumbnail_link_page]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_yes_no' ) );

    $wp_customize->add_control( 'gridbit_thumbnail_link_page_control', array( 'label' => esc_html__( 'Featured Image Link', 'gridbit' ), 'description' => esc_html__('Do you want the featured image in a page to be linked to its page?', 'gridbit'), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[thumbnail_link_page]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'gridbit'), 'no' => esc_html__('No', 'gridbit') ) ) );

    $wp_customize->add_setting( 'gridbit_options[hide_page_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_page_thumbnail_control', array( 'label' => esc_html__( 'Hide Featured Image from Single Page', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[hide_page_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[featured_media_above_page_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_featured_media_above_page_title_control', array( 'label' => esc_html__( 'Move Featured Image to the Top of Page Title', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[featured_media_above_page_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_page_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_page_title_control', array( 'label' => esc_html__( 'Hide Page Header from Single Page', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[hide_page_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[remove_page_title_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_remove_page_title_link_control', array( 'label' => esc_html__( 'Remove Link from Single Page Title', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[remove_page_title_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_page_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_page_date_control', array( 'label' => esc_html__( 'Hide Posted Date from Single Page', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[hide_page_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_page_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_page_author_control', array( 'label' => esc_html__( 'Hide Page Author from Single Page', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[hide_page_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_page_comments]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_page_comments_control', array( 'label' => esc_html__( 'Hide Comment Link from Single Page', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[hide_page_comments]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[show_page_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_show_page_edit_control', array( 'label' => esc_html__( 'Show Edit Link on Single Page', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[show_page_edit]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_static_page_meta]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_static_page_meta_control', array( 'label' => esc_html__( 'Hide Page Meta Data (Page Date, Page Author, Comment Link) from Static Homepage', 'gridbit' ), 'section' => 'gridbit_section_page', 'settings' => 'gridbit_options[hide_static_page_meta]', 'type' => 'checkbox', ) );

}