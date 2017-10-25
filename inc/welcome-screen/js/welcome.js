
;(function($) {

    $('.courtyard-tab-nav a').on('click',function (e) {
        e.preventDefault();
        $(this).addClass('active').siblings().removeClass('active');
    });

    $('.courtyard-tab-nav .begin').on('click',function (e) {
        $('.courtyard-tab-wrapper .begin').addClass('show').siblings().removeClass('show');
    });
    $('.courtyard-tab-nav .actions, .courtyard-tab .actions').on('click',function (e) {
        e.preventDefault();
        $('.courtyard-tab-wrapper .actions').addClass('show').siblings().removeClass('show');

        $('.courtyard-tab-nav a.actions').addClass('active').siblings().removeClass('active');

    });
    $('.courtyard-tab-nav .support').on('click',function (e) {
        $('.courtyard-tab-wrapper .support').addClass('show').siblings().removeClass('show');
    });
    $('.courtyard-tab-nav .free-vs-pro').on('click',function (e) {
        $('.courtyard-tab-wrapper .free-vs-pro').addClass('show').siblings().removeClass('show');
    });
    $('.courtyard-tab-nav .changelog').on('click',function (e) {
        $('.courtyard-tab-wrapper .changelog').addClass('show').siblings().removeClass('show');
    });


    $('.courtyard-tab-wrapper .install-now').on('click',function (e) {
        $(this).replaceWith('<p style="color:#23d423;font-style:italic;font-size:14px;">Plugin installed and active!</p>');
    });
    $('.courtyard-tab-wrapper .install-now.importer-install').on('click',function (e) {
        $('.importer-button').show();
    });


})(jQuery);
