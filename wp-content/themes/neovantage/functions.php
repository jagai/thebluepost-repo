<?php
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    update_option('blogdescription', 'More Than Bits & Bytes');
}
/**
 * NEOVANTAGE functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NEOVANTAGE
 */
if (!function_exists('neovantage_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function neovantage_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on NEOVANTAGE, use a find and replace
         * to change 'neovantage' to the name of your theme in all the template files.
         */
        load_theme_textdomain('neovantage', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
        
        /*
	 * Enable support for custom logo.
	 *
	 *  @since NEOVANTAGE 1.0.4
	 */
	add_theme_support(
            'custom-logo',
            array(
		'height'      => 77,
		'width'       => 300,
		'flex-height' => true,
            )
        );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size( 743, 9999 ); // Unlimited height, soft crop
        add_image_size( 'neovantage-full-width', 1038, 9999 );
    
        // This theme uses wp_nav_menu() in one location for Desktop & Mobile.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'neovantage'),
            'mobile' => esc_html__( 'Mobile Menu', 'neovantage' ),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );
        
        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support(
           'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
                'gallery',
            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background');
    }
endif;
add_action('after_setup_theme', 'neovantage_setup');

add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function neovantage_content_width() {
    $GLOBALS['content_width'] = apply_filters('neovantage_content_width', 743);
}

add_action('after_setup_theme', 'neovantage_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function neovantage_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'neovantage'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'neovantage'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    register_sidebar(
        array(
            'name'          => esc_html__( 'Slideshow', 'neovantage' ),
            'id'            => 'slideshow',
            'description'   => esc_html__( 'Add Slideshow shortcode here.', 'neovantage' ),
            'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        )
    );
    register_sidebar(
        array (
            'name' => esc_html__( 'Footer Column 1', 'neovantage' ),
            'id'            => 'footer-1',
            'description'   => '',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title"><span>',
            'after_title'   => '</span></h4>',
        )
    );
    register_sidebar(
        array (
            'name' => esc_html__( 'Footer Column 2', 'neovantage' ),
            'id'            => 'footer-2',
            'description'   => '',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title"><span>',
            'after_title'   => '</span></h4>',
        )
    );
    register_sidebar(
        array (
            'name' => esc_html__( 'Footer Column 3', 'neovantage' ),
            'id'            => 'footer-3',
            'description'   => '',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title"><span>',
            'after_title'   => '</span></h4>',
        )
    );
    register_sidebar(
        array (
            'name' => esc_html__( 'Footer Column 4', 'neovantage' ),
            'id'            => 'footer-4',
            'description'   => '',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title"><span>',
            'after_title'   => '</span></h4>',
        )
    );
}

add_action('widgets_init', 'neovantage_widgets_init');

/**
 * Add Custom WordPress Admin Text Editor Style
 */
function neovantage_wp_editor_custom_style()
{
    add_editor_style( array( 'css/neovantage-admin-editor.css', get_template_directory_uri().'/fonts/custom-fonts.css' ) );
}
add_action( 'admin_init', 'neovantage_wp_editor_custom_style' );

/**
 * Enqueue styles and scripts.
 * 
 * CSS Libraries
 * 
 * - Bootstrap v3.1.0
 * - Magnific Popup - v1.1.0
 * - jQuery FlexSlider v2.6.1
 * - Font Awesome 4.6.3
 * 
 * JS Libraries
 * 
 * - Bootstrap v3.3.7
 * - File navigation.js.
 * - File skip-link-focus-fix.js.
 * - jQuery Easing v1.3
 * - Magnific Popup - v1.1.0    
 */
function neovantage_scripts()
{
    // Google Font
    $font_args = array(
        'family' => 'Noto+Serif:400,400italic,700'
                  . '|'
                  . 'Open+Sans:300,400,600,700'
                  . '|'
                  . 'Lato:400,400i,700,700i'
                  . '|'
                  . 'Montserrat:400,700',
    );
    //wp_enqueue_style( 'neovantage-google-fonts', add_query_arg( $font_args, "//fonts.googleapis.com/css" ) );
    wp_enqueue_style( 'neovantage-local-fonts', get_template_directory_uri().'/fonts/custom-fonts.css' );
    
    // Enqueue Main Stylesheet
    wp_enqueue_style('neovantage-style', get_stylesheet_uri());
    
    // Enqueue Script Libraries
    wp_enqueue_script( 'neovantage-library', get_template_directory_uri() . '/js/library.js', array ( 'jquery' ), '', TRUE );
    wp_enqueue_script( 'neovantage-google-code-prettify', get_template_directory_uri() . '/js/run_prettify.js', array (), '', TRUE );
    wp_enqueue_script( 'neovantage-custom', get_template_directory_uri() . '/js/custom.js', array ( 'jquery' ), '20151215', TRUE );
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }   
}

add_action('wp_enqueue_scripts', 'neovantage_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/*
 * Add Redux Framework
 */
require get_template_directory() . '/admin/admin-init.php';