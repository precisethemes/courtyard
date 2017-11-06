
jQuery( function($) {
    $('ul.about-theme-tab-nav li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.about-theme-tab-nav li').removeClass('active');
        $('.about-theme-tab').removeClass('active');

        $(this).addClass('active');
        $("#" + tab_id).addClass('active');
    });
});
