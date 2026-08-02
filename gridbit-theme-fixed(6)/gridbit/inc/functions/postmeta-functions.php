<?php
/**
* Post meta functions
*
* @package GridBit WordPress Theme
* @copyright Copyright (C) 2025 ThemesDNA
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
* @author ThemesDNA <themesdna@gmail.com>
*/

if ( ! function_exists( 'gridbit_post_tags' ) ) :
/**
 * Prints HTML with meta information for the tags.
 */
function gridbit_post_tags() {
    if ( 'post' == get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gridbit' ) );
        if ( $tags_list ) {
            /* translators: 1: list of tags. */
            printf( '<span class="gridbit-tags-links"><i class="fas fa-tags" aria-hidden="true"></i> ' . esc_html__( 'Tagged %1$s', 'gridbit' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
endif;


function gridbit_author_image_size() {
    global $post;
    // Requested at a higher resolution than it displays (56px in CSS) so it
    // stays crisp on retina/high-DPI screens, matching the WhatsApp-style
    // avatar size used elsewhere in the redesign.
    $gravatar_size = 112;
    return apply_filters( 'gridbit_author_image_size', $gravatar_size );
}


/**
 * Whether a post (or, if no post is passed, the current global $post) was
 * published within the last hour. Used to show a temporary "new post"
 * indicator ring + dot around the author avatar.
 *
 * Compares GMT timestamps directly (post_date_gmt vs time()) rather than
 * get_the_time()/current_time(), which mix local-time-interpreted and
 * offset-adjusted values and can be off by the site's UTC offset - on a
 * site set to a non-UTC timezone that bug alone can push a brand new
 * post outside the "last hour" window (or the reverse). Comparing GMT
 * to GMT avoids that entirely.
 */
if ( ! function_exists( 'gridbit_is_recent_post' ) ) :
function gridbit_is_recent_post( $post_id = null ) {
    $post = $post_id ? get_post( $post_id ) : get_post();
    if ( ! $post || empty( $post->post_date_gmt ) || '0000-00-00 00:00:00' === $post->post_date_gmt ) {
        return false;
    }
    $published_gmt_timestamp = strtotime( $post->post_date_gmt . ' +0000' );
    if ( ! $published_gmt_timestamp ) {
        return false;
    }
    return ( ( time() - $published_gmt_timestamp ) < HOUR_IN_SECONDS );
}
endif;


if ( ! function_exists( 'gridbit_author_image' ) ) :
function gridbit_author_image( $size = '' ) {
    global $post;
    if ( $size ) {
        $gravatar_size = $size;
    } else {
        $gravatar_size = gridbit_author_image_size();
    }
    $author_email   = get_the_author_meta( 'user_email' );
    $gravatar_args  = apply_filters(
        'gridbit_gravatar_args',
        array(
            'size' => $gravatar_size,
        )
    );

    $avatar_url = '';
    if( get_the_author_meta('themesdna_userprofile_image',get_query_var('author') ) ) {
        $avatar_url = get_the_author_meta( 'themesdna_userprofile_image' );
    } else {
        $avatar_url = get_avatar_url( $author_email, $gravatar_args );
    }

    //$avatar_url     = get_avatar_url( $author_email, $gravatar_args );
    if ( gridbit_get_option('author_image_link') ) {
        $avatar_markup  = '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.esc_attr( get_the_author() ).'"><img class="gridbit-grid-post-author-image" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" /></a>';
    } else {
        $avatar_markup  = '<img class="gridbit-grid-post-author-image" alt="' . esc_attr( get_the_author() ) . '" src="' . esc_url( $avatar_url ) . '" />';
    }

    // "New post" indicator: a light-blue ring + gold dot around the avatar,
    // shown only while the post is less than an hour old, then it simply
    // no longer applies on the next page load once that hour has passed.
    $wrapper_class = 'gridbit-avatar-wrap';
    $dot_markup    = '';
    if ( gridbit_is_recent_post() ) {
        $wrapper_class .= ' gridbit-avatar-new';
        $dot_markup      = '<span class="gridbit-new-post-dot" aria-hidden="true"></span>';
    }
    $avatar_markup = '<span class="' . esc_attr( $wrapper_class ) . '">' . $avatar_markup . $dot_markup . '</span>';

    return apply_filters( 'gridbit_author_image', $avatar_markup );
}
endif;


if ( ! function_exists( 'gridbit_is_recent_comment' ) ) :
function gridbit_is_recent_comment( $comment ) {
    $comment = get_comment( $comment );
    if ( ! $comment || empty( $comment->comment_date_gmt ) || '0000-00-00 00:00:00' === $comment->comment_date_gmt ) {
        return false;
    }
    $published_gmt_timestamp = strtotime( $comment->comment_date_gmt . ' +0000' );
    if ( ! $published_gmt_timestamp ) {
        return false;
    }
    return ( ( time() - $published_gmt_timestamp ) < HOUR_IN_SECONDS );
}
endif;


if ( ! function_exists( 'gridbit_comment_template' ) ) :
/**
 * Custom comment callback (used by wp_list_comments() in comments.php) so
 * we can wrap the comment avatar with the same "new comment" ring + gold
 * dot indicator used on post author avatars, shown only for comments left
 * in the last hour.
 */
function gridbit_comment_template( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                    if ( 0 != $args['avatar_size'] ) {
                        $is_new = gridbit_is_recent_comment( $comment );
                        echo '<span class="gridbit-avatar-wrap' . ( $is_new ? ' gridbit-avatar-new' : '' ) . '">';
                        echo get_avatar( $comment, $args['avatar_size'] );
                        if ( $is_new ) {
                            echo '<span class="gridbit-new-post-dot" aria-hidden="true"></span>';
                        }
                        echo '</span>';
                    }
                    printf( '<b class="fn">%s</b>', get_comment_author_link() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    ?>
                </div><!-- .comment-author -->

                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                            printf(
                                /* translators: 1: comment date, 2: comment time */
                                esc_html__( '%1$s at %2$s', 'gridbit' ),
                                get_comment_date( '', $comment ),
                                get_comment_time()
                            );
                            ?>
                        </time>
                    </a>
                    <?php edit_comment_link( esc_html__( 'Edit', 'gridbit' ), '<span class="edit-link">', '</span>' ); ?>
                </div><!-- .comment-metadata -->

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'gridbit' ); ?></em>
                <?php endif; ?>
            </footer><!-- .comment-meta -->

            <div class="comment-content">
                <?php comment_text(); ?>
            </div><!-- .comment-content -->

            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => $args['add_below'] . '-' . $comment->comment_ID,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>',
                    )
                )
            );
            ?>
        </article><!-- .comment-body -->
    <?php
}
endif;


if ( ! function_exists( 'gridbit_is_auth_wizard_post' ) ) :
/**
 * Detects the "Signup" post/page created by the user-reputation-system
 * plugin's registration wizard, so we can hide author/date meta on it
 * even in contexts where is_front_page() doesn't apply (e.g. if it's
 * ever linked to directly, rather than only serving as the front page).
 */
function gridbit_is_auth_wizard_post() {
    $post = get_post();
    if ( ! $post ) {
        return false;
    }
    if ( 'signup' === $post->post_name ) {
        return true;
    }
    if ( 0 === strcasecmp( trim( $post->post_title ), 'signup' ) ) {
        return true;
    }
    return false;
}
endif;


if ( ! function_exists( 'gridbit_grid_header_meta' ) ) :
function gridbit_grid_header_meta() {
    // Never show post author/avatar/date meta when the current item IS
    // the site's front page. This can happen when a non-blog page/post
    // (e.g. a signup wizard created by a third-party plugin) ends up
    // being what "Your homepage displays" points to in Settings > Reading.
    if ( is_front_page() || gridbit_is_auth_wizard_post() ) {
        return;
    }
    ?>
    <?php global $post; ?>
    <?php if ( !(gridbit_get_option('hide_post_author_home')) || !(gridbit_get_option('hide_post_author_image_home')) || !(gridbit_get_option('hide_posted_date_home')) || (!(gridbit_get_option('hide_comments_link_home')) && (! post_password_required() && ( comments_open() || get_comments_number() ))) ) { ?>
    <div class="gridbit-grid-thumbnail-meta gridbit-grid-post-block">
    <div class="gridbit-grid-thumbnail-meta-inside gridbit-clearfix">

    <?php if ( !(gridbit_get_option('hide_post_author_image_home')) ) { ?><?php echo wp_kses_post( gridbit_author_image() ); ?><?php } ?>

    <?php if ( !(gridbit_get_option('hide_post_author_home')) ) { ?><span class="gridbit-grid-post-author gridbit-grid-post-meta"><i class="far fa-user" aria-hidden="true"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span><?php } ?>

    <?php if ( !(gridbit_get_option('hide_posted_date_home')) || (!(gridbit_get_option('hide_comments_link_home')) && (! post_password_required() && ( comments_open() || get_comments_number() ))) ) { ?>
    <span class="gridbit-grid-post-meta">

    <?php if ( !(gridbit_get_option('hide_posted_date_home')) ) { ?><span class="gridbit-grid-post-date"><i class="far fa-clock" aria-hidden="true"></i><?php echo esc_html(get_the_date()); ?></span><?php } ?>

    <?php if ( gridbit_get_option('comments_count_home') ) { ?>
    <?php if ( !(gridbit_get_option('hide_comments_link_home')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridbit-grid-post-comments gridbit-grid-post-meta-inline"><i class="far fa-comments" aria-hidden="true"></i><?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( '0<span class="gridbit-sr-only"> Comment on %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ), sprintf( wp_kses( /* translators: %s: post title */ __( '1<span class="gridbit-sr-only"> Comment on %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ), sprintf( wp_kses( /* translators: %s: post title */ __( '%1$s<span class="gridbit-sr-only"> Comments on %2$s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), number_format_i18n( get_comments_number() ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    <?php } else { ?>
    <?php if ( !(gridbit_get_option('hide_comments_link_home')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridbit-grid-post-comments gridbit-grid-post-meta-inline"><i class="far fa-comments" aria-hidden="true"></i><?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( '0 Comment<span class="gridbit-sr-only"> on %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    <?php } ?>

    </span>
    <?php } ?>

    </div>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridbit_grid_footer_meta' ) ) :
 /**
  * Prints HTML with meta information for the categories, tags and comments.
  */
function gridbit_grid_footer_meta() {
    global $post; ?>
    <?php if ( (!(gridbit_get_option('hide_post_categories_home')) && has_category()) || (!(gridbit_get_option('hide_post_tags_home')) && has_tag()) ) { ?>
    <div class="gridbit-grid-post-details-meta gridbit-grid-post-block">
    <div class="gridbit-grid-post-details-meta-inside">
    <?php
    if ( !(gridbit_get_option('hide_post_categories_home')) && has_category() ) {
        if ( 'post' == get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'gridbit' ) );
            if ( $categories_list ) { ?>
                <div class="gridbit-summary-post-cat-links gridbit-grid-post-details-meta-item"><i class="far fa-folder-open" aria-hidden="true"></i><?php echo wp_kses_post( $categories_list ); ?></div>
            <?php }
        }
    }

    if ( !(gridbit_get_option('hide_post_tags_home')) && has_tag() ) {
        if ( 'post' == get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gridbit' ) );
            if ( $tags_list ) { ?>
                <div class="gridbit-summary-post-tags-links gridbit-grid-post-details-meta-item"><i class="fas fa-tags" aria-hidden="true"></i><?php echo wp_kses_post( $tags_list ); ?></div>
            <?php }
        }
    }
    ?>
    </div>
    </div>
    <?php } ?>
    <?php
}
endif;


if ( ! function_exists( 'gridbit_nongrid_postmeta' ) ) :
function gridbit_nongrid_postmeta() {
    // See gridbit_grid_header_meta() above - same front-page guard.
    if ( is_front_page() || gridbit_is_auth_wizard_post() ) {
        return;
    }
    ?>
    <?php global $post; ?>
    <?php if ( !(gridbit_get_option('hide_post_author_home')) || !(gridbit_get_option('hide_posted_date_home')) || (!(gridbit_get_option('hide_comments_link_home')) && (! post_password_required() && ( comments_open() || get_comments_number() ))) || !(gridbit_get_option('hide_post_categories_home')) ) { ?>
    <div class="gridbit-entry-meta-single">
    <?php if ( !(gridbit_get_option('hide_post_author_home')) ) { ?><span class="gridbit-entry-meta-single-author"><i class="far fa-user-circle" aria-hidden="true"></i>&nbsp;<span class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span><?php } ?>
    <?php if ( !(gridbit_get_option('hide_posted_date_home')) ) { ?><span class="gridbit-entry-meta-single-date"><i class="far fa-clock" aria-hidden="true"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    <?php if ( !(gridbit_get_option('hide_comments_link_home')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridbit-entry-meta-single-comments"><i class="far fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( 'Leave a Comment<span class="gridbit-sr-only"> on %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    <?php if ( !(gridbit_get_option('hide_post_categories_home')) ) { ?><?php gridbit_single_cats(); ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridbit_single_cats' ) ) :
function gridbit_single_cats() {
    if ( 'post' == get_post_type() ) {
        /* translators: used between list items, there is a space */
        $categories_list = get_the_category_list( esc_html__( ', ', 'gridbit' ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<span class="gridbit-entry-meta-single-cats"><i class="far fa-folder-open" aria-hidden="true"></i>&nbsp;' . __( '<span class="gridbit-sr-only">Posted in </span>%1$s', 'gridbit' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
endif;


if ( ! function_exists( 'gridbit_single_postmeta' ) ) :
function gridbit_single_postmeta() {
    // See gridbit_grid_header_meta() above - same front-page guard.
    if ( is_front_page() || gridbit_is_auth_wizard_post() ) {
        return;
    }
    ?>
    <?php global $post; ?>
    <?php if ( !(gridbit_get_option('hide_post_author')) || !(gridbit_get_option('hide_posted_date')) || (!(gridbit_get_option('hide_comments_link')) && (! post_password_required() && ( comments_open() || get_comments_number() ))) || (!(gridbit_get_option('hide_post_categories')) && has_category()) || gridbit_get_option('show_post_edit') ) { ?>
    <div class="gridbit-entry-meta-single">
    <?php if ( !(gridbit_get_option('hide_post_author')) ) { ?><span class="gridbit-entry-meta-single-author"><i class="far fa-user-circle" aria-hidden="true"></i>&nbsp;<span class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span><?php } ?>
    <?php if ( !(gridbit_get_option('hide_posted_date')) ) { ?><span class="gridbit-entry-meta-single-date"><i class="far fa-clock" aria-hidden="true"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    <?php if ( !(gridbit_get_option('hide_comments_link')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridbit-entry-meta-single-comments"><i class="far fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( 'Leave a Comment<span class="gridbit-sr-only"> on %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    <?php if ( (!(gridbit_get_option('hide_post_categories')) && has_category()) ) { ?><?php gridbit_single_cats(); ?><?php } ?>
    <?php if ( gridbit_get_option('show_post_edit') ) { ?><?php edit_post_link( sprintf( wp_kses( /* translators: %s: Name of current post. Only visible to screen readers */ __( 'Edit<span class="gridbit-sr-only"> %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ), '<span class="edit-link">&nbsp;&nbsp;<i class="far fa-edit" aria-hidden="true"></i> ', '</span>' ); ?><?php } ?>
    </div>
    <?php } ?>
<?php }
endif;


if ( ! function_exists( 'gridbit_page_postmeta' ) ) :
function gridbit_page_postmeta() { ?>
    <?php global $post; ?>
    <?php if ( !(gridbit_get_option('hide_page_author')) || !(gridbit_get_option('hide_page_date')) || (!(gridbit_get_option('hide_page_comments')) && (! post_password_required() && ( comments_open() || get_comments_number() ))) ) { ?>
    <?php if ( !((is_front_page()) && (gridbit_get_option('hide_static_page_meta'))) && !( gridbit_is_auth_wizard_post() ) ) { ?>
    <div class="gridbit-entry-meta-single">
    <?php if ( !(gridbit_get_option('hide_page_author')) ) { ?><span class="gridbit-entry-meta-single-author"><i class="far fa-user-circle" aria-hidden="true"></i>&nbsp;<span class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span><?php } ?>
    <?php if ( !(gridbit_get_option('hide_page_date')) ) { ?><span class="gridbit-entry-meta-single-date"><i class="far fa-clock" aria-hidden="true"></i>&nbsp;<?php echo esc_html( get_the_date() ); ?></span><?php } ?>
    <?php if ( !(gridbit_get_option('hide_page_comments')) ) { ?><?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
    <span class="gridbit-entry-meta-single-comments"><i class="far fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_popup_link( sprintf( wp_kses( /* translators: %s: post title */ __( 'Leave a Comment<span class="gridbit-sr-only"> on %s</span>', 'gridbit' ), array( 'span' => array( 'class' => array(), ), ) ), wp_kses_post( get_the_title() ) ) ); ?></span>
    <?php } ?><?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
<?php }
endif;