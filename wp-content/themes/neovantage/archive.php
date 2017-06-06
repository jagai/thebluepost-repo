<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
                <?php if ( have_posts() ) : ?>
                    <?php
                    /* Start the Loop */
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/content', get_post_format() );
                    endwhile;
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __( '<i class="fa fa-chevron-left"></i>', 'neovantage' ),
                        'next_text' => __( '<i class="fa fa-chevron-right"></i>', 'neovantage' ),
                    ));
                else :
                    get_template_part( 'template-parts/content', 'none' );
                endif;
                ?>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
        <?php get_sidebar();?>
    </div>
</div>
<?php get_footer();