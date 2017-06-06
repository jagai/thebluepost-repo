<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package NEOVANTAGE
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- .entry-header -->
    <?php get_template_part( 'template-parts/content', 'header' ); ?>
    
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <?php if ( 'post' === get_post_type() ) : ?>
    <div class="entry-meta clearfix">
        <?php neovantage_entry_meta(); ?>
    </div><!-- .entry-meta -->
    <?php endif; ?>
</article><!-- #post-## -->