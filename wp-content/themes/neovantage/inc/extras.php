<?php

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package NEOVANTAGE
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function neovantage_body_classes($classes)
{
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }
    
    // Adds a class of no-sidebar to sites without active sidebar.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}
add_filter('body_class', 'neovantage_body_classes');

/**
 * Get the Featured image HTML of a post
 * 
 * @param integer $post_id
 * @param string $size
 * @param string|array $attr
 * @param bool $archive_only
 * @return string
 */
function neovantage_get_post_thumbnail( $post_id = NULL, $size = 'post-thumbnail', $attr = '', $archive_only = TRUE )
{
    $image_url = '';
  
    if ( has_post_thumbnail( $post_id ) ) {
        $image_url = get_the_post_thumbnail( $post_id, $size, $attr );
    }
    if ( $image_url ) {
        return $image_url;
    } else {
        
        if ( is_single() && TRUE === $archive_only ) {
            return '';
        }
    }
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function neovantage_pingback_header()
{
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action('wp_head', 'neovantage_pingback_header');

/**
 * Get Post Format Icons
 */
function neovantage_get_post_format_icon()
{
    switch (get_post_format()) {
        case 'gallery':
            $post_icon['icon'] = 'fa fa-camera';
            $post_icon['text'] = __('GALLERY', 'neovantage');
            break;
        case 'link':
            $post_icon['icon'] = 'fa fa-link';
            $post_icon['text'] = __('LINK', 'neovantage');
            break;
        case 'quote':
            $post_icon['icon'] = 'fa fa-quote-left';
            $post_icon['text'] = __('QUOTE', 'neovantage');
            break;
        case 'video':
            $post_icon['icon'] = 'fa fa-film';
            $post_icon['text'] = __('VIDEO', 'neovantage');
            break;
        case 'audio':
            $post_icon['icon'] = 'fa fa-music';
            $post_icon['text'] = __('AUDIO', 'neovantage');
            break;
        case 'image':
            $post_icon['icon'] = 'fa fa-image';
            $post_icon['text'] = __('IMAGE', 'neovantage');
        break;
        case 'status':
            $post_icon['icon'] = 'fa fa-comment';
            $post_icon['text'] = __('Status', 'neovantage');
        break;
        case 'aside':
            $post_icon['icon'] = 'fa fa-align-left';
            $post_icon['text'] = __('Aside', 'neovantage');
        break;
        case 'chat':
            $post_icon['icon'] = 'fa fa-comments';
            $post_icon['text'] = __('Chat', 'neovantage');
        break;
        default:
            if(is_sticky()){
                $post_icon['icon'] = 'fa fa-thumb-tack';
                $post_icon['text'] = __('STICKY', 'neovantage');
            } else {
                $post_icon['icon'] = 'fa fa-file-text';
                $post_icon['text'] = __('STANDARD', 'neovantage');
            }
            break;
    }
    return $post_icon;
}

/**
 * Render Preloader
 * 
 * @since 1.1.0
 */
function neovantage_render_preloader()
{
    $preloader_status = get_theme_mod( 'preloader', 'enable' );
    if ( isset($preloader_status) && "enable" == $preloader_status ) :
?>
        <!-- It allows to create preloader -->
        <div id="preloader" class="preloader">
            <span><?php _e('Loading', 'neovantage'); ?></span>
        </div>
<?php
    endif;
}

/*********************
CUSTOM WALKER
*********************/
if ( ! function_exists( 'neo_menu_children' ) ) :   
    function neo_menu_children ($object)
    {

        $neo_with_children = array();

        foreach ( $object as $menu ) {

            $neo_current_obj = $menu->menu_item_parent;

            if ( $neo_current_obj != '0' ) {
                $neo_with_children[] .= $menu->menu_item_parent;
            }
        }

        foreach ( $object as $menu ) {

            $neo_current_obj = $menu->ID;

            if ( in_array( $neo_current_obj, $neo_with_children ) ) {
                $menu->classes[] = "neo-has-children";
            }
        }
        return $object;
    }
endif;
add_filter( 'wp_nav_menu_objects', 'neo_menu_children' );

if ( ! class_exists( 'Neovantage_Walker_Nav_Menu_Main' ) ) :
    
    class Neovantage_Walker_Nav_Menu_Main extends Walker_Nav_Menu
    {
        function start_lvl( &$output, $depth=0, $args = array() ) {

            if ( $depth > 3 ) { return; }
            if ( $depth == 2 )  { $output .= '<ul class="grandchild-menu great-grandchild-menu">'; }
            if ( $depth == 1 )  { $output .= '<ul class="grandchild-menu">'; }
            if ( $depth == 0 )  { $output .= '<div class="links-menu"><ul class="sub-menu">'; }
        }

        function end_lvl( &$output, $depth=0, $args = array() ) {

            if ( $depth > 3 ) { return; }
            if ( $depth == 0 ) { $output .= '</ul></div>'; }
            if ( $depth == 1 ) { $output .= '</ul>'; }
            if ( $depth == 2 ) { $output .= '</ul>'; }

        }
    }
endif;

if ( ! class_exists( 'Neovantage_Walker_Nav_Menu_Mobile' ) ) :
    
    class Neovantage_Walker_Nav_Menu_Mobile extends Walker_Nav_Menu
    {   
        function start_lvl( &$output, $depth=0, $args = array() )
        {
            $indent = str_repeat("\t", $depth);
            if ( $depth > 3 ) { return; }
            if ( $depth == 2 )  { $output .= "\n$indent<ul class=\"great-grand-sub-menu\">"; }
            if ( $depth == 1 )  { $output .= "\n$indent<ul class=\"grand-sub-menu\">"; }
            if ( $depth == 0 )  { $output .= "\n$indent<ul class=\"sub-menu\">"; }
        }
        
        public function start_el( &$output, $object, $depth = 0, $args = array(), $id = 0 )
        {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $classes = empty( $object->classes ) ? array() : (array) $object->classes;
            $classes[] = 'menu-item-' . $object->ID;
            
            /**
             * Filter the CSS class(es) applied to a menu item's <li>.
             *
             * @since 3.0.0
             *
             * @see wp_nav_menu()
             *
             * @param array  $classes The CSS classes that are applied to the menu item's <li>.
             * @param object $item    The current menu item.
             * @param array  $args    An array of wp_nav_menu() arguments.
             */
            $class_names = join( ' ', (array) apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object, $args ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            
            /**
             * Filter the ID applied to a menu item's <li>.
             *
             * @since 3.0.1
             *
             * @see wp_nav_menu()
             *
             * @param string $menu_id The ID that is applied to the menu item's <li>.
             * @param object $object    The current menu item.
             * @param array  $args    An array of wp_nav_menu() arguments.
             */
            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $object->ID, $object, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .'>';
            $atts = array();
            $atts['title']  = ! empty( $object->attr_title ) ? $object->attr_title : '';
            $atts['target'] = ! empty( $object->target )     ? $object->target     : '';
            $atts['rel']    = ! empty( $object->xfn )        ? $object->xfn        : '';
            $atts['href']   = ! empty( $object->url )        ? $object->url        : '';
            
            /**
             * Filter the HTML attributes applied to a menu item's <a>.
             *
             * @since 3.6.0
             *
             * @see wp_nav_menu()
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
             *
             *     @type string $title  Title attribute.
             *     @type string $target Target attribute.
             *     @type string $rel    The rel attribute.
             *     @type string $href   The href attribute.
             * }
             * @param object $item The current menu item.
             * @param array  $args An array of wp_nav_menu() arguments.
             */
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $object, $args );
            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
            $item_output .= '</a>';
            
            if(in_array('neo-has-children', $classes)) {
                $item_output .= '<i class="fa fa-caret-down"></i>';
            }
            
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
            
        }

        function end_lvl( &$output, $depth=0, $args = array() )
        {
            $indent = str_repeat("\t", $depth);
            
            if ( $depth > 3 ) { return; }
            if ( $depth == 0 ) { $output .= "$indent</ul>\n"; }
            if ( $depth == 1 ) { $output .= "$indent</ul>\n"; }
            if ( $depth == 2 ) { $output .= "$indent</ul>\n"; }
        }
    }
endif;