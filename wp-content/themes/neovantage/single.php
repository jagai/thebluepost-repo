<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
                <?php
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', get_post_format());
                    
                    // Social Share 
                    neovantage_social_shares();
                    
                    // Post Navigations
                    the_post_navigation(
                        array(
                            'next_text' => '<span class="meta-nav" aria-hidden="true"><i class="fa fa-long-arrow-right"></i></span> ' .
                            '<span class="screen-reader-text">' . __('Next post:', 'neovantage') . '</span> ' .
                            '<span class="post-title">%title</span>',
                            
                            'prev_text' => '<span class="meta-nav" aria-hidden="true"><i class="fa fa-long-arrow-left"></i></span> ' .
                            '<span class="screen-reader-text"><i class="fa fa-long-arrow-left"></i></span> ' .
                            '<span class="post-title">%title</span>',
                        )
                    );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
        <?php get_sidebar();?>
    </div>
</div>
<?php get_footer();