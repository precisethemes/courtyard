jQuery(document).ready(function($) {

	// Sticky Menu
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();

		if (scroll >= 10) {
            $( '.pt-front-page-only' ).removeClass( 'pt-home-navbar' );
		} else {
            $( '.pt-front-page-only' ).addClass( 'pt-home-navbar' );
		}
	});

	// Toggle Menu
    $( '.pt-menu-sm .fa-bars' ).on( 'click', function(){
        $( '.pt-menu-sm-wrap' ).addClass( 'pt-show' );
	});

    $( '.pt-menu-sm-wrap .fa-close' ).on( 'click', function(){
        $( '.pt-menu-sm-wrap' ).removeClass( 'pt-show' );
	});

	// Scroll to Next Section
    $( '.pt-arrow-down' ).click(function() {
        $( 'html, body' ).animate({
			scrollTop: $( '.pt-hero-scroll-to' ).offset().top - 88
		}, 800 );
	});

	// Append div just below the header only if first widget is hero slider.
	var get_slider_id = $('.pt-image-slider-section .pt-hero-image-slider').data( 'slider_id' );

	if ( get_slider_id ){
        $('.pt-navbar').addClass('pt-front-page-only');
	}

	if ( get_slider_id == null ){
        $('.pt-navbar').removeClass('pt-home-navbar');
        $('.pt-header-sep').removeClass('pt-header-sep-hide');
	}

    $(window).scroll(function(){
        $( '.pt-hero-image-cont-wrap' ).css( 'opacity', 1 - $(window).scrollTop() / 300 );
    });

	// Back to Top
	if ( $( '#back-to-top' ).length) {
		var scrollTrigger = 500, // px
			backToTop = function () {
				var scrollTop = $(window).scrollTop();
				if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
				} else {
                    $('#back-to-top').removeClass('show');
				}
			};
		backToTop();
        $(window).on('scroll', function () {
			backToTop();
		});
        $('#back-to-top').on('click', function (e) {
			e.preventDefault();
            $('html,body').animate({
				scrollTop: 0
			}, 800);
		});
	}
});

// Swiper
jQuery(window).load(function() {

    // Swiper Slider Integration
    if(typeof Swiper === 'function'){

        // Hero Slider
        jQuery('.pt-image-slider-section').each(function(index, element){
            var container  = jQuery(this).find('.pt-hero-image-slider');

            var pt_front_slider = new Swiper (container,{
                slidesPerView: 1,
                spaceBetween: 0,
                loop: container.find('.pt-hero-image-slide').data('slide-loop'),
                autoplay: {
                    delay: 3000
                },
                speed: 1200,
                effect: 'fade',
                autoplayDisableOnInteraction: false,
                preventClicks: false,
                touchEventsTarget: 'swiper-wrapper',
                paginationClickable: true,
                navigation: {
                    nextEl: container.find('.pt-hero-slider-nav .pt-arrow-right'),
                    prevEl: container.find('.pt-hero-slider-nav .pt-arrow-left')
                },

                onTransitionStart: function(slider) {

                    var active_slide = slider.activeIndex;

                    setTimeout(function () {
                        container.find('.swiper-slide').eq(active_slide).find('.entry-header, .entry-content, .entry-footer').fadeIn().addClass('animated fadeInUp');
                    },1000);
                },

                onSlideChangeEnd: function(slider) {

                    var next_slide = slider.activeIndex+1;
                    var previous_slide = slider.activeIndex-1;
                    container.find('.swiper-slide').eq(next_slide).find('.entry-header, .entry-content, .entry-footer').hide();
                    container.find('.swiper-slide').eq(previous_slide).find('.entry-header, .entry-content, .entry-footer').hide();
                }

            });
        });

        // Room Listing Slider
        jQuery('.pt-rooms-section').each(function(index, element){
            var container           = jQuery(this).find('.pt-rooms-slider');

            var pt_rooms_slider = new Swiper(container, {
                spaceBetween: 30,
                preventClicks: false,
                slidesPerView: 3,
                slidesPerColumn: 1,
                touchEventsTarget: 'swiper-wrapper',
                speed: 800,
                navigation: {
                    nextEl: container.find('.pt-more-arrow .pt-arrow-right'),
                    prevEl: container.find('.pt-more-arrow .pt-arrow-left')
                },
                breakpoints: {
                    992: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 2
                    },
                    576: {
                        slidesPerView: 1
                    }
                }
            });
        });

        // Service Slider
        jQuery('.pt-service-section').each(function(index, element){
            var container           = jQuery(this).find('.pt-services-slider'),
                slideCount          = container.find('.swiper-slide').length;

            var pt_services_slider = new Swiper(container, {
                spaceBetween: 0,
                preventClicks: false,
                slidesPerView: 3,
                slidesPerColumn: ( slideCount > 5 ) ? 2 : 1 ,
                touchEventsTarget: 'swiper-wrapper',
                speed: 800,
                navigation: {
                    nextEl: container.find('.pt-more-arrow .pt-arrow-right'),
                    prevEl: container.find('.pt-more-arrow .pt-arrow-left')
                },
                breakpoints: {
                    992: {
                        slidesPerView: 3,
                        slidesPerColumn: 1
                    },
                    768: {
                        slidesPerView: 2,
                        slidesPerColumn: 1
                    },
                    576: {
                        slidesPerView: 1,
                        slidesPerColumn: 1
                    }
                }
            });
        });

        // Testimonial Slider
        jQuery('.pt-testimonials-section').each(function(index, element){
            var container  = jQuery(this).find('.pt-testimonials-slider');

            var pt_testimonials_slider = new Swiper(container, {
                loop: true,
                autoplay: {
                    delay: 3000
                },
                spaceBetween: 30,
                preventClicks: false,
                autoplayDisableOnInteraction: false,
                slidesPerView: 2,
                touchEventsTarget: 'swiper-wrapper',
                pagination: '.swiper-pagination',
                paginationClickable: true,
                speed: 800,
                navigation: {
                    nextEl: container.find('.pt-more-arrow .pt-arrow-right'),
                    prevEl: container.find('.pt-more-arrow .pt-arrow-left')
                },
                breakpoints: {
                    992: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 1
                    },
                    576: {
                        slidesPerView: 1
                    }
                }
            });
        });

    }

});
