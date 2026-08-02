<?php
/**
* Social profiles options
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_social_profiles($wp_customize) {

    $wp_customize->add_section( 'gridbit_section_social', array( 'title' => esc_html__( 'Social Links Options', 'gridbit' ), 'panel' => 'gridbit_main_options_panel', 'priority' => 240, ));

    $wp_customize->add_setting( 'gridbit_options[hide_header_social_buttons]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_header_social_buttons_control', array( 'label' => esc_html__( 'Hide Social Area', 'gridbit' ), 'description' => esc_html__('If you checked this option, all buttons will disappear. There is no any effect from these options: "Hide Search Button", "Show Login/Logout Button".', 'gridbit'), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[hide_header_social_buttons]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[hide_search_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_hide_search_button_control', array( 'label' => esc_html__( 'Hide Search Button', 'gridbit' ), 'description' => esc_html__('This option has no effect if you have checked the option: "Hide Social Area".', 'gridbit'), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[hide_search_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[show_login_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_checkbox', ) );

    $wp_customize->add_control( 'gridbit_show_login_button_control', array( 'label' => esc_html__( 'Show Login/Logout Button', 'gridbit' ), 'description' => esc_html__('This option has no effect if you have checked the option: "Hide Social Area".', 'gridbit'), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[show_login_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'gridbit_options[twitterlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_twitterlink_control', array( 'label' => esc_html__( 'X URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[twitterlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[facebooklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_facebooklink_control', array( 'label' => esc_html__( 'Facebook URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[facebooklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[threadslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_threadslink_control', array( 'label' => esc_html__( 'Threads URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[threadslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[pinterestlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_pinterestlink_control', array( 'label' => esc_html__( 'Pinterest URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[pinterestlink]', 'type' => 'text' ) );
    
    $wp_customize->add_setting( 'gridbit_options[linkedinlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_linkedinlink_control', array( 'label' => esc_html__( 'Linkedin Link', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[linkedinlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[instagramlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_instagramlink_control', array( 'label' => esc_html__( 'Instagram Link', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[instagramlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[vklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_vklink_control', array( 'label' => esc_html__( 'VK Link', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[vklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[flickrlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_flickrlink_control', array( 'label' => esc_html__( 'Flickr Link', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[flickrlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[youtubelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_youtubelink_control', array( 'label' => esc_html__( 'Youtube URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[youtubelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[vimeolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_vimeolink_control', array( 'label' => esc_html__( 'Vimeo URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[vimeolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[soundcloudlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_soundcloudlink_control', array( 'label' => esc_html__( 'Soundcloud URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[soundcloudlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[messengerlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_messengerlink_control', array( 'label' => esc_html__( 'Messenger URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[messengerlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[whatsapplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_whatsapplink_control', array( 'label' => esc_html__( 'WhatsApp URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[whatsapplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[tiktoklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_tiktoklink_control', array( 'label' => esc_html__( 'TikTok URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[tiktoklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[lastfmlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_lastfmlink_control', array( 'label' => esc_html__( 'Lastfm URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[lastfmlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[mediumlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_mediumlink_control', array( 'label' => esc_html__( 'Medium URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[mediumlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[githublink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_githublink_control', array( 'label' => esc_html__( 'Github URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[githublink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[bitbucketlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_bitbucketlink_control', array( 'label' => esc_html__( 'Bitbucket URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[bitbucketlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[tumblrlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_tumblrlink_control', array( 'label' => esc_html__( 'Tumblr URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[tumblrlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[digglink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_digglink_control', array( 'label' => esc_html__( 'Digg URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[digglink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[deliciouslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_deliciouslink_control', array( 'label' => esc_html__( 'Delicious URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[deliciouslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[stumblelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_stumblelink_control', array( 'label' => esc_html__( 'Stumbleupon URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[stumblelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[mixlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_mixlink_control', array( 'label' => esc_html__( 'Mix URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[mixlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[redditlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_redditlink_control', array( 'label' => esc_html__( 'Reddit URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[redditlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[dribbblelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_dribbblelink_control', array( 'label' => esc_html__( 'Dribbble URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[dribbblelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[flipboardlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_flipboardlink_control', array( 'label' => esc_html__( 'Flipboard URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[flipboardlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[bloggerlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_bloggerlink_control', array( 'label' => esc_html__( 'Blogger URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[bloggerlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[etsylink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_etsylink_control', array( 'label' => esc_html__( 'Etsy URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[etsylink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[behancelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_behancelink_control', array( 'label' => esc_html__( 'Behance URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[behancelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[amazonlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_amazonlink_control', array( 'label' => esc_html__( 'Amazon URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[amazonlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[meetuplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_meetuplink_control', array( 'label' => esc_html__( 'Meetup URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[meetuplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[mixcloudlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_mixcloudlink_control', array( 'label' => esc_html__( 'Mixcloud URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[mixcloudlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[slacklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_slacklink_control', array( 'label' => esc_html__( 'Slack URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[slacklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[snapchatlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_snapchatlink_control', array( 'label' => esc_html__( 'Snapchat URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[snapchatlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[spotifylink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_spotifylink_control', array( 'label' => esc_html__( 'Spotify URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[spotifylink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[yelplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_yelplink_control', array( 'label' => esc_html__( 'Yelp URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[yelplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[wordpresslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_wordpresslink_control', array( 'label' => esc_html__( 'WordPress URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[wordpresslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[twitchlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_twitchlink_control', array( 'label' => esc_html__( 'Twitch URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[twitchlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[telegramlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_telegramlink_control', array( 'label' => esc_html__( 'Telegram URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[telegramlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[bandcamplink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_bandcamplink_control', array( 'label' => esc_html__( 'Bandcamp URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[bandcamplink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[quoralink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_quoralink_control', array( 'label' => esc_html__( 'Quora URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[quoralink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[foursquarelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_foursquarelink_control', array( 'label' => esc_html__( 'Foursquare URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[foursquarelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[deviantartlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_deviantartlink_control', array( 'label' => esc_html__( 'DeviantArt URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[deviantartlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[imdblink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_imdblink_control', array( 'label' => esc_html__( 'IMDB URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[imdblink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[codepenlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_codepenlink_control', array( 'label' => esc_html__( 'Codepen URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[codepenlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[jsfiddlelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_jsfiddlelink_control', array( 'label' => esc_html__( 'JSFiddle URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[jsfiddlelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[stackoverflowlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_stackoverflowlink_control', array( 'label' => esc_html__( 'Stack Overflow URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[stackoverflowlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[stackexchangelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_stackexchangelink_control', array( 'label' => esc_html__( 'Stack Exchange URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[stackexchangelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[bsalink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_bsalink_control', array( 'label' => esc_html__( 'BuySellAds URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[bsalink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[web500pxlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_web500pxlink_control', array( 'label' => esc_html__( '500px URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[web500pxlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[ellolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_ellolink_control', array( 'label' => esc_html__( 'Ello URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[ellolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[discordlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_discordlink_control', array( 'label' => esc_html__( 'Discord URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[discordlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[goodreadslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_goodreadslink_control', array( 'label' => esc_html__( 'Goodreads URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[goodreadslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[odnoklassnikilink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_odnoklassnikilink_control', array( 'label' => esc_html__( 'Odnoklassniki URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[odnoklassnikilink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[houzzlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_houzzlink_control', array( 'label' => esc_html__( 'Houzz URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[houzzlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[pocketlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_pocketlink_control', array( 'label' => esc_html__( 'Pocket URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[pocketlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[xinglink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_xinglink_control', array( 'label' => esc_html__( 'XING URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[xinglink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[mastodonlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_mastodonlink_control', array( 'label' => esc_html__( 'Mastodon URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[mastodonlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[googleplaylink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_googleplaylink_control', array( 'label' => esc_html__( 'Google Play URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[googleplaylink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[slidesharelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_slidesharelink_control', array( 'label' => esc_html__( 'SlideShare URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[slidesharelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[dropboxlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_dropboxlink_control', array( 'label' => esc_html__( 'Dropbox URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[dropboxlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[paypallink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_paypallink_control', array( 'label' => esc_html__( 'PayPal URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[paypallink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[viadeolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_viadeolink_control', array( 'label' => esc_html__( 'Viadeo URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[viadeolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[wikipedialink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_wikipedialink_control', array( 'label' => esc_html__( 'Wikipedia URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[wikipedialink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[skypeusername]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field' ) );

    $wp_customize->add_control( 'gridbit_skypeusername_control', array( 'label' => esc_html__( 'Skype Username', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[skypeusername]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[emailaddress]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'gridbit_sanitize_email' ) );

    $wp_customize->add_control( 'gridbit_emailaddress_control', array( 'label' => esc_html__( 'Email Address', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[emailaddress]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'gridbit_options[rsslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'gridbit_rsslink_control', array( 'label' => esc_html__( 'RSS Feed URL', 'gridbit' ), 'section' => 'gridbit_section_social', 'settings' => 'gridbit_options[rsslink]', 'type' => 'text' ) );

}