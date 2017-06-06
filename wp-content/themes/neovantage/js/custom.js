/*global jQuery:false */
(function( $ ) {
    $(document).ready(function() {
        "use strict";

        // tooltip
        $('.social-network li a, .options_box .color a').tooltip();

        // Magnific Popup
        $('.image-popup-no-margins').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            },
            callbacks: {
                afterClose: function() {
                    if (typeof niceScrolltrue !== 'undefined' && niceScrolltrue == 1) {
                        $('html').css('overflow', 'hidden');
                    }
                }
            }
        });
        $('.gallery-item a').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            },
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            },
            callbacks: {
                afterClose: function() {
                    if (typeof niceScrolltrue !== 'undefined' && niceScrolltrue == 1) {
                        $('html').css('overflow', 'hidden');
                    }
                }
            }
        });
        
        // Menu
        var neovantageBody = $('body'),
            neovantageMobOp = $('.toggle-bar'),
            neovantageMobClose = $('.neovantage-mobile-menu-close');

        neovantageMobOp.on("click", function(e) {
            e.preventDefault();
            neovantageBody.toggleClass('neovantage-mob-op');
        });
        
        neovantageMobClose.on("click", function(e) {
            e.preventDefault();
            neovantageBody.removeClass('neovantage-mob-op');
        });
        
        var neoMainNav = $('.main-nav li');

        // Show Sub Menu
        $('.main-nav > li').hoverIntent(
            function () {
                $(this).find('.links-menu .sub-menu').stop().fadeIn();
            }, function () {
                $(this).find('.links-menu .sub-menu').fadeOut();
            }
        );

        neoMainNav.find('.links-menu .sub-menu li').hoverIntent(function(){
            $(this).children('.grandchild-menu').stop().fadeIn();
        }, function() {
           $(this).children('.grandchild-menu').fadeOut();
        });
        
        var neoMobileNav = $('.mobile-nav li');
        
        neoMobileNav.find('i').on('click', function(){
            if( $(this).siblings('.sub-menu').css('display') == "none" ) {
                $(this).siblings('.sub-menu').stop().fadeIn();
            } else {
                $(this).siblings('.sub-menu').stop().fadeOut();
            }
        });
        
        neoMobileNav.find('.sub-menu i').on('click', function(){
            if( $(this).siblings('.grand-sub-menu').css('display') == "none" ) {
                $(this).siblings('.grand-sub-menu').stop().fadeIn();
            } else {
                $(this).siblings('.grand-sub-menu').stop().fadeOut();
            }
        });
        
        // Responsive Video
        $(function() {
            var $allVideos = $("iframe[src^='//player.vimeo.com'], iframe[src^='//www.youtube.com'], iframe[src^='//static.videezy.com'], object, embed"),
            $fluidEl = $("figure");

            $allVideos.each(function() {
                $(this)
                // jQuery .data does not work on object/embed elements
                .attr('data-aspectRatio', this.height / this.width)
                .removeAttr('height')
                .removeAttr('width');
            });
            $(window).resize(function() {
                var newWidth = $fluidEl.width();
                $allVideos.each(function() {
                    var $el = $(this);
                    $el
                    .width(newWidth)
                    .height(newWidth * $el.attr('data-aspectRatio'));
                });
            }).resize();
        });
        
        $(window).load(function() {
            if( $('#preloader').length ) {
                $('.preloader').fadeOut(1200);
            }
        });
    });
})( jQuery );