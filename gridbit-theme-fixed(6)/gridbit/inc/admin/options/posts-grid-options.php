<?php
/**
* Posts Grid options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_posts_grid_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_posts_grid', array( 'title' => esc_html__( 'Posts Grid Options', 'gridbit' ), 'description' => esc_html__('To display your latest posts as a grid on your homepage, please set the "Your homepage displays" option to "Your latest posts." You can find this setting in your WordPress Dashboard by navigating to "Settings" -> "Reading" -> "Your homepage displays."', 'gridbit'), 'panel' => 'gridbit_main_options_panel', 'priority' => 160 ) );

    $wp_customize->add_setting( 'gridbit_options[hide_posts_heading]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_posts_heading_control', array( 'label' => esc_html__( 'Hide HomePage Posts Heading', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_posts_heading]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[posts_heading]', array( 'default' => esc_html__( 'Recent Posts', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'gridbit_posts_heading_control', array( 'label' => esc_html__( 'HomePage Posts Heading', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[posts_heading]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'posts_per_page', array( 'default' => get_option('posts_per_page'), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_positive_integer' ) );

    $wp_customize->add_control( 'gridbit_posts_per_page_control', array( 'label' => esc_html__( 'Number of Posts per Page', 'gridbit' ), 'description' => esc_html__('Set the maximum number of posts displayed on each blog page.', 'gridbit'), 'section' => 'gridbit_section_posts_grid', 'settings' => 'posts_per_page', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[hide_thumbnail_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_thumbnail_home_control', array( 'label' => esc_html__( 'Hide Featured Images from Posts Summaries', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_thumbnail_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_default_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_default_thumbnail_control', array( 'label' => esc_html__( 'Hide Default Featured Image', 'gridbit' ), 'description' => esc_html__( 'The default featured image is shown when there is no featured image is set.', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_default_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[thumbnail_link_home]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_yes_no' ) );

    $wp_customize->add_control( 'gridbit_thumbnail_link_home_control', array( 'label' => esc_html__( 'Featured Images Links', 'gridbit' ), 'description' => esc_html__('Do you want featured images in posts summaries to be linked to their posts?', 'gridbit'), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[thumbnail_link_home]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'gridbit'), 'no' => esc_html__('No', 'gridbit') ) ) );


    $wp_customize->add_setting( 'gridbit_options[hide_post_title_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_title_home_control', array( 'label' => esc_html__( 'Hide Post Headers from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_post_title_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[post_title_link_home]', array( 'default' => 'yes', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_yes_no' ) );

    $wp_customize->add_control( 'gridbit_post_title_link_home_control', array( 'label' => esc_html__( 'Posts Titles Links', 'gridbit' ), 'description' => esc_html__('Do you want post titles in the posts grid to be linked to their posts?', 'gridbit'), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[post_title_link_home]', 'type' => 'select', 'choices' => array( 'yes' => esc_html__('Yes', 'gridbit'), 'no' => esc_html__('No', 'gridbit') ) ) );


    $wp_customize->add_setting( 'gridbit_options[hide_post_author_image_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_author_image_home_control', array( 'label' => esc_html__( 'Hide Post Author Images from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_post_author_image_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[author_image_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_author_image_link_control', array( 'label' => esc_html__( 'Link Author Image to Author Posts URL', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[author_image_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_author_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_author_home_control', array( 'label' => esc_html__( 'Hide Post Author Names from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_post_author_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_posted_date_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_posted_date_home_control', array( 'label' => esc_html__( 'Hide Posted Dates from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_posted_date_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_comments_link_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_comments_link_home_control', array( 'label' => esc_html__( 'Hide Comment Links from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_comments_link_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[comments_count_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_comments_count_home_control', array( 'label' => esc_html__( 'Display Comments Counts only on Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[comments_count_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_snippet]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_snippet_control', array( 'label' => esc_html__( 'Hide Post Snippets from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_post_snippet]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[read_more_length]', array( 'default' => 17, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_read_more_length' ) );

    $wp_customize->add_control( 'gridbit_read_more_length_control', array( 'label' => esc_html__( 'Auto Post Summary Length', 'gridbit' ), 'description' => esc_html__('Enter the number of words need to display in the post summary. Default is 20 words.', 'gridbit'), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[read_more_length]', 'type' => 'text' ) );


    $wp_customize->add_setting( 'gridbit_options[hide_post_categories_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_categories_home_control', array( 'label' => esc_html__( 'Hide Post Categories from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_post_categories_home]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_post_tags_home]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_post_tags_home_control', array( 'label' => esc_html__( 'Hide Post Tags from Posts Grid', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[hide_post_tags_home]', 'type' => 'checkbox', ) );


    $wp_customize->add_setting( 'gridbit_options[disable_posts_grid]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_disable_posts_grid_control', array( 'label' => esc_html__( 'Activate Non-Grid Posts', 'gridbit' ), 'description' => __( 'Check this option if you want to disable posts grid and display posts in normal way.', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[disable_posts_grid]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[thumbnail_alignment_non_grid]', array( 'default' => 'gridbit-thumbnail-alignwide', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_thumbnail_alignment' ) );

    $wp_customize->add_control( 'gridbit_thumbnail_alignment_non_grid_control', array( 'label' => esc_html__( 'Featured Images Alignment of Non-Grid Posts', 'gridbit' ), 'description' => esc_html__('Select the alignment of featured image in non-grid posts.', 'gridbit'), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[thumbnail_alignment_non_grid]', 'type' => 'select', 'choices' => array( 'gridbit-thumbnail-aligncenter' => esc_html__('Center', 'gridbit'), 'gridbit-thumbnail-alignwide' => esc_html__('Wide', 'gridbit'), 'gridbit-thumbnail-alignfull' => esc_html__('Full', 'gridbit') ) ) );

    $wp_customize->add_setting( 'gridbit_options[featured_nongrid_media_above_post_title]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_featured_nongrid_media_above_post_title_control', array( 'label' => esc_html__( 'Move Featured Image to the Top of Non-Grid Post Title', 'gridbit' ), 'section' => 'gridbit_section_posts_grid', 'settings' => 'gridbit_options[featured_nongrid_media_above_post_title]', 'type' => 'checkbox', ) );

}