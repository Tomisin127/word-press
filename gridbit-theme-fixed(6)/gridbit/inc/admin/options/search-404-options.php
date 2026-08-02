<?php
/**
* 404 options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_search_404_options($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_search_404', array( 'title' => esc_html__( 'Search and 404 Pages Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 340 ) );

    $wp_customize->add_setting( 'gridbit_options[no_search_heading]', array( 'default' => esc_html__( 'Nothing Found', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_html', ) );

    $wp_customize->add_control( 'gridbit_no_search_heading_control', array( 'label' => esc_html__( 'No Search Results Heading', 'gridbit' ), 'description' => esc_html__( 'Enter a heading to display when no search results are found.', 'gridbit' ), 'section' => 'gridbit_section_search_404', 'settings' => 'gridbit_options[no_search_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[no_search_results]', array( 'default' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_html', ) );

    $wp_customize->add_control( 'gridbit_no_search_results_control', array( 'label' => esc_html__( 'No Search Results Message', 'gridbit' ), 'description' => esc_html__( 'Enter a message to display when no search results are found.', 'gridbit' ), 'section' => 'gridbit_section_search_404', 'settings' => 'gridbit_options[no_search_results]', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'gridbit_options[error_404_heading]', array( 'default' => esc_html__( 'Oops! That page can not be found.', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_html', ) );

    $wp_customize->add_control( 'gridbit_error_404_heading_control', array( 'label' => esc_html__( '404 Error Page Heading', 'gridbit' ), 'description' => esc_html__( 'Enter the heading for the 404 error page.', 'gridbit' ), 'section' => 'gridbit_section_search_404', 'settings' => 'gridbit_options[error_404_heading]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[error_404_message]', array( 'default' => esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'gridbit' ), 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_html', ) );

    $wp_customize->add_control( 'gridbit_error_404_message_control', array( 'label' => esc_html__( 'Error 404 Message', 'gridbit' ), 'description' => esc_html__( 'Enter a message to display on the 404 error page.', 'gridbit' ), 'section' => 'gridbit_section_search_404', 'settings' => 'gridbit_options[error_404_message]', 'type' => 'textarea', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_404_search]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_404_search_control', array( 'label' => esc_html__( 'Hide Search Box from 404 Page', 'gridbit' ), 'section' => 'gridbit_section_search_404', 'settings' => 'gridbit_options[hide_404_search]', 'type' => 'checkbox', ) );

}