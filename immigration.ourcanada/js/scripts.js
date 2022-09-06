jQuery(function (t) {
    "use strict";
    t(window).ready(function () {
        t("#preloader").delay(200).fadeOut("fade")
    }), t(window).on("scroll", function () {
        t(this).scrollTop() > 60 ? (t(".navbar").addClass("affix"), t(".scroll-to-target").addClass("open")) : (t(".navbar").removeClass("affix"), t(".scroll-to-target").removeClass("open"))
    }), t(".scroll-to-target").length && t(".scroll-to-target").on("click", function () {
        var o = t(this).attr("data-target");
        t("html, body").animate({scrollTop: t(o).offset().top}, 500)
    });
    var o = !0, n = t(".single-counter > h3, .single-card > h3");
    if (n.length) {
        var a = n.offset().top - window.innerHeight;
        a > 0 ? t(window).on("scroll", function () {
            o && t(window).scrollTop() > a && (startCounting(), o = !1)
        }) : startCounting()
    }
    new WOW({offset: 100, mobile: !0}).init()
});