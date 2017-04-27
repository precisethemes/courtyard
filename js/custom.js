jQuery(document).ready(function() {

	// Sticky Menu
	jQuery(window).scroll(function() {
		var scroll = jQuery(window).scrollTop();

		if (scroll >= 10) {
			jQuery( '.pt-front-page-only' ).removeClass( 'pt-home-navbar' );
		} else {
			jQuery( '.pt-front-page-only' ).addClass( 'pt-home-navbar' );
		}
	});

	// Toggle Menu
	jQuery( '.pt-menu-sm .fa-bars' ).on( 'click', function(){
		jQuery( '.pt-menu-sm-wrap' ).addClass( 'pt-show' );
	});

	jQuery( '.pt-menu-sm-wrap .fa-close' ).on( 'click', function(){
		jQuery( '.pt-menu-sm-wrap' ).removeClass( 'pt-show' );
	});

	// Scroll to Next Section
	jQuery( '.pt-arrow-down' ).click(function() {
		jQuery( 'html, body' ).animate({
			scrollTop: jQuery( '.pt-hero-scroll-to' ).offset().top - 88
		}, 800 );
	});

	// Append div just below the header only if first widget is hero slider.
	var get_slider_id = jQuery('.pt-image-slider-section .pt-hero-image-slider').data( 'slider_id' );

	if ( get_slider_id ){
		jQuery('.pt-navbar').addClass('pt-front-page-only');
	}

	if ( get_slider_id == null ){
		jQuery('.pt-navbar').removeClass('pt-home-navbar');
		jQuery('.pt-header-sep').removeClass('pt-header-sep-hide');
	}

	// Back to Top
	if (jQuery('#back-to-top').length) {
		var scrollTrigger = 500, // px
			backToTop = function () {
				var scrollTop = jQuery(window).scrollTop();
				if (scrollTop > scrollTrigger) {
					jQuery('#back-to-top').addClass('show');
				} else {
					jQuery('#back-to-top').removeClass('show');
				}
			};
		backToTop();
		jQuery(window).on('scroll', function () {
			backToTop();
		});
		jQuery('#back-to-top').on('click', function (e) {
			e.preventDefault();
			jQuery('html,body').animate({
				scrollTop: 0
			}, 800);
		});
	}
});

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

		// Hero Slider
		jQuery('.pt-image-slider-section').each(function(index, element){
			var container  = jQuery(this).find('.pt-hero-image-slider');
			var nextButton = jQuery(this).find('.pt-hero-slider-nav .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-hero-slider-nav .pt-arrow-left');

			var dt_front_slider = new Swiper (container,{
				nextButton: nextButton,
				prevButton: prevButton,
				slidesPerView: 1,
				spaceBetween: 0,
				loop: true,
				autoplay: 3000,
				speed: 1200,
				effect: 'fade',
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
			var nextButton = jQuery(this).find('.pt-services-more .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-services-more .pt-arrow-left');

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
			var nextButton = jQuery(this).find('.pt-rooms-more .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-rooms-more .pt-arrow-left');

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
			var nextButton = jQuery(this).find('.pt-testimonials-more .pt-arrow-right');
			var prevButton = jQuery(this).find('.pt-testimonials-more .pt-arrow-left');

			var pt_testimonials_slider = new Swiper(container, {
				nextButton: nextButton,
				prevButton: prevButton,
				spaceBetween: 30,
				preventClicks: false,
				slidesPerView: courtyard_services_slider_num,
				touchEventsTarget: 'swiper-wrapper',
				speed: 800
			});
		});
	}
});
