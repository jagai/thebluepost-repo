<?php
/*
 * Template Name: Blog with Slideshow
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package NEOVANTAGE
 */
get_header();
$page_layout = get_theme_mod( 'page_layout', 'sidebar-right' );
$layout_class = ( 'no-sidebar' == $page_layout ) ? 'col-lg-12' : 'col-lg-8';
?>
<?php if ( is_active_sidebar( 'slideshow' ) ) : ?>
<div id="featured"><?php dynamic_sidebar( "slideshow" ); ?></div>
<?php endif; ?>
<div class="container">
    <div class="row">
        <?php if ( 'no-sidebar' != $page_layout && 'sidebar-left' == $page_layout ) {?>
        <?php get_sidebar();?>
        <?php }?>
        <div class="<?php echo sanitize_html_class( $layout_class ); ?>">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <?php
                    global $paged, $wp_query, $wp;
                    if ( empty( $paged ) ) {
                        if ( ! empty( $_GET[ 'paged' ] ) ) {
                            $paged = $_GET[ 'paged' ];
                        } elseif ( ! empty( $wp->matched_query ) && $args = wp_parse_args( $wp->matched_query ) ) {
                            if ( ! empty( $args[ 'paged' ] ) ) {
                                $paged = $args[ 'paged' ];
                            }
                        }
                        if ( ! empty( $paged ) )
                            $wp_query->set( 'paged', $paged );
                    }

                    $temp = $wp_query;
                    $wp_query = null;
                    
                    $wp_query = new WP_Query();
                    $wp_query->query( "post_type=post&paged=" . $paged );
                    
                    while ( have_posts() ) : the_post();
                        get_template_part('template-parts/content', get_post_format());
                        
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    endwhile; // End of the loop.
                    
                    // Displays the navigation to next/previous set of posts, when applicable.
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __( '<i class="fa fa-chevron-left"></i>', 'neovantage' ),
                        'next_text' => __( '<i class="fa fa-chevron-right"></i>', 'neovantage' ),
                    ));
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