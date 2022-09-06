/*=====================
     17.filter sidebar js
     ==========================*/
$('.sidebar-popup').on('click', function(e) {
    $('.open-popup').toggleClass('open');
    $('.collection-filter').css("left", "-15px");
});
$('.filter-btn').on('click', function(e) {
    $('.collection-filter').css("left", "-15px");
});
$('.filter-back').on('click', function(e) {
    $('.collection-filter').css("left", "-365px");
    $('.sidebar-popup').trigger('click');
});

$('.account-sidebar').on('click', function(e) {
    $('.dashboard-left').css("left", "0");
});
$('.filter-back').on('click', function(e) {
    $('.dashboard-left').css("left", "-365px");
});

/*=====================
   16 .category page
   ==========================*/
$('.collapse-block-title').on('click', function(e) {
    e.preventDefault;
    var speed = 300;
    var thisItem = $(this).parent(),
        nextLevel = $(this).next('.collection-collapse-block-content');
    if (thisItem.hasClass('open')) {
        thisItem.removeClass('open');
        nextLevel.slideUp(speed);
    } else {
        thisItem.addClass('open');
        nextLevel.slideDown(speed);
    }
});