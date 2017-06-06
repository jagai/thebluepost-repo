<?php
/**
 * NEOVANTAGE Theme Customizer.
 *
 * @package NEOVANTAGE
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function neovantage_customize_register( $wp_customize )
{
    /**
     * Failsafe is safe
     */
    if ( ! isset( $wp_customize ) ) {
        return;
    }
        
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    
    /**
     * Add Panel for Basic Settings.
     * 
     * @uses $wp_customize->add_panel() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
     * @link $wp_customize->add_panel() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_panel
     */
    /*
    $wp_customize->add_panel(
        'neovantage_panel_basic', // $id
        // $args
        array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Basic Settings', 'neovantage' ),
            'description' => __( 'Configure basic settings for the NEOVANTAGE Theme', 'neovantage' ),
        )
    );
    */
    
    /**
     * Add Section for Basic Settings.
     * 
     * @uses $wp_customize->add_section() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
     * @link $wp_customize->add_section() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
     */
    $wp_customize->add_section (
        'neovantage_section_basic', // $id
        array( // $args
            'priority' => 10,
            'title' => __( 'Basic Settings', 'neovantage' ),
            'description' => __( 'Here you will set your site-wide preferences.', 'neovantage' ),
            //'panel' => 'neovantage_panel_basic'
        )
    );
    
    /**
     * Maintenance Mode setting.
     *
     * - Setting: Maintenance Mode
     * - Control: checkbox
     * - Sanitization: checkbox
     * 
     * Uses a checkbox to configure the maintenance mode.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'maintenance_mode_setting', // $id
        array( // $args
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_checkbox'
        )
    );
    
    /**
     * Basic Checkbox control.
     *
     * - Control: Checkbox
     * - Setting: Enable/Disable Maintenance Mode
     * - Sanitization: checkbox
     * 
     * Register the core "checkbox" control to be used to enable/disbale Maintenance Mode setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'maintenance_mode_control', // $id
        array( // $args
            'settings' => 'maintenance_mode_setting',
            'section' => 'neovantage_section_basic',
            'type' => 'checkbox',
            'label' => __( 'Enable Maintenance Mode', 'neovantage' ),
            'description' => __( 'Site visitors will see a site logo with the message you set below.', 'neovantage' ),
        )
    );
    
    /**
     * Maintenance Message setting.
     *
     * - Setting: Maintenance Message
     * - Control: textarea
     * - Sanitization: html
     * 
     * Uses a textarea to configure the Maintenance Message for the Theme.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting(
        'maintenance_msg_setting',
        array(
            'default' => 'We are currently in maintenance mode. Please check back later.',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'neovantage_sanitize_html',
            'transport' => 'postMessage'
        )
    );
    
    /**
     * Basic Textarea control.
     *
     * - Control: Textarea
     * - Setting: Maintenance Message
     * - Sanitization: html
     * 
     * Register the core "textarea" control to be used to configure the Maintenance Message for the Theme.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'maintenance_msg_setting', // $id
        array( // $args
            'settings' => 'maintenance_msg_setting',
            'section' => 'neovantage_section_basic',
            'type' => 'textarea',
            'label' => __( 'Maintenance Message', 'neovantage' ),
            'description' => __( 'Message to show in maintenance mode', 'neovantage' ),
        )
    );
    
    /**
     * Preloader setting.
     *
     * - Setting: Preloader
     * - Control: select
     * - Sanitization: select
     * 
     * Uses a dropdown select to enable/disable the preloader.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'preloader', // $id
        array( // $args
            'default' => 'enable',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'neovantage_sanitize_select'
        )
    );
    
    /**
     * Basic Select control.
     *
     * - Control: Select
     * - Setting: Preloader
     * - Sanitization: select
     * 
     * Register the core "select" control to be used to enable/disable the Preloader setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'preloader', // $id
        array( // $args
            'settings' => 'preloader',
            'section' => 'neovantage_section_basic',
            'type' => 'select',
            'label' => __( 'Preloader', 'neovantage' ),
            'description' => __( 'Select enable to be used the preloader feature for your site.', 'neovantage' ),
            'choices' => array(
                'enable' => __( 'Enable', 'neovantage' ),
                'disable' => __( 'Disable', 'neovantage' )
            )
        )
    );
    
    /**
     * Page Layout setting.
     *
     * - Setting: Page Layout
     * - Control: select
     * - Sanitization: select
     * 
     * Uses a dropdown select to configure the Page Layout setting.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'page_layout', // $id
        array( // $args
            'default' => 'sidebar-right',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'neovantage_sanitize_select'
        )
    );
    
    /**
     * Basic Select control.
     *
     * - Control: Select
     * - Setting: Page Layout
     * - Sanitization: select
     * 
     * Register the core "select" control to be used to configure the Page Layout setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'page_layout', // $id
        array( // $args
            'settings' => 'page_layout',
            'section' => 'neovantage_section_basic',
            'type' => 'select',
            'label' => __( 'Page Layout', 'neovantage' ),
            'description' => __( 'Choose a default page layout for your pages: Sidebar Right, Sidebar Left or Fullwidth.', 'neovantage' ),
            'choices' => array(
                'sidebar-right' => __( 'Sidebar Right (default)', 'neovantage' ),
                'sidebar-left' => __( 'Sidebar Left', 'neovantage' ),
                'no-sidebar' => __( 'No Sidebar', 'neovantage' ),
            )
        )
    );
    
    /**
     * Facebook Follow Link setting.
     *
     * - Setting: Facebook Follow Link
     * - Control: url
     * - Sanitization: url
     * 
     * Uses a URL text field to configure the company social link URL displayed in the site footer.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'facebook_link', // $id
        array( // $args
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_url'
        )
    );
    
    /**
     * Basic URL control.
     *
     * - Control: Text: URL
     * - Setting: Contact Link
     * - Sanitization: url
     * 
     * Register the core "url" text control to be used to configure the Contact Link setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'facebook_link', // $id
        // $args
        array(
            'settings' => 'facebook_link',
            'section' => 'neovantage_section_basic',
            'type' => 'url',
            'label' => __( 'Facebook Link', 'neovantage' ),
            'description' => __( 'Facebook follow link URL to be displayed in the site footer.', 'neovantage' )
        )
    );
    
    /**
     * Twitter Follow Link setting.
     *
     * - Setting: Twitter Follow Link
     * - Control: url
     * - Sanitization: url
     * 
     * Uses a URL text field to configure the company social link URL displayed in the site footer.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'twitter_link', // $id
        array( // $args
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_url'
        )
    );
    
    /**
     * Basic URL control.
     *
     * - Control: Text: URL
     * - Setting: Contact Link
     * - Sanitization: url
     * 
     * Register the core "url" text control to be used to configure the Contact Link setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'twitter_link', // $id
        // $args
        array(
            'settings' => 'twitter_link',
            'section' => 'neovantage_section_basic',
            'type' => 'url',
            'label' => __( 'Twitter Link', 'neovantage' ),
            'description' => __( 'Twitter follow link URL to be displayed in the site footer.', 'neovantage' )
        )
    );
    
    /**
     * LinkedIn Follow Link setting.
     *
     * - Setting: LinkedIn Follow Link
     * - Control: url
     * - Sanitization: url
     * 
     * Uses a URL text field to configure the company social link URL displayed in the site footer.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'linkedIn_link', // $id
        array( // $args
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_url'
        )
    );
    
    /**
     * Basic URL control.
     *
     * - Control: Text: URL
     * - Setting: Contact Link
     * - Sanitization: url
     * 
     * Register the core "url" text control to be used to configure the Contact Link setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'linkedIn_link', // $id
        // $args
        array(
            'settings' => 'linkedIn_link',
            'section' => 'neovantage_section_basic',
            'type' => 'url',
            'label' => __( 'LinkedIn Link', 'neovantage' ),
            'description' => __( 'LinkedIn follow link URL to be displayed in the site footer.', 'neovantage' )
        )
    );
    
    /**
     * Pintrest Follow Link setting.
     *
     * - Setting: Pintrest Follow Link
     * - Control: url
     * - Sanitization: url
     * 
     * Uses a URL text field to configure the company social link URL displayed in the site footer.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'pintrest_link', // $id
        array( // $args
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_url'
        )
    );
    
    /**
     * Basic URL control.
     *
     * - Control: Text: URL
     * - Setting: Contact Link
     * - Sanitization: url
     * 
     * Register the core "url" text control to be used to configure the Contact Link setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'pintrest_link', // $id
        // $args
        array(
            'settings' => 'pintrest_link',
            'section' => 'neovantage_section_basic',
            'type' => 'url',
            'label' => __( 'Pintrest Link', 'neovantage' ),
            'description' => __( 'Pintrest follow link URL to be displayed in the site footer.', 'neovantage' )
        )
    );
    
    /**
     * Google Plus Follow Link setting.
     *
     * - Setting: Google Plus Follow Link
     * - Control: url
     * - Sanitization: url
     * 
     * Uses a URL text field to configure the company social link URL displayed in the site footer.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'google_plus_link', // $id
        array( // $args
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_url'
        )
    );
    
    /**
     * Basic URL control.
     *
     * - Control: Text: URL
     * - Setting: Contact Link
     * - Sanitization: url
     * 
     * Register the core "url" text control to be used to configure the Contact Link setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'google_plus_link', // $id
        // $args
        array(
            'settings' => 'google_plus_link',
            'section' => 'neovantage_section_basic',
            'type' => 'url',
            'label' => __( 'Google Plus Link', 'neovantage' ),
            'description' => __( 'Google Plus follow link URL to be displayed in the site footer.', 'neovantage' )
        )
    );
    
    /**
     * Add Section for Blog.
     * 
     * @uses $wp_customize->add_section() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
     * @link $wp_customize->add_section() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
     */
    $wp_customize->add_section (
        'neovantage_section_blog', // $id
        array( // $args
            'priority' => 20,
            'title' => __( 'Blog', 'neovantage' ),
            'description' => __( 'Settings related to blog.', 'neovantage' )
        )
    );
    
    /**
     * Get Image from Content setting.
     *
     * - Setting: Get Image from Content
     * - Control: checkbox
     * - Sanitization: checkbox
     * 
     * Uses a checkbox to get the image from content.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'get_image_from_content_setting', // $id
        array( // $args
            'default' => TRUE,
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_checkbox'
        )
    );
    
    /**
     * Basic Checkbox control.
     *
     * - Control: Checkbox
     * - Setting: Get Image from Content
     * - Sanitization: checkbox
     * 
     * Register the core "checkbox" control to be used to get image from content setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'get_image_from_content_control', // $id
        array( // $args
            'settings' => 'get_image_from_content_setting',
            'section' => 'neovantage_section_blog',
            'type' => 'checkbox',
            'label' => __( 'Get Featured Image from Content', 'neovantage' ),
            'description' => __( 'If you have not set a Featured image allow the system to show the first image from post content on archive pages.', 'neovantage' ),
        )
    );
    
    /**
     * Add Section for Footer.
     * 
     * @uses $wp_customize->add_section() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
     * @link $wp_customize->add_section() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
     */
    $wp_customize->add_section (
        'neovantage_section_footer', // $id
        array( // $args
            'priority' => 20,
            'title' => __( 'Footer', 'neovantage' ),
            'description' => __( 'Settings related to footer.', 'neovantage' )
        )
    );
    
    /**
     * Footer Widgets Area setting.
     *
     * - Setting: Footer Widgets Area
     * - Control: checkbox
     * - Sanitization: checkbox
     * 
     * Uses a checkbox to enable/disable the Footer Widgets Area.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'footer_widget_area_setting', // $id
        array( // $args
            'default' => FALSE,
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_checkbox'
        )
    );
    
    /**
     * Basic Checkbox control.
     *
     * - Control: Checkbox
     * - Setting: Footer Widgets Area
     * - Sanitization: checkbox
     * 
     * Register the core "checkbox" control to be used to enable/disable Footer Widgets Area setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control (
        'footer_widget_area_control', // $id
        array( // $args
            'settings' => 'footer_widget_area_setting',
            'section' => 'neovantage_section_footer',
            'type' => 'checkbox',
            'label' => __( 'Footer Widgets Area', 'neovantage' ),
            'description' => __( 'Enable/Disable the Footer Widgets area globally. Please visit Appearance/Widgets menu to add new widgets!', 'neovantage' ),
        )
    );
    
    /**
     * Footer Copyright Text setting example.
     *
     * - Setting: Footer Copyright Text
     * - Control: textarea
     * - Sanitization: html
     * 
     * Uses a text field to configure the user's copyright text displayed in the site footer.
     * 
     * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
     * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     */
    $wp_customize->add_setting (
        'footer_copyright_text', // $id
        array( // $args
            'default' => sprintf(
                    __( 'NEOVANTAGE Theme by <a rel="designer" href="%s">%s</a> <span class="sep"> | </span> Powered by <a rel="designer" href="%s">%s</a>', 'neovantage' ),
                    esc_url( 'pixelspress.com' ),
                    esc_html( 'PixelsPress' ),
                    esc_url( 'wordpress.org' ),
                    esc_html( 'WordPress' )
            ),
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback'	=> 'neovantage_sanitize_html'
        )
    );
    
    /**
     * Basic Text control.
     *
     * - Control: Basic: textarea
     * - Setting: Footer Copyright Text
     * - Sanitization: html
     * 
     * Register the core "text" control to be used to configure the Footer Copyright Text setting.
     * 
     * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
     * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     */
    $wp_customize->add_control(
        'footer_copyright_text', // $id
        // $args
        array(
            'settings' => 'footer_copyright_text',
            'section' => 'neovantage_section_footer',
            'type' => 'textarea',
            'label' => __( 'Footer Copyright Text', 'neovantage' ),
            'description' => __( 'Copyright or other text to be displayed in the site footer. HTML allowed.', 'neovantage' )
        )
    );
}
add_action( 'customize_register', 'neovantage_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function neovantage_customize_preview_js()
{
    wp_enqueue_script( 'neovantage_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'neovantage_customize_preview_js' );

/**
 * Select sanitization callback.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function neovantage_sanitize_select( $input, $setting )
{	
    // Ensure input is a slug.
    $input = sanitize_key( $input );

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Widget sanitization callback.
 * 
 * @param string $value
 * @return string
 */
function neovantage_sanitize_widget_area( $value )
{
    if ( !in_array( $value, array( 'enable', 'disable' ) ) ) {
        $value = 'disable';
    }
    return $value;
}

/**
 * Checkbox sanitization callback.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function neovantage_sanitize_checkbox( $checked )
{
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * HTML sanitization callback.
 *
 * - Sanitization: html
 * - Control: text, textarea
 * 
 * Sanitization callback for 'html' type text inputs. This callback sanitizes `$html`
 * for HTML allowable in posts.
 * 
 * 
 * @see wp_filter_post_kses() https://developer.wordpress.org/reference/functions/wp_filter_post_kses/
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
function neovantage_sanitize_html( $html )
{
    return wp_filter_post_kses( $html );
}

/**
 * URL sanitization callback.
 *
 * - Sanitization: url
 * - Control: text, url
 * 
 * Sanitization callback for 'url' type text inputs. This callback sanitizes `$url` as a valid URL.
 * 
 * NOTE: esc_url_raw() can be passed directly as `$wp_customize->add_setting()` 'sanitize_callback'.
 * It is wrapped in a callback here merely for example purposes.
 * 
 * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
function neovantage_sanitize_url( $url ) {
    return esc_url_raw( $url );
}