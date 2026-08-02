<?php
/**
* Post options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_post_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_post', array( 'title' => esc_html__( 'Post Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 180 ) );

    $wp_customize->add_setting( 'gridbit_options[thumbnail_alignment_single]', array( 'default' => 'gridbit-thumbnail-alignwide', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_thumbnail_alignment' ) );

    $wp_customize->add_control( 'gridbit_thumbnail_alignment_single_control', array( 'label' => esc_html__( 'Featured Image Alignment', 'gridbit' ), 'description' => esc_html__('Select the alignment of featured image in full post.', 'gridbit'), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[thumbnail_alignment_single]', 'type' => 'select', 'choices' => array( 'gridbit-thumbnail-aligncenter' => esc_html__('Center', 'gridbit'), 'gridbit-thumbnail-alignwide' => esc_html__('Wide', 'gridbit'), 'gridbit-thumbnail-alignfull' => esc_html__('Full', 'gridbit') ) ) );

    $wp_customize->add_setting( 'gridbit_options[thumbnail_link]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_yes_no' ) );

    $wp_customize->add_control( 'gridbit_thumbnail_link_control', array( 'label' => esc_html__( 'Featured Image Link', 'gridbit' ), 'description' => esc_html__('Do you want the featured image in a single post to be linked to its post?', 'gridbit'), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[thumbnail_link]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'gridbit'), 'no' => esc_html__('No', 'gridbit') ) ) );

    $wp_customize->add_setting( 'gridbit_options[hide_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_thumbnail_control', array( 'label' => esc_html__( 'Hide Featured Image from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[featured_media_above_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_featured_media_above_post_title_control', array( 'label' => esc_html__( 'Move Featured Image to the Top of Full Post Title', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[featured_media_above_post_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_title_control', array( 'label' => esc_html__( 'Hide Post Header from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_post_title]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[remove_post_title_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_remove_post_title_link_control', array( 'label' => esc_html__( 'Remove Link from Full Post Title', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[remove_post_title_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_categories]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_categories_control', array( 'label' => esc_html__( 'Hide Post Categories from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_post_categories]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_author_control', array( 'label' => esc_html__( 'Hide Post Author from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_post_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_posted_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_posted_date_control', array( 'label' => esc_html__( 'Hide Posted Date from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_posted_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_comments_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_comments_link_control', array( 'label' => esc_html__( 'Hide Comment Link from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_comments_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[show_post_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_show_post_edit_control', array( 'label' => esc_html__( 'Show Post Edit Link', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[show_post_edit]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_tags]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_tags_control', array( 'label' => esc_html__( 'Hide Post Tags from Full Post', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_post_tags]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_author_bio_box]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_author_bio_box_control', array( 'label' => esc_html__( 'Hide Author Bio Box', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[hide_author_bio_box]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[no_underline_content_links]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_no_underline_content_links_control', array( 'label' => esc_html__( 'Do not Underline the Links within the Content', 'gridbit' ), 'section' => 'gridbit_section_post', 'settings' => 'gridbit_options[no_underline_content_links]', 'type' => 'checkbox', ) );

}