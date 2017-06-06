<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package NEOVANTAGE
 */

/**
 * Prints HTML with meta information for the current post-date/time, author, categories, tags and comments.
 */
if ( ! function_exists( 'neovantage_entry_meta' ) ) :

    function neovantage_entry_meta()
    {
        global $post;
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" style="display: none;">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );
        $posted_on = sprintf(
            esc_html_x( '%s', 'post date', 'neovantage' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );
        $byline = sprintf(
            esc_html_x( '%s', 'post author', 'neovantage' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        $meta_html = '<ul class="meta-post">';
            $meta_html .= '<li><i class="fa fa-calendar"></i> '. $posted_on .'</li>';
            $meta_html .= '<li><i class="fa fa-user"></i> '. $byline .'</li>';

            // Hide categories text for pages.
            if ( 'post' === get_post_type() ) {
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( esc_html__( ', ', 'neovantage' ) );
                if ( $categories_list && neovantage_categorized_blog() ) {
                    $meta_html .= sprintf( '<li><i class="fa fa-folder-open-o"></i> ' . esc_html__( '%1$s', 'neovantage' ) . '</li>', $categories_list ); // WPCS: XSS OK.
                }
            }

            if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                $meta_html .= '<li><i class="fa fa-comments"></i>';
                    $meta_html .= '<a href="'. esc_url( get_comments_link( $post->ID ) ) .'">';
                        $meta_html .= number_format_i18n( get_comments_number() );
                        if( number_format_i18n( get_comments_number() ) > 1 ) {
                            $meta_html .= __( ' Comments', 'neovantage' );
                        } else {
                            $meta_html .= __( ' Comment', 'neovantage' );
                        }
                    $meta_html .= '</a>';
                $meta_html .= '</li>';
            }
        $meta_html .= '</ul>';
        echo $meta_html;
    }
endif;

if (!function_exists('neovantage_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function neovantage_entry_footer()
    {
        // Hide tag text for pages.
        if ( is_single() && 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html__( ', ', 'neovantage' ) );
            if ( $tags_list ) {
                printf( '<div class="tags-links"><i class="fa fa-tags"></i> ' . esc_html__( '%1$s', 'neovantage' ) . '</div>', $tags_list ); // WPCS: XSS OK.
            }
        }
    }
endif;

if ( ! function_exists( 'neovantage_edit_post' ) ) :
    
/**
 * Show edit link.
 */
function neovantage_edit_post()
{
    edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__( 'Edit %s', 'neovantage' ),
            the_title( '<span class="screen-reader-text">"', '"</span>', false )
        ),
        '<span class="edit-link">', '</span>'
    );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function neovantage_categorized_blog()
{
    if (false === ( $all_the_cool_cats = get_transient('neovantage_categories') )) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(
            array(
                'fields' => 'ids',
                'hide_empty' => 1,
                // We only need to know if there is more than one category.
                'number' => 2,
            )
        );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('neovantage_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so neovantage_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so neovantage_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in neovantage_categorized_blog.
 */
function neovantage_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('neovantage_categories');
}

add_action('edit_category', 'neovantage_category_transient_flusher');
add_action('save_post', 'neovantage_category_transient_flusher');

if (!function_exists('neovantage_breadcrumbs')) :
    /**
     * Breadcrumbs
     * 
     * @global object $wp_query
     * @global object $post
     * @global object $author
     */
    function neovantage_breadcrumbs()
    {
        global $wp_query, $post;
        
        /* === OPTIONS === */
        $text['home'] = '<i class="fa fa-home"></i>'; // text for the 'Home' link
        $text['category'] = '%s'; // text for a category page
        $text['search'] = '%s'; // text for a search results page
        $text['tag'] = '%s'; // text for a tag page
        $text['author'] = '%s'; // text for an author page
        $text['404'] = __('Error 404', 'neovantage'); // text for the 404 page

        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = ''; // delimiter between crumbs
        $before = '<li class="active">'; // tag before the current crumb
        $after = '</li>'; // tag after the current crumb
        /* === END OF OPTIONS === */
        $current_page = '<a title="' . esc_attr( get_the_title() ) . '" href="' . esc_url( get_permalink() ) . '">' . esc_attr( get_the_title() ) . '</a>';
        $homeLink = esc_attr( home_url() ) . '/';
        $linkBefore = '<li>';
        $linkAfter = '</li>';
        $linkAttr = '';
        $link = $linkBefore . '<a ' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
        $linkhome = $linkBefore . '<a ' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        if (is_front_page()) {
            if ($showOnHome == "1")
                echo '<ul class="breadcrumb pull-right">' . $before . '<a href="' . $homeLink . '">' . $text['home'] . '</a>' . $after . '</ul>';
        } else {
            echo '<ul class="breadcrumb">' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
            if (is_home()) {
                echo $before . __('Blog', 'neovantage') . $after;
            } elseif (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('">', '">', $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo esc_attr($cats);
                }
                echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
            } elseif (is_search()) {
                echo $before . sprintf($text['search'], get_search_query()) . $after;
            } elseif (is_day()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                echo $before . get_the_time('d') . $after;
            } elseif (is_month()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo $before . get_the_time('F') . $after;
            } elseif (is_year()) {
                echo $before . get_the_time('Y') . $after;
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    printf($link, $homeLink . $slug['slug'] . '/', $post_type->labels->singular_name);
                    if ($showCurrent == 1)
                        echo $delimiter . $before . $current_page . $after;
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];

                    $cats = get_category_parents($cat, TRUE, $delimiter);

                    if ($showCurrent == 0)
                        $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);

                    $cats = str_replace('">', '">', $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo $cats;
                    if ($showCurrent == 1)
                        echo $before . $current_page . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                echo $before . $post_type->labels->singular_name . $after;
            } elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])) {
                $taxonomy = $taxonomy_category = '';
                $taxonomy = $wp_query->query_vars['taxonomy'];
                echo $before . $wp_query->query_vars[$taxonomy] . $after;
            } elseif (is_page() && !$post->post_parent) {
                if ($showCurrent == 1)
                    echo $before . '<a href="' . esc_url( get_permalink() ) . '">' . esc_attr( get_the_title() ) . '</a>' . $after;
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = sprintf($link, esc_url( get_permalink($page->ID) ), esc_attr( get_the_title( $page->ID ) ));
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs) - 1)
                        echo $delimiter;
                }

                if ($showCurrent == 1)
                    echo $delimiter . $before . esc_attr( get_the_title() ) . $after;
            } elseif (is_tag()) {
                echo $before . sprintf($text['tag'], esc_attr( single_tag_title( '', FALSE ) ) ) . $after;
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo $before . sprintf($text['author'], esc_attr( $userdata->display_name) ) . $after;
            } elseif (is_404()) {
                echo $before . $text['404'] . $after;
            }
            echo '</ul>';
        }
    }
endif;

if (!function_exists('neovantage_maintenance_mode')) :
    /**
     * Maintenance Mode
     */
    function neovantage_maintenance_mode()
    {
        $logo_img = '';
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        if( isset( $custom_logo_id ) && !empty( $custom_logo_id ) ) {
            $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            $logo_path = $image[0];
            $logo_img = '<img src="'. esc_url( $logo_path ) .'" alt="'. esc_attr__('Maintenance', 'neovantage').'" style="margin: 0 auto; display: block;" />';
        }
        $maintenance_mode_setting = get_theme_mod( 'maintenance_mode_setting', '0' );
        
        if ( !empty( $maintenance_mode_setting ) && '1' == $maintenance_mode_setting )
        {
            if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
                wp_die(
                    $logo_img 
                        . '<div style="text-align:center">'
                        . esc_textarea( get_theme_mod( 'maintenance_msg_setting', 'We are currently in maintenance mode. Please check back later.' ) )
                        . '</div>',
                    get_bloginfo( 'name' )
                );
            }
        }
    }
endif;
add_action('get_header', 'neovantage_maintenance_mode');

/**
 * Filter the except length to 20 words.
 *
 * @since 1.1.0
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function neovantage_excerpt_length( $length )
{
    return 35;
}
add_filter( 'excerpt_length', 'neovantage_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 * 
 * @since 1.1.0
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function neovantage_excerpt_more( $more )
{
    return ' ...';
}
add_filter( 'excerpt_more', 'neovantage_excerpt_more' );

if (!function_exists('neovantage_grab_ids_from_gallery')) :
    
    /**
     * Post gallery
     * 
     * @global object $post
     * @return object
     */
    function neovantage_grab_ids_from_gallery()
    {
        global $post;
        $gallery = neovantage_get_shortcode_from_content('gallery');
        $object = new stdClass();
        $object->columns = '3';
        $object->link = 'post';
        $object->ids = array();
        if($gallery) {
            $object = neovantage_extra_shortcode('gallery', $gallery, $object);
        }
        return $object;
    }
endif;

if ( ! function_exists( 'neovantage_get_shortcode_from_content' ) ) :
    
    /**
     * Get Shortcode From Content
     * 
     * @global object $post
     * @param mixed $param
     * @return string
     */
    function neovantage_get_shortcode_from_content( $param )
    {
        global $post;
        $pattern = get_shortcode_regex();
        $content = $post->post_content;
        if ( preg_match_all( '/' . $pattern . '/s', $content, $matches ) && array_key_exists( 2, $matches ) && in_array( $param, $matches[ 2 ] ) ) {
            $key = array_search( $param, $matches[ 2 ] );
            return $matches[ 0 ][ $key ];
        }
    }
endif;

if ( ! function_exists( 'neovantage_extra_shortcode' ) ) :
    
    /**
     * Extra shortcode
     * 
     * @param string $name
     * @param string $shortcode
     * @param object $object
     * @return object
     */
    function neovantage_extra_shortcode( $name, $shortcode, $object )
    {
        if ( $shortcode && is_object( $object ) ) {
            $attrs = str_replace( array ( '[', ']', '"', $name ), null, $shortcode );
            $attrs = explode( ' ', $attrs );
            if ( is_array( $attrs ) ) {
                foreach ( $attrs as $attr ) {
                    $_attr = explode( '=', $attr );
                    if ( count( $_attr ) == 2 ) {
                        if ( $_attr[ 0 ] == 'ids' ) {
                            $object->$_attr[ 0 ] = explode( ',', $_attr[ 1 ] );
                        } else {
                            $object->$_attr[ 0 ] = $_attr[ 1 ];
                        }
                    }
                }
            }
        }
        return $object;
    }
endif;

if ( ! function_exists( 'neovantage_social_shares' ) ) :
    
    /**
     * Post Social Share Links
     */
    function neovantage_social_shares()
    {
        $page_title = get_the_title();
        $current_url = "http://" . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ];
?>
    <div class="social-share">
        <span class="social-share-title"><?php echo __( 'Share Post:', 'neovantage' ); ?></span>
        <a href="http://digg.com/submit?url=<?php echo esc_url( $current_url ); ?>&#038;title=<?php echo rawurlencode( $page_title ); ?>" target="_blank" title="<?php echo __('Share on Digg', 'neovantage'); ?>" class="digg">
            <i class="fa fa-digg"></i>
        </a>
        
        <a href="http://www.facebook.com/share.php?u=<?php echo esc_url( $current_url ); ?>" target="_blank" class="facebook">
            <i class="fa fa-facebook"></i>
        </a>
        
        <a href="https://plus.google.com/share?url=<?php echo esc_url( $current_url ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500');return false;" class="google-plus">
            <i class="fa fa-google"></i>
        </a>
        
        <a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo esc_url( $current_url ); ?>&#038;title=<?php echo rawurlencode( $page_title ); ?>" target="_blank" class="linkedin">
            <i class="fa fa-linkedin"></i>
        </a>
        <?php
        $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
        $thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'large' );
        ?>
        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( $current_url ); ?>&media=<?php echo esc_url( $thumbnail[ 0 ] ); ?>" class="pin-it-button pinterest" count-layout="horizontal" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
            <i class="fa fa-pinterest"></i>
        </a>	
        
        <a href="http://reddit.com/submit?url=<?php echo esc_url( $current_url ); ?>&#038;title=<?php echo rawurlencode( $page_title ); ?>" target="_blank" class="reddit">
            <i class="fa fa-reddit"></i>
        </a>
        
        <a href="http://www.stumbleupon.com/submit?url=<?php echo esc_url( $current_url ); ?>&#038;title=<?php echo rawurlencode( $page_title ); ?>" target="_blank" class="stumbleupon">
            <i class="fa fa-stumbleupon"></i>
        </a>
        
        <a href="http://twitter.com/home?status=<?php echo str_replace( '%26%23038%3B', '%26', rawurlencode( $page_title ) ) . ' - ' . esc_url( $current_url ); ?>" target="_blank" class="twitter">
            <i class="fa fa-twitter"></i>
        </a>
        <div class="clear"></div>
    </div>
        <?php
    }
endif;


if ( !function_exists( 'neovantage_comment' ) ) :
    
    /**
     * Custom Comments Structure
     * 
     * @param string $comment
     * @param array $args
     * @param int $depth
     */
    function neovantage_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $GLOBALS['depth'] = $depth;
?> 
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" class="clearfix">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
            <div class="wrapper">
                <div class="comment-author vcard"><?php echo get_avatar( antispambot( $comment->comment_author_email ), 65 ); ?></div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.', 'neovantage') ?></em>
                <?php endif; ?>	      	
                <div class="extra-wrap">
                    <?php printf( __('<span class="author">%1$s</span>', 'neovantage' ), get_comment_author_link() ); ?><br />
                    <?php printf( __('%1$s', 'neovantage'), get_comment_date('F j, Y') ); ?>
                    <?php esc_html( comment_text() ); ?>
                </div>
            </div>
            <div class="wrapper">
                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply"></i> Reply', 'neovantage' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
            </div>
        </div>
    </li>
<?php
    }
endif;

if ( ! function_exists( 'neovantage_site_logo' ) ) :
    
    /**
     * Displays the optional custom logo.
     *
     * Does nothing if the custom logo is not available.
     *
     * @since NEOVANTAGE 1.0.4
     */
    function neovantage_site_logo() {
        if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
        }
    }
endif;