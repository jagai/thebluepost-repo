<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NEOVANTAGE
 */
$footer_widget_area = get_theme_mod( 'footer_widget_area_setting', 0 );
?>
</section><!-- #content -->
<?php if (!is_page_template('page-templates/template-landing.php')): ?>
    <?php if ( shortcode_exists( 'instagram-feed' ) ) : ?>
    <?php echo do_shortcode('[instagram-feed]'); ?>
    <?php endif; ?>
<?php endif; ?>
<footer id="colophon" class="site-footer" role="contentinfo">
    <?php if ( !is_page_template('page-templates/template-landing.php') && '1' == $footer_widget_area ): ?>
    <div class="site-footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <?php dynamic_sidebar("footer-1"); ?>
                </div>
                <div class="col-lg-3">
                    <?php dynamic_sidebar("footer-2"); ?>
                </div>
                <div class="col-lg-3">
                    <?php dynamic_sidebar("footer-3"); ?>
                </div>
                <div class="col-lg-3">
                    <?php dynamic_sidebar("footer-4"); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="site-footer-content">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="copyright">
                        <?php
                        $footer_copyright_text = get_theme_mod(
                            'footer_copyright_text',
                            sprintf(
                                __( 'NEOVANTAGE Theme by <a rel="designer" href="%s">%s</a> <span class="sep"> | </span> Powered by <a rel="designer" href="%s">%s</a>', 'neovantage' ),
                                esc_url( 'pixelspress.com' ),
                                esc_html( 'PixelsPress' ),
                                esc_url( 'wordpress.org' ),
                                esc_html( 'WordPress' )
                            )
                        );
                        echo $footer_copyright_text;
                        ?>
                    </div><!-- .site-info -->
                </div>
                <div class="col-md-5">
                    <ul class="social-network">
                        <?php
                        $facebook_link = get_theme_mod('facebook_link','');
                        if ( $facebook_link ) :
                        ?>
                            <li><a data-placement="top" href="<?php echo esc_url( $facebook_link ); ?>" title="<?php echo __('Facebook', 'neovantage'); ?>"><i class="fa fa-facebook"></i></a></li>
                        <?php endif; ?>
                        
                        <?php
                        $twitter_link = get_theme_mod('twitter_link','');
                        if ( $twitter_link ) :
                        ?>
                            <li><a data-placement="top" href="<?php echo esc_url( $twitter_link ); ?>" title="<?php echo __('Twitter', 'neovantage'); ?>"><i class="fa fa-twitter"></i></a></li>
                        <?php endif; ?>
                        
                        <?php
                        $linkdin_link = get_theme_mod('linkdin_link','');
                        if ( $linkdin_link ) :
                        ?>
                            <li><a data-placement="top" href="<?php echo esc_url( $linkdin_link ); ?>" title="<?php echo __('LinkedIn', 'neovantage'); ?>"><i class="fa fa-linkedin"></i></a></li>
                        <?php endif; ?>
                        
                        <?php
                        $pintrest_link = get_theme_mod('pintrest_link','');
                        if ( $pintrest_link ) :
                        ?>
                            <li><a data-placement="top" href="<?php echo esc_url( $pintrest_link ); ?>" title="<?php echo __('Pinterest', 'neovantage'); ?>"><i class="fa fa-pinterest"></i></a></li>
                        <?php endif; ?>
                        
                        <?php
                        $google_plus_link = get_theme_mod('google_plus_link','');
                        if ( $google_plus_link ) :
                        ?>
                            <li><a data-placement="top" href="<?php echo esc_url( $google_plus_link ); ?>" title="<?php echo __('Google Plus', 'neovantage'); ?>"><i class="fa fa-google-plus"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>