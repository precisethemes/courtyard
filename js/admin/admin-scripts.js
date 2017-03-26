/**
 *
 * Theme Admin enhancements for a better user experience.
 */
jQuery(document).ready( function() {
  jQuery('#page_template').change(function() {
    jQuery('#page_layout').toggle(jQuery(this).val() != 'page-templates/template-front-page.php');
    jQuery('#service_icon').toggle(jQuery(this).val() == 'page-templates/template-services.php');
    jQuery('#room_related_post').toggle(jQuery(this).val() == 'page-templates/template-rooms.php');
  }).change();
});
