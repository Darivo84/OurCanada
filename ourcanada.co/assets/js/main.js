$(function () {
    "use strict";
    $(window).on("load", function (o) {
        $("#preloader").delay(500).fadeOut(500)
    }), $("header .main-mneu").meanmenu({
        meanMenuContainer: ".mobilemenu",
        meanScreenWidth: "991",
        meanRevealPosition: "right"
    });
    var o = $("header").height();
    $(".main-mneu ul, .mobilemenu ul").onePageNav({
        currentClass: "active",
        scrollOffset: o
    }), $(".off-canver-menu").on("click", function (o) {
        o.preventDefault(), $(".off-canvas-wrap").addClass("show-off-canvas"), $(".overly").addClass("show-overly")
    }), $(".off-canvas-close").on("click", function (o) {
        o.preventDefault(), $(".overly").removeClass("show-overly"), $(".off-canvas-wrap").removeClass("show-off-canvas")
    }), $(".overly").on("click", function (o) {
        $(this).removeClass("show-overly"), $(".off-canvas-wrap").removeClass("show-off-canvas")
    }), $(window).on("scroll", function (o) {
        $(window).scrollTop() < 110 ? $("header").removeClass("sticky") : $("header").addClass("sticky")
    }), $(".search-icon").on("click", function (o) {
        o.preventDefault(), $(".search-form").toggleClass("show-search")
    }), (new WOW).init(), $(window).on("scroll", function () {
        var o = $(window).scrollTop();
        o > 300 && $(".go-top").addClass("active"), o < 300 && $(".go-top").removeClass("active")
    }), $(".go-top").on("click", function () {
        $("html, body").animate({scrollTop: "0"}, 1200)
    })
});