<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package NEOVANTAGE
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- Edit Article -->
    <?php neovantage_edit_post(); ?>
    
    <!-- entry-media -->
    <?php
    if (has_post_thumbnail()):
        $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'neovantage-full-width', FALSE, '');
        $video_url = get_post_meta( (int) get_the_ID(), 'neovantage_video_url', TRUE );
        ?>
        <div class="entry-media">
            <?php if ($video_url) {?>
            <div class="video-wrapper">
                <!-- Copy & Pasted from YouTube -->
                <?php echo wp_oembed_get( esc_url( $video_url ) ); ?>
            </div>
            <?php } else { ?>
            <a class="image-wrap image-popup-no-margins" href="<?php echo esc_url( $src[0] ); ?>" title="<?php the_title(); ?>">
                <?php echo neovantage_get_post_thumbnail(null, 'neovantage-full-width'); ?>
                <?php $post_icon = neovantage_get_post_format_icon(); ?>
                <div class="<?php echo esc_attr( $post_icon['icon'] ); ?>"></div>
            </a>
            <?php } ?>
        </div>
    <?php endif; ?>
    
    <!-- .entry-header -->
    <?php get_template_part('template-parts/content', 'header'); ?>
    
    <!-- .entry-content -->
    <div class="entry-content">
        <?php if (!is_single()) : // Only display Excerpts for Search ?>
            <?php the_excerpt(); ?>
        <?php else: ?>
            <?php
            the_content();
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'neovantage'),
                    'after' => '</div>',
                )
            );
            ?>
        <?php endif; ?>
        <?php neovantage_entry_footer(); ?>
    </div><!-- .entry-content -->
    <?php if ('post' === get_post_type()) : ?>
        <div class="entry-meta clearfix">
            <?php neovantage_entry_meta(); ?>
            <?php if (!is_single()) : // Only display Excerpts for Search ?>
            <a href="<?php the_permalink(); ?>" rel="bookmark">
                <?php
                printf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __('Continue reading %s <span class="meta-nav">&rarr;</span>', 'neovantage'),
                    array('span' => array('class' => array())) ), the_title('<span class="screen-reader-text">"', '"</span>', false)
                )
                ?>
            </a>
            <?php endif; ?>
        </div><!-- .entry-meta -->
    <?php endif; ?>
</article><!-- #post-## -->