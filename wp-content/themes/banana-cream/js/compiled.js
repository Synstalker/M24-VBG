'use strict';

$ = $ || jQuery;
window.BananaCream = {

    load_img_fallbacks: function load_img_fallbacks() {
        $('img[src]').on('error', function () {
            $(this).removeAttr('srcset');
            $(this).attr('src', '/wp-content/themes/banana-cream/images/missing.svg');
        });
    },

    masonry_loading_classes: function masonry_loading_classes() {
        $('[data-uk-grid]').on('beforeupdate.uk.grid', function (e, children) {
            $(this).addClass('busy');
        });

        $('[data-uk-grid]').on('afterupdate.uk.grid', function (e, children) {
            $(this).removeClass('busy');
        });
    },

    init: function init() {
        this.load_img_fallbacks();
        this.masonry_loading_classes();
    }

};

$(function () {
    BananaCream.init();
});
