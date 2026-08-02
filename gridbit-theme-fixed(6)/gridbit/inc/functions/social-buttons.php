<?php
/**
* Social buttons
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

function gridbit_social_buttons() { ?>

<div class='gridbit-header-social-icons'>
    <?php if ( gridbit_get_option('twitterlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('twitterlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-twitter" aria-label="<?php esc_attr_e('X Button','gridbit'); ?>"><i class="fab fa-x-twitter" aria-hidden="true" title="<?php esc_attr_e('X','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('facebooklink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('facebooklink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-facebook" aria-label="<?php esc_attr_e('Facebook Button','gridbit'); ?>"><i class="fab fa-facebook-f" aria-hidden="true" title="<?php esc_attr_e('Facebook','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('threadslink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('threadslink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-threads" aria-label="<?php esc_attr_e('Threads Button','gridbit'); ?>"><i class="fab fa-threads" aria-hidden="true" title="<?php esc_attr_e('Threads','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('pinterestlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('pinterestlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-pinterest" aria-label="<?php esc_attr_e('Pinterest Button','gridbit'); ?>"><i class="fab fa-pinterest" aria-hidden="true" title="<?php esc_attr_e('Pinterest','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('linkedinlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('linkedinlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-linkedin" aria-label="<?php esc_attr_e('Linkedin Button','gridbit'); ?>"><i class="fab fa-linkedin-in" aria-hidden="true" title="<?php esc_attr_e('Linkedin','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('instagramlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('instagramlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-instagram" aria-label="<?php esc_attr_e('Instagram Button','gridbit'); ?>"><i class="fab fa-instagram" aria-hidden="true" title="<?php esc_attr_e('Instagram','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('flickrlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('flickrlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-flickr" aria-label="<?php esc_attr_e('Flickr Button','gridbit'); ?>"><i class="fab fa-flickr" aria-hidden="true" title="<?php esc_attr_e('Flickr','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('youtubelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('youtubelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-youtube" aria-label="<?php esc_attr_e('Youtube Button','gridbit'); ?>"><i class="fab fa-youtube" aria-hidden="true" title="<?php esc_attr_e('Youtube','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('vimeolink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('vimeolink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-vimeo" aria-label="<?php esc_attr_e('Vimeo Button','gridbit'); ?>"><i class="fab fa-vimeo-v" aria-hidden="true" title="<?php esc_attr_e('Vimeo','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('soundcloudlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('soundcloudlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-soundcloud" aria-label="<?php esc_attr_e('SoundCloud Button','gridbit'); ?>"><i class="fab fa-soundcloud" aria-hidden="true" title="<?php esc_attr_e('SoundCloud','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('messengerlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('messengerlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-messenger" aria-label="<?php esc_attr_e('Messenger Button','gridbit'); ?>"><i class="fab fa-facebook-messenger" aria-hidden="true" title="<?php esc_attr_e('Messenger','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('whatsapplink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('whatsapplink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-whatsapp" aria-label="<?php esc_attr_e('WhatsApp Button','gridbit'); ?>"><i class="fab fa-whatsapp" aria-hidden="true" title="<?php esc_attr_e('WhatsApp','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('tiktoklink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('tiktoklink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-tiktok" aria-label="<?php esc_attr_e('TikTok Button','gridbit'); ?>"><i class="fab fa-tiktok" aria-hidden="true" title="<?php esc_attr_e('TikTok','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('lastfmlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('lastfmlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-lastfm" aria-label="<?php esc_attr_e('Lastfm Button','gridbit'); ?>"><i class="fab fa-lastfm" aria-hidden="true" title="<?php esc_attr_e('Lastfm','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('mediumlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('mediumlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-medium" aria-label="<?php esc_attr_e('Medium Button','gridbit'); ?>"><i class="fab fa-medium-m" aria-hidden="true" title="<?php esc_attr_e('Medium','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('githublink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('githublink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-github" aria-label="<?php esc_attr_e('Github Button','gridbit'); ?>"><i class="fab fa-github" aria-hidden="true" title="<?php esc_attr_e('Github','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('bitbucketlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('bitbucketlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-bitbucket" aria-label="<?php esc_attr_e('Bitbucket Button','gridbit'); ?>"><i class="fab fa-bitbucket" aria-hidden="true" title="<?php esc_attr_e('Bitbucket','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('tumblrlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('tumblrlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-tumblr" aria-label="<?php esc_attr_e('Tumblr Button','gridbit'); ?>"><i class="fab fa-tumblr" aria-hidden="true" title="<?php esc_attr_e('Tumblr','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('digglink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('digglink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-digg" aria-label="<?php esc_attr_e('Digg Button','gridbit'); ?>"><i class="fab fa-digg" aria-hidden="true" title="<?php esc_attr_e('Digg','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('deliciouslink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('deliciouslink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-delicious" aria-label="<?php esc_attr_e('Delicious Button','gridbit'); ?>"><i class="fab fa-delicious" aria-hidden="true" title="<?php esc_attr_e('Delicious','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('stumblelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('stumblelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-stumbleupon" aria-label="<?php esc_attr_e('Stumbleupon Button','gridbit'); ?>"><i class="fab fa-stumbleupon" aria-hidden="true" title="<?php esc_attr_e('Stumbleupon','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('mixlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('mixlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-mix" aria-label="<?php esc_attr_e('Mix Button','gridbit'); ?>"><i class="fab fa-mix" aria-hidden="true" title="<?php esc_attr_e('Mix','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('redditlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('redditlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-reddit" aria-label="<?php esc_attr_e('Reddit Button','gridbit'); ?>"><i class="fab fa-reddit" aria-hidden="true" title="<?php esc_attr_e('Reddit','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('dribbblelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('dribbblelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-dribbble" aria-label="<?php esc_attr_e('Dribbble Button','gridbit'); ?>"><i class="fab fa-dribbble" aria-hidden="true" title="<?php esc_attr_e('Dribbble','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('flipboardlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('flipboardlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-flipboard" aria-label="<?php esc_attr_e('Flipboard Button','gridbit'); ?>"><i class="fab fa-flipboard" aria-hidden="true" title="<?php esc_attr_e('Flipboard','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('bloggerlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('bloggerlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-blogger" aria-label="<?php esc_attr_e('Blogger Button','gridbit'); ?>"><i class="fab fa-blogger" aria-hidden="true" title="<?php esc_attr_e('Blogger','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('etsylink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('etsylink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-etsy" aria-label="<?php esc_attr_e('Etsy Button','gridbit'); ?>"><i class="fab fa-etsy" aria-hidden="true" title="<?php esc_attr_e('Etsy','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('behancelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('behancelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-behance" aria-label="<?php esc_attr_e('Behance Button','gridbit'); ?>"><i class="fab fa-behance" aria-hidden="true" title="<?php esc_attr_e('Behance','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('amazonlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('amazonlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-amazon" aria-label="<?php esc_attr_e('Amazon Button','gridbit'); ?>"><i class="fab fa-amazon" aria-hidden="true" title="<?php esc_attr_e('Amazon','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('meetuplink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('meetuplink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-meetup" aria-label="<?php esc_attr_e('Meetup Button','gridbit'); ?>"><i class="fab fa-meetup" aria-hidden="true" title="<?php esc_attr_e('Meetup','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('mixcloudlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('mixcloudlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-mixcloud" aria-label="<?php esc_attr_e('Mixcloud Button','gridbit'); ?>"><i class="fab fa-mixcloud" aria-hidden="true" title="<?php esc_attr_e('Mixcloud','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('slacklink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('slacklink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-slack" aria-label="<?php esc_attr_e('Slack Button','gridbit'); ?>"><i class="fab fa-slack" aria-hidden="true" title="<?php esc_attr_e('Slack','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('snapchatlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('snapchatlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-snapchat" aria-label="<?php esc_attr_e('Snapchat Button','gridbit'); ?>"><i class="fab fa-snapchat" aria-hidden="true" title="<?php esc_attr_e('Snapchat','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('spotifylink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('spotifylink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-spotify" aria-label="<?php esc_attr_e('Spotify Button','gridbit'); ?>"><i class="fab fa-spotify" aria-hidden="true" title="<?php esc_attr_e('Spotify','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('yelplink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('yelplink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-yelp" aria-label="<?php esc_attr_e('Yelp Button','gridbit'); ?>"><i class="fab fa-yelp" aria-hidden="true" title="<?php esc_attr_e('Yelp','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('wordpresslink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('wordpresslink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-wordpress" aria-label="<?php esc_attr_e('WordPress Button','gridbit'); ?>"><i class="fab fa-wordpress" aria-hidden="true" title="<?php esc_attr_e('WordPress','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('twitchlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('twitchlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-twitch" aria-label="<?php esc_attr_e('Twitch Button','gridbit'); ?>"><i class="fab fa-twitch" aria-hidden="true" title="<?php esc_attr_e('Twitch','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('telegramlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('telegramlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-telegram" aria-label="<?php esc_attr_e('Telegram Button','gridbit'); ?>"><i class="fab fa-telegram" aria-hidden="true" title="<?php esc_attr_e('Telegram','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('bandcamplink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('bandcamplink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-bandcamp" aria-label="<?php esc_attr_e('Bandcamp Button','gridbit'); ?>"><i class="fab fa-bandcamp" aria-hidden="true" title="<?php esc_attr_e('Bandcamp','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('quoralink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('quoralink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-quora" aria-label="<?php esc_attr_e('Quora Button','gridbit'); ?>"><i class="fab fa-quora" aria-hidden="true" title="<?php esc_attr_e('Quora','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('foursquarelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('foursquarelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-foursquare" aria-label="<?php esc_attr_e('Foursquare Button','gridbit'); ?>"><i class="fab fa-foursquare" aria-hidden="true" title="<?php esc_attr_e('Foursquare','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('deviantartlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('deviantartlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-deviantart" aria-label="<?php esc_attr_e('DeviantArt Button','gridbit'); ?>"><i class="fab fa-deviantart" aria-hidden="true" title="<?php esc_attr_e('DeviantArt','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('imdblink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('imdblink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-imdb" aria-label="<?php esc_attr_e('IMDB Button','gridbit'); ?>"><i class="fab fa-imdb" aria-hidden="true" title="<?php esc_attr_e('IMDB','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('vklink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('vklink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-vk" aria-label="<?php esc_attr_e('VK Button','gridbit'); ?>"><i class="fab fa-vk" aria-hidden="true" title="<?php esc_attr_e('VK','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('codepenlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('codepenlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-codepen" aria-label="<?php esc_attr_e('Codepen Button','gridbit'); ?>"><i class="fab fa-codepen" aria-hidden="true" title="<?php esc_attr_e('Codepen','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('jsfiddlelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('jsfiddlelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-jsfiddle" aria-label="<?php esc_attr_e('JSFiddle Button','gridbit'); ?>"><i class="fab fa-jsfiddle" aria-hidden="true" title="<?php esc_attr_e('JSFiddle','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('stackoverflowlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('stackoverflowlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-stackoverflow" aria-label="<?php esc_attr_e('Stack Overflow Button','gridbit'); ?>"><i class="fab fa-stack-overflow" aria-hidden="true" title="<?php esc_attr_e('Stack Overflow','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('stackexchangelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('stackexchangelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-stackexchange" aria-label="<?php esc_attr_e('Stack Exchange Button','gridbit'); ?>"><i class="fab fa-stack-exchange" aria-hidden="true" title="<?php esc_attr_e('Stack Exchange','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('bsalink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('bsalink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-buysellads" aria-label="<?php esc_attr_e('BuySellAds Button','gridbit'); ?>"><i class="fab fa-buysellads" aria-hidden="true" title="<?php esc_attr_e('BuySellAds','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('web500pxlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('web500pxlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-web500px" aria-label="<?php esc_attr_e('500px Button','gridbit'); ?>"><i class="fab fa-500px" aria-hidden="true" title="<?php esc_attr_e('500px','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('ellolink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('ellolink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-ello" aria-label="<?php esc_attr_e('Ello Button','gridbit'); ?>"><i class="fab fa-ello" aria-hidden="true" title="<?php esc_attr_e('Ello','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('discordlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('discordlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-discord" aria-label="<?php esc_attr_e('Discord Button','gridbit'); ?>"><i class="fab fa-discord" aria-hidden="true" title="<?php esc_attr_e('Discord','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('goodreadslink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('goodreadslink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-goodreads" aria-label="<?php esc_attr_e('Goodreads Button','gridbit'); ?>"><i class="fab fa-goodreads" aria-hidden="true" title="<?php esc_attr_e('Goodreads','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('odnoklassnikilink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('odnoklassnikilink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-odnoklassniki" aria-label="<?php esc_attr_e('Odnoklassniki Button','gridbit'); ?>"><i class="fab fa-odnoklassniki" aria-hidden="true" title="<?php esc_attr_e('Odnoklassniki','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('houzzlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('houzzlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-houzz" aria-label="<?php esc_attr_e('Houzz Button','gridbit'); ?>"><i class="fab fa-houzz" aria-hidden="true" title="<?php esc_attr_e('Houzz','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('pocketlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('pocketlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-pocket" aria-label="<?php esc_attr_e('Pocket Button','gridbit'); ?>"><i class="fab fa-get-pocket" aria-hidden="true" title="<?php esc_attr_e('Pocket','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('xinglink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('xinglink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-xing" aria-label="<?php esc_attr_e('XING Button','gridbit'); ?>"><i class="fab fa-xing" aria-hidden="true" title="<?php esc_attr_e('XING','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('mastodonlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('mastodonlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-mastodon" aria-label="<?php esc_attr_e('Mastodon Button','gridbit'); ?>"><i class="fab fa-mastodon" aria-hidden="true" title="<?php esc_attr_e('Mastodon','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('googleplaylink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('googleplaylink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-googleplay" aria-label="<?php esc_attr_e('Google Play Button','gridbit'); ?>"><i class="fab fa-google-play" aria-hidden="true" title="<?php esc_attr_e('Google Play','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('slidesharelink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('slidesharelink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-slideshare" aria-label="<?php esc_attr_e('SlideShare Button','gridbit'); ?>"><i class="fab fa-slideshare" aria-hidden="true" title="<?php esc_attr_e('SlideShare','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('dropboxlink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('dropboxlink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-dropbox" aria-label="<?php esc_attr_e('Dropbox Button','gridbit'); ?>"><i class="fab fa-dropbox" aria-hidden="true" title="<?php esc_attr_e('Dropbox','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('paypallink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('paypallink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-paypal" aria-label="<?php esc_attr_e('PayPal Button','gridbit'); ?>"><i class="fab fa-paypal" aria-hidden="true" title="<?php esc_attr_e('PayPal','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('viadeolink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('viadeolink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-viadeo" aria-label="<?php esc_attr_e('Viadeo Button','gridbit'); ?>"><i class="fab fa-viadeo" aria-hidden="true" title="<?php esc_attr_e('Viadeo','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('wikipedialink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('wikipedialink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-wikipedia" aria-label="<?php esc_attr_e('Wikipedia Button','gridbit'); ?>"><i class="fab fa-wikipedia-w" aria-hidden="true" title="<?php esc_attr_e('Wikipedia','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('skypeusername') ) : ?>
            <a href="skype:<?php echo esc_html( gridbit_get_option('skypeusername') ); ?>?chat" class="gridbit-header-social-icon-skype" aria-label="<?php esc_attr_e('Skype Button','gridbit'); ?>"><i class="fab fa-skype" aria-hidden="true" title="<?php esc_attr_e('Skype','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('emailaddress') ) : ?>
            <a href="mailto:<?php echo esc_html( gridbit_get_option('emailaddress') ); ?>" class="gridbit-header-social-icon-email" aria-label="<?php esc_attr_e('Email Us Button','gridbit'); ?>"><i class="far fa-envelope" aria-hidden="true" title="<?php esc_attr_e('Email Us','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('rsslink') ) : ?>
            <a href="<?php echo esc_url( gridbit_get_option('rsslink') ); ?>" target="_blank" rel="nofollow" class="gridbit-header-social-icon-rss" aria-label="<?php esc_attr_e('RSS Button','gridbit'); ?>"><i class="fas fa-rss" aria-hidden="true" title="<?php esc_attr_e('RSS','gridbit'); ?>"></i></a><?php endif; ?>
    <?php if ( gridbit_get_option('show_login_button') ) { ?><?php if (is_user_logged_in()) : ?><a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Logout Button', 'gridbit' ); ?>" class="gridbit-header-social-icon-login"><i class="fas fa-sign-out-alt" aria-hidden="true" title="<?php esc_attr_e('Logout','gridbit'); ?>"></i></a><?php else : ?><a href="<?php echo esc_url( class_exists( 'URS_Helpers' ) ? URS_Helpers::login_url( get_permalink() ) : wp_login_url( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Login / Register Button', 'gridbit' ); ?>" class="gridbit-header-social-icon-login"><i class="fas fa-sign-in-alt" aria-hidden="true" title="<?php esc_attr_e('Login / Register','gridbit'); ?>"></i></a><?php endif;?><?php } ?>
    <?php if ( !(gridbit_get_option('hide_search_button')) ) { ?><a href="<?php echo esc_url( '#' ); ?>" class="gridbit-header-social-icon-search" aria-label="<?php esc_attr_e('Search Button','gridbit'); ?>"><i class="fas fa-search" aria-hidden="true" title="<?php esc_attr_e('Search','gridbit'); ?>"></i></a><?php } ?>
</div>

<?php }