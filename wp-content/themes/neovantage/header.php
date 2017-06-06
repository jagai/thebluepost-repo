<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NEOVANTAGE
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <div id="page" class="site">
        <?php /* Preloader */ neovantage_render_preloader(); ?>
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'neovantage'); ?></a>
        <?php if( !is_page_template( 'page-templates/template-landing.php' ) ): ?>
        <header id="masthead" class="site-header" role="banner"
        <?php if ( get_header_image() ) : ?>
        style="background-image: url(<?php header_image(); ?>);"
        <?php endif; ?>
        >
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xs-3">
                        <div class="site-branding">
                            <div class="site-branding-position">
                                <?php
                                $custom_logo_id = get_theme_mod( 'custom_logo' );
                                if( isset( $custom_logo_id ) && !empty( $custom_logo_id ) ) {
                                    neovantage_site_logo();
                                } else {
                                ?>
                                <?php if (is_front_page() && is_home()) : ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><span><?php echo get_bloginfo('name'); ?></span></a></h1>
                                <?php else : ?>
                                <p class="site-title"><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><span><?php echo get_bloginfo('name'); ?></span></a></p>
                                <?php endif; ?>
                                <?php }?>

                                <?php
                                $description = get_bloginfo('description', 'display');
                                if ($description || is_customize_preview()) :
                                    echo '<p class="site-description">'.$description.'</p>';
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xs-9">
                        <nav class="neovantage-main-menu" role="navigation">
                            <?php
                            if (has_nav_menu('primary')) {
                                wp_nav_menu(
                                    array(
                                        'menu'              => 'primary',
                                        'theme_location'    => 'primary',
                                        'depth'             => 3,
                                        'container'         => FALSE,
                                        'menu_class'        => 'nav main-nav hidden-sm hidden-xs',
                                        'walker'            => new Neovantage_Walker_Nav_Menu_Main()
                                    )
                                );
                            } else {
                                echo '<span class="no-nav">'. __('No custom menu created!', 'neovantage') .'</span>';
                            }
                            ?>
                            <div class="toggle-bar">
                                <a href="javascript:void(0);"><i class="fa fa-bars"></i></a>
                            </div>
                        </nav><!-- #site-navigation -->
                        <nav class="neovantage-mobile-menu" role="navigation">
                            <a href="javascript:void(0);" class="neovantage-mobile-menu-close"><i class="fa fa-times"></i></a>
                            <?php
                            if (has_nav_menu('mobile')) {
                                wp_nav_menu(
                                    array(
                                        'menu'              => 'mobile',
                                        'theme_location'    => 'mobile',
                                        'depth'             => 3,
                                        'container'         => FALSE,
                                        'menu_class'        => 'nav mobile-nav',
                                        'walker'            => new Neovantage_Walker_Nav_Menu_Mobile()
                                    )
                                );
                            } else {
                                echo '<span class="no-nav">'. __('No custom menu created!', 'neovantage') .'</span>';
                            }
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->
        <?php endif; ?>

        <?php if( !is_page_template( 'page-templates/template-slideshow.php' ) && !is_page_template( 'page-templates/template-landing.php' ) && !is_page_template( 'page-templates/template-fullwidth-with-no-page-header.php' ) ): ?>
        
        <!-- Breadcrumb -->
        <section class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <?php if( is_home() && get_option('page_for_posts') ) { ?>
                        <h2><?php echo apply_filters('the_title', get_page( get_option('page_for_posts') )->post_title); ?></h2>
                        <?php } elseif(is_archive() ) {
                        the_archive_title( '<h2 class="page-title"><span>', '</h2></span>' );
                        the_archive_description( '<div class="taxonomy-description">', '</div>' );
                        }  elseif(is_search() ) { ?>
                        <h2 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'neovantage'), '<span>' . get_search_query() . '</span>'); ?></h2>
                        <?php } elseif( is_singular() ) { ?>
                        <h2><?php the_title(); ?></h2>
                        <?php } ?>
                    </div>
                    <div class="col-md-6"><?php echo neovantage_breadcrumbs(); ?></div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <section id="content" class="site-content">