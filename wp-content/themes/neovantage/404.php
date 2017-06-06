<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package NEOVANTAGE
 */
get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <section class="error-404 not-found">
                        <header class="entry-header">
                            <h2 class="page-title"><?php esc_html_e( '404!', 'neovantage' )?></h2>
                            <p class="lead"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'neovantage' ); ?></p>
                        </header><!-- .entry-header -->
                        <div class="entry-content">
                            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'neovantage' ); ?></p>
                            <a href="<?php echo esc_url( home_url() );?>" class="btn btn-primary"><?php esc_html_e('Back to Home', 'neovantage'); ?></a>
                        </div>
                    </section>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
        <?php get_sidebar();?>
    </div>
</div>
<?php get_footer();