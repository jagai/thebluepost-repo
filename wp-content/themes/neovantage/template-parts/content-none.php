<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package NEOVANTAGE
 */
?>
<section class="no-results not-found">
    <h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'neovantage' ); ?></h2>
    <div class="page-content">
        <?php
        if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
            <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'neovantage' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
        <?php elseif ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'neovantage' ); ?></p>
            <?php
            get_search_form();
        else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'neovantage' ); ?></p>
            <?php
            get_search_form();
        endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->