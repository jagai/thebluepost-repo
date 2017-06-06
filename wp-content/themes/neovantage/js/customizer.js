/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    // Site title and description.
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Add custom-background-image body class when background image is added.
    wp.customize('background_image', function(value) {
        value.bind(function(to) {
            $('body').toggleClass('custom-background-image', '' !== to);
        });
    });
})(jQuery);