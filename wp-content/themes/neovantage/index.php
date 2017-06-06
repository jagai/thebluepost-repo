<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package NEOVANTAGE
 */
get_header();
$page_layout = get_theme_mod( 'page_layout', 'sidebar-right' );
$layout_class = ( 'no-sidebar' == $page_layout ) ? 'col-lg-12' : 'col-lg-8';
?>
<div class="container">
    <div class="row">
        <?php if ( 'no-sidebar' != $page_layout && 'sidebar-left' == $page_layout ) {?>
        <?php get_sidebar();?>
        <?php }?>
        <div class="<?php echo sanitize_html_class( $layout_class ); ?>">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <?php
                    if (have_posts()) :

                        if (is_home() && !is_front_page()) :
                            ?>
                            <header>
                                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                            </header>
                            <?php
                        endif;

                        /* Start the Loop */
                        while (have_posts()) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part('template-parts/content', get_post_format());

                        endwhile;
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => __( '<i class="fa fa-chevron-left"></i>', 'neovantage' ),
                            'next_text' => __( '<i class="fa fa-chevron-right"></i>', 'neovantage' ),
                        ));
                    else :
                        get_template_part('template-parts/content', 'none');
                    endif;
                    ?>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
        <?php if ( 'no-sidebar' != $page_layout && 'sidebar-right' == $page_layout ) {?>
        <?php get_sidebar();?>
        <?php }?>
    </div>
</div>
<?php get_footer();