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


// Hero Slider
jQuery(window).load(function() {
	if(typeof Swiper === 'function'){
		var courtyard_window_width = jQuery(window).width();

		var courtyard_services_slider_num = 3;

		if ( courtyard_window_width <= 992 ) {
			var courtyard_services_slider_num = 2;
		}

		if ( courtyard_window_width <= 580 ) {
			var courtyard_services_slider_num = 1;
		}

		jQuery('.pt-image-slider-section').each(function(index, element){
			var container  = jQuery(this).find('.pt-hero-image-slider');
			var nextButton = jQuery(this).find('.pt-hero-slider-nav .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-hero-slider-nav .pt-arrow-left');
			var pt_loop    = jQuery(this).find('.pt-hero-image-slide').data('slide-loop');

			var pt_front_slider = new Swiper (container,{
				nextButton: nextButton,
				prevButton: prevButton,
				slidesPerView: 1,
				spaceBetween: 0,
				loop: pt_loop,
				autoplay: 3000,
				speed: 1200,
				effect: 'fade',
				autoplayDisableOnInteraction: false,
				preventClicks: false,
				touchEventsTarget: 'swiper-wrapper',
				paginationClickable: true,

				onTransitionStart: function(slider) {

					var active_slide = slider.activeIndex;

					setTimeout(function () {
						jQuery('.swiper-slide').eq(active_slide).find('.pt-hero-image-cont header').fadeIn().addClass('animated fadeInUp');
					},400);

					setTimeout(function () {
						jQuery('.swiper-slide').eq(active_slide).find('.pt-hero-image-cont article').fadeIn().addClass('animated fadeInUp');
					},600);
				},

				onSlideChangeEnd: function(slider) {

					var next_slide = slider.activeIndex+1;
					var previous_slide = slider.activeIndex-1;

					jQuery('.swiper-slide').eq(next_slide).find('.pt-hero-image-cont header').hide();
					jQuery('.swiper-slide').eq(previous_slide).find('.pt-hero-image-cont header').hide();

					jQuery('.swiper-slide').eq(next_slide).find('.pt-hero-image-cont article').hide();
					jQuery('.swiper-slide').eq(previous_slide).find('.pt-hero-image-cont article').hide();
				}
			});
		});

		// Service Slider
		jQuery('.pt-service-section').each(function(index, element){
			var container  = jQuery(this).find('.pt-services-slider');
			var slideCount = jQuery(this).find('.swiper-slide').length;
			var nextButton = jQuery(this).find('.pt-more-arrow .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-more-arrow .pt-arrow-left');

			if ( slideCount < 6 ) {
				var courtyard_services_slider_per_col = 1;
			}
			if ( slideCount >= 6 ) {
				var courtyard_services_slider_per_col = 2;
			}
			if ( courtyard_window_width <= 580 ) {
				var courtyard_services_slider_per_col = 1;
			}

			var pt_services_slider = new Swiper(container, {
				nextButton: nextButton,
				prevButton: prevButton,
				spaceBetween: 0,
				preventClicks: false,
				slidesPerView: courtyard_services_slider_num,
				slidesPerColumn: courtyard_services_slider_per_col,
				touchEventsTarget: 'swiper-wrapper',
				speed: 800
			});
		});

		// Room Slider
		jQuery('.pt-rooms-section').each(function(index, element){
			var container  = jQuery(this).find('.pt-rooms-slider');
			var nextButton = jQuery(this).find('.pt-more-arrow .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-more-arrow .pt-arrow-left');

			var pt_rooms_slider = new Swiper(container, {
				nextButton: nextButton,
				prevButton: prevButton,
				spaceBetween: 30,
				preventClicks: false,
				slidesPerView: courtyard_services_slider_num,
				touchEventsTarget: 'swiper-wrapper',
				speed: 800
			});
		});

		// Testimonial Slider
		jQuery('.pt-testimonials-section').each(function(index, element){
			var container  = jQuery(this).find('.pt-testimonials-slider');
            var nextButton = jQuery(this).find('.pt-more-arrow .pt-arrow-right');
            var prevButton = jQuery(this).find('.pt-more-arrow .pt-arrow-left');

			var courtyard_services_slider_num = 2;

            if ( courtyard_window_width <= 768 ) {
                var courtyard_services_slider_num = 1;
            }

			var pt_testimonials_slider = new Swiper(container, {
				nextButton: nextButton,
				prevButton: prevButton,
				loop: false,
				autoplay: 3000,
				spaceBetween: 30,
				preventClicks: false,
				autoplayDisableOnInteraction: false,
				slidesPerView: courtyard_services_slider_num,
				touchEventsTarget: 'swiper-wrapper',
                pagination: '.swiper-pagination',
                paginationClickable: true,
				speed: 800
			});
		});
	}
});
