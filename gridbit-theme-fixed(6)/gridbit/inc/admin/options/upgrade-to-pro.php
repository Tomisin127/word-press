<?php
/**
* Upgrade to pro options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license licennse URI, for example : http://www.gnu.org/licenses/gpl-2.0.html
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_upgrade_to_pro($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_upgrade', array( 'title' => esc_html__( 'Upgrade to Pro Version', 'gridbit' ), 'priority' => 400 ) );
    
    $wp_customize->add_setting( 'gridbit_options[upgrade_text]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );
    
    $wp_customize->add_control( new GridBit_Customize_Static_Text_Control( $wp_customize, 'gridbit_upgrade_text_control', array(
        'label'       => esc_html__( 'GridBit Pro', 'gridbit' ),
        'section'     => 'gridbit_section_upgrade',
        'settings' => 'gridbit_options[upgrade_text]',
        'description' => esc_html__( 'Do you enjoy GridBit? Upgrade to GridBit Pro now and get:', 'gridbit' ).
            '<ul class="gridbit-customizer-pro-features">' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Color Options', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Font Options', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '1/2/3/4/5 Columns Options for Posts Grids', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '10+ Thumbnail Sizes Options for Posts Grids', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Custom Thumbnail Size Options for Posts Grids', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Switch between CSS only Grid and Masonry Grid (JavaScript based)', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Display Ads/Custom Contents between Posts in the Grid', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Switch between Boxed or Full Layout Type', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Width Change Options for Full Website/Main Content', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Custom Page Templates', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( '3 Header Layouts with Width options - (Logo + Primary Menu + Social Buttons) / (Logo + Header Banner) / (Full Width Header)', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Footer with Layout Options (1/2/3/4/5/6 columns)', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Change Website Width/Layout Type/Header Style/Footer Style of any Post/Page', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Capability to Add Different Header Images for Each Post/Page with Unique Link, Title and Description', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Grid Featured Posts Widget (Recent/Categories/Tags/PostIDs based) - with capability to display posts according to Likes/Views/Comments/Dates/... and there are many options', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'List Featured Posts Widget (Recent/Categories/Tags/PostIDs based) - with capability to display posts according to Likes/Views/Comments/Dates/... and there are many options', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Tabbed Widget (Recent/Categories/Tags/PostIDs based) - with capability to display posts according to Likes/Views/Comments/Dates/... and there are many options.', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'About and Social Widget - 60+ Social Buttons', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'News Ticker (Recent/Categories/Tags/PostIDs based) - It can display posts according to Likes/Views/Comments/Dates/... and there are many options.', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Settings Panel to Control Options in Each Post', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Settings Panel to Control Options in Each Page', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Posts Views Counter', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Posts Likes System', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Infinite Scroll and Load More Button', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Post Share Buttons Styles with Options - 25+ Social Networks are Supported', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Related Posts (Categories/Tags/Author/PostIDs based) with Many Options - For both single posts and post summaries', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Sticky Header with enable/disable capability', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Author Bio Box with Social Buttons - 60+ Social Buttons', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Enable/Disable Mobile View from Primary and Secondary Menus', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Post Navigation with Thumbnails', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to add Ads under Post Title and under Post Content', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Ability to Disable Google Fonts - for faster loading', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'More Widget Areas', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Built-in Contact Form', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'WooCommerce Compatible', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Yoast SEO Breadcrumbs Support', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Full RTL Language Support', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Search Engine Optimized', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Random Posts Button in Header', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'Many Useful Customizer Theme options', 'gridbit' ) . '</li>' .
                '<li><i class="fas fa-check" aria-hidden="true"></i> ' . esc_html__( 'More Features...', 'gridbit' ) . '</li>' .
            '</ul>'.
            '<strong><a href="'.GRIDBIT_PROURL.'" class="button button-primary" target="_blank"><i class="fas fa-shopping-cart" aria-hidden="true"></i> ' . esc_html__( 'Upgrade To GridBit PRO', 'gridbit' ) . '</a></strong>'
    ) ) );

}