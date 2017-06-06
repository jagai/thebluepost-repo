<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NEOVANTAGE
 */
if (!is_active_sidebar('sidebar-1')) {
    return;
}
$page_layout = get_theme_mod( 'page_layout', 'sidebar-right' );
?>
<div class="col-lg-4">
    <aside id="secondary" class="widget-area <?php echo esc_attr( $page_layout ); ?>" role="complementary">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </aside><!-- #secondary -->
</div>