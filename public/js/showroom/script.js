window.pressed = function () {
    var uploadwrap = document.getElementById('upload');
    if (uploadwrap.value == "") {

    }
    else {

    }
};

$(document).ready(function () {

    $('.login_name').on('click', function (e) {
        e.stopPropagation();
        $('.login_dropdown').stop(0, 0).slideToggle();
    });

    $('.fltr_btn').on('click', function () {
        $('body,html').css("overflow", "hidden");
        $('body,html').css("position", "fixed");
        $('.left_side').addClass('show');
    });

    $('.left_side_close').on('click', function () {
        $('body,html').css("overflow", "auto");
        $('body,html').css("position", "static");
        $('.left_side').removeClass('show');
    });

    $('#pause').trigger('click');

    /* Dash Tabs */
    /*$(".dash_tabs a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".dash_tab").not(tab).css("display", "none");
        $(tab).fadeIn();
    });*/

    $(".car_listing a").click(function (event) {
        $('.right_loader').fadeIn();
        setTimeout(function () {
            $('.right_loader').fadeOut();
        }, 2000)
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".car_detail_wrap").not(tab).css("display", "none");
        $(tab).fadeIn();
    });


    /* FancyBox 3 */
    $('[data-fancybox]').fancybox({
        arrows: true,
        keyboard: true,
        infobar: true,
        loop: false,
        touch: false,
        // afterShow: function( instance, current ) {
        //   this.content.find('video').trigger('stop');
        // },

        buttons: [
            // 'slideShow',
            // 'fullScreen',
            // 'thumbs',
            'share',
            'download',
            // 'zoom',
            'close'
        ]
    });

});

$(document).on('click', function () {

    $('.login_dropdown').slideUp();

});


$(window).on("load", function () {

    var $grid = $('.grid').isotope({
        layoutMode: 'packery',
        itemSelector: '.grid-item',
        packery: {
            gutter: 0
        }

    });

    /* Car Slider */
    $('.car_slider_warap').slick({
        infinite: true,
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000
    });


});