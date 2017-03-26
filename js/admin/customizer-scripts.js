/**
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
jQuery(document).ready(function() {
	jQuery('.controls#pt-img-container li img').click(function(){
		jQuery('.controls#pt-img-container li').each(function(){
			jQuery(this).find('img').removeClass ('pt-radio-img-selected') ;
		});
		jQuery(this).addClass ('pt-radio-img-selected') ;
	});
});