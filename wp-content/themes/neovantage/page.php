<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( ( comments_open() || get_comments_number() ) ) :
                        comments_template();
                    endif;
                endwhile; // End of the loop.
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