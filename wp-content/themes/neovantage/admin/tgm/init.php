<?php
/**
 * TGM Init Class
 */
if ( file_exists( dirname( __FILE__ ) . '/class-tgm-plugin-activation.php' ) ) {
    require_once get_template_directory() . '/admin/tgm/class-tgm-plugin-activation.php';
    
    add_action( 'tgmpa_register', 'neovantage_register_plugins' );
    
    /**
     * Register the optional plugins for this theme.
     *
     * In this, we register four plugins:
     * - NEOVANTAGE Core included with the TGMPA library
     * - Redux Framework plugin from the .org repo included with the TGMPA library
     * - NEO Bootstrap Carousel included with the TGMPA library
     * - Contact Form 7 included with the TGMPA library
     * - Instagram Feed included with the TGMPA library
     *
     * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
     */
    function neovantage_register_plugins()
    {
        $plugins = array (
            array (
                'name' => 'NEOVANTAGE CORE',
                'slug' => 'neovantage-core',
                'source' => 'http://downloads.pixelspress.com/plugin/neovantage-core.1.0.1.zip',
                'required' => FALSE,
                'version' => '1.0.1',
                'force_activation' => FALSE,
                'force_deactivation' => FALSE,
                'image_url' => get_stylesheet_directory_uri() . '/images/neovantage-core.jpg',
            ),
            array (
                'name' => 'NEO Bootstrap Carousel',
                'slug' => 'neo-bootstrap-carousel',
                'source' => 'https://downloads.wordpress.org/plugin/neo-bootstrap-carousel.1.2.1.zip',
                'required' => FALSE,
                'version' => '1.2.1',
                'force_activation' => FALSE,
                'force_deactivation' => FALSE,
                'image_url' => get_stylesheet_directory_uri() . '/images/neo-bootstrap-carousel.jpg',
            ),
            array (
                'name' => 'Contact Form 7',
                'slug' => 'contact-form-7',
                'source' => 'https://downloads.wordpress.org/plugin/contact-form-7.4.7.zip',
                'required' => FALSE,
                'version' => '4.7',
                'force_activation' => FALSE,
                'force_deactivation' => FALSE,
                'image_url' => get_stylesheet_directory_uri() . '/images/contact-form-7.jpg',
            ),
            array (
                'name' => 'Instagram Feed',
                'slug' => 'instagram-feed',
                'source' => 'https://downloads.wordpress.org/plugin/instagram-feed.1.4.8.zip',
                'required' => FALSE,
                'version' => '1.4.8',
                'force_activation' => FALSE,
                'force_deactivation' => FALSE,
                'image_url' => get_stylesheet_directory_uri() . '/images/instagram-feed.jpg',
            ),
        );

        $config = array (
            'domain' => 'neovantage',
            'default_path' => '', // Default absolute path to pre-packaged plugins
            'menu' => 'neovantage-install-plugins', // Menu slug
            'has_notices' => TRUE, // Show admin notices or not.
            'dismissable' => TRUE, // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => FALSE, // Automatically activate plugins after installation or not
            'message' => '', // Message to output right before the plugins table.
            'strings' => array (
                'page_title'    => __( 'Install Required Plugins', 'neovantage' ),
                'menu_title'    => __( 'Install Plugins', 'neovantage' ),
                'installing'    => __( 'Installing Plugin: %s', 'neovantage' ), // %1$s = plugin name
                'updating'      => __( 'Updating Plugin: %s', 'neovantage' ),
                'oops'          => __( 'Something went wrong with the plugin API.', 'neovantage' ),
                'notice_can_install_required'     => _n_noop(
                    'This theme requires the following plugin: %1$s.',
                    'This theme requires the following plugins: %1$s.',
                    'neovantage'
                ),
                'notice_can_install_recommended'  => _n_noop(
                    'This theme recommends the following plugin: %1$s.',
                    'This theme recommends the following plugins: %1$s.',
                    'neovantage'
                ),
                'notice_ask_to_update'            => _n_noop(
                    'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                    'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                    'neovantage'
                ),
                'notice_ask_to_update_maybe'      => _n_noop(
                    'There is an update available for: %1$s.',
                    'There are updates available for the following plugins: %1$s.',
                    'neovantage'
                ),
                'notice_can_activate_required'    => _n_noop(
                    'The following required plugin is currently inactive: %1$s.',
                    'The following required plugins are currently inactive: %1$s.',
                    'neovantage'
                ),
                'notice_can_activate_recommended' => _n_noop(
                    'The following recommended plugin is currently inactive: %1$s.',
                    'The following recommended plugins are currently inactive: %1$s.',
                    'neovantage'
                ),
                'install_link'                    => _n_noop(
                    'Begin installing plugin',
                    'Begin installing plugins',
                    'neovantage'
                ),
                'update_link'                     => _n_noop(
                    'Begin updating plugin',
                    'Begin updating plugins',
                    'neovantage'
                ),
                'activate_link'                   => _n_noop(
                    'Begin activating plugin',
                    'Begin activating plugins',
                    'neovantage'
                ),
                'return'                          => __( 'Return to Required Plugins Installer', 'neovantage' ),
                'plugin_activated'                => __( 'Plugin activated successfully.', 'neovantage' ),
                'activated_successfully'          => __( 'The following plugin was activated successfully:', 'neovantage' ),
                
                /* translators: 1: plugin name. */
                'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'neovantage' ),
                
                /* translators: 1: plugin name. */
                'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'neovantage' ),
                /* translators: 1: dashboard link. */
                'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'neovantage' ),
                'dismiss'                         => __( 'Dismiss this notice', 'neovantage' ),
                'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'neovantage' ),
                'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'neovantage' ),
                'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
            )
        );
        tgmpa( $plugins, $config );
    }
}