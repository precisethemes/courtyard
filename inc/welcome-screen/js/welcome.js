
;(function($) {

    $('.envy-blog-tab-nav a').on('click',function (e) {
        e.preventDefault();
        $(this).addClass('active').siblings().removeClass('active');
    });

    $('.envy-blog-tab-nav .begin').on('click',function (e) {
        $('.envy-blog-tab-wrapper .begin').addClass('show').siblings().removeClass('show');
    });
    $('.envy-blog-tab-nav .actions, .envy-blog-tab .actions').on('click',function (e) {
        e.preventDefault();
        $('.envy-blog-tab-wrapper .actions').addClass('show').siblings().removeClass('show');

        $('.envy-blog-tab-nav a.actions').addClass('active').siblings().removeClass('active');

    });
    $('.envy-blog-tab-nav .support').on('click',function (e) {
        $('.envy-blog-tab-wrapper .support').addClass('show').siblings().removeClass('show');
    });
    $('.envy-blog-tab-nav .free-vs-pro').on('click',function (e) {
        $('.envy-blog-tab-wrapper .free-vs-pro').addClass('show').siblings().removeClass('show');
    });
    $('.envy-blog-tab-nav .changelog').on('click',function (e) {
        $('.envy-blog-tab-wrapper .changelog').addClass('show').siblings().removeClass('show');
    });


    $('.envy-blog-tab-wrapper .install-now').on('click',function (e) {
        $(this).replaceWith('<p style="color:#23d423;font-style:italic;font-size:14px;">Plugin installed and active!</p>');
    });
    $('.envy-blog-tab-wrapper .install-now.importer-install').on('click',function (e) {
        $('.importer-button').show();
    });


})(jQuery);
