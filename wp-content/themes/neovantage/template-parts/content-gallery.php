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
    
    <!-- entry-media -->
    <?php
    if (has_post_thumbnail()):
        $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'neovantage-full-width', FALSE, '');
    ?>
    <div class="entry-media">
        <a class="image-wrap image-popup-no-margins" href="<?php echo esc_url( $src[0] ); ?>" title="<?php the_title(); ?>">
            <?php echo neovantage_get_post_thumbnail(null, 'neovantage-full-width'); ?>
            <?php $post_icon = neovantage_get_post_format_icon(); ?>
            <div class="<?php echo esc_attr( $post_icon['icon'] ); ?>"></div>
        </a>
    </div>
    <?php else: ?>
        <?php
        global $post;
        $get_image_from_content_setting = get_theme_mod( 'get_image_from_content_setting', 1 );
        if ( $get_image_from_content_setting == 1 ) {
            $output = preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post->post_content, $matches);
            if( isset( $matches[1][0] ) ) {
        ?>
    <div class="entry-media">
        <a class="image-wrap image-popup-no-margins" href="<?php echo esc_url( $matches[1][0] ); ?>" title="<?php the_title(); ?>">
            <?php echo '<img src="' . esc_url( $matches[1][0] ) . '" alt="' . esc_attr( $post->post_title ) . '">'; ?>
            <?php $post_icon = neovantage_get_post_format_icon(); ?>
            <div class="<?php echo esc_attr( $post_icon['icon'] ); ?>"></div>
        </a>
    </div>
        <?php                
            }
        }
        ?>
    <?php endif; ?>
    
    <!-- .post-slider -->
    <div class="post-slider">
        <?php
        $gallery_ids = neovantage_grab_ids_from_gallery()->ids;
        if ( ! empty( $gallery_ids ) ):
            $i = 0;
        ?>
        <div id="post-slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                foreach ( $gallery_ids as $image_id ): ?>
                <?php
                $attachment_image = wp_get_attachment_image_src( $image_id, 'full', FALSE );
                if ( $attachment_image[ 0 ] != '' ):
                    $class_active = ( $i == 0 ) ? ' active' : '';
                ?>
                <div class="item <?php echo $class_active; ?>"><img alt="" src="<?php echo esc_url( $attachment_image[ 0 ] ); ?>"></div>
                <?php
                $i++;
                endif;
                ?>
                <?php endforeach; ?>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#post-slider" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only"><?php echo __('Previous', 'neovantage'); ?></span>
            </a>
            <a class="right carousel-control" href="#post-slider" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only"><?php echo __('Next', 'neovantage'); ?></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- .entry-header -->
    <?php get_template_part( 'template-parts/content', 'header' ); ?>
    
    <!-- .entry-content -->
    <div class="entry-content">
        <?php if ( ! is_single() ) : // Only display Excerpts for Search ?>
            <?php the_excerpt(); ?>
        <?php else : ?>
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
    <?php if ( 'post' === get_post_type() ) : ?>
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