(function ($) {
  "user strict";

    $(window).on('load', function () {
        $('.preloader').fadeOut(1000);
            var img = $('.bg_img');
            img.css('background-image', function () {
            var bg = ('url(' + $(this).data('background') + ')');
            return bg;
        });
    });
    if ($(".countdown").length) {
        let endDate = $('.countdown').data('countdown');
        let counterElement = document.querySelector(".countdown");
        let myCountDown = new ysCountDown(endDate, function (remaining, finished) {
          let message = "";
          if (finished) {
            message = "Expired";
          } else {
            var re_days = remaining.totalDays;
            var re_hours = remaining.hours;
            message += re_days + "d " + " : ";
            message += re_hours + "h " + " : ";
            message += remaining.minutes +  "m " + " : ";
            message += remaining.seconds + "s";
          }
          counterElement.textContent = message;
        });
    }

    $('.banner-wrapper').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        items: 1,
        autoplay: true,
        margin: 30,
    })
    $('.partner-slider').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        items: 2,
        autoplay: true,
        margin: 15,
        responsive: {
          768: {
            items: 3,
            margin: 30,
          },
          992: {
            items: 4,
          },
          1200: {
            items: 6,
          }
        }
      })
    $("ul>li>.submenu").parent("li").addClass("menu-item-has-children");
    // drop down menu width overflow problem fix
    $('ul').parent('li').hover(function () {
    var menu = $(this).find("ul");
    var menupos = $(menu).offset();
    if (menupos.left + menu.width() > $(window).width()) {
        var newpos = -$(menu).width();
        menu.css({
        left: newpos
        });
    }
    }); 
    $("body").each(function () {
    $(this).find(".popup-image").magnificPopup({
        type: "image",
        gallery: {
        enabled: true
        }
    });
    });
    //Video Popup Youtube
    $('.popup-youtube').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false,
    disableOn: 300
    });
    //Popup Uploaded
    $('.popup-player').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: true,
        iframe: {
            markup: '<div class="mfp-iframe-scaler">'+
                    '<div class="mfp-close"></div>'+
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                    '</div>',
    
            srcAction: 'iframe_src',
            }
    });
    $('.menu li a').on('click', function (e) {
    var element = $(this).parent('li');
    if (element.hasClass('open')) {
        element.removeClass('open');
        element.find('li').removeClass('open');
        element.find('ul').slideUp(300, "swing");
    } else {
        element.addClass('open');
        element.children('ul').slideDown(300, "swing");
        element.siblings('li').children('ul').slideUp(300, "swing");
        element.siblings('li').removeClass('open');
        element.siblings('li').find('li').removeClass('open');
        element.siblings('li').find('ul').slideUp(300, "swing");
    }
    })
    // Scroll To Top 
    var scrollTop = $(".scrollToTop");
    $(window).on('scroll', function () {
    if ($(this).scrollTop() < 500) {
        scrollTop.removeClass("active");
    } else {
        scrollTop.addClass("active");
    }
    });
    //header
    var header = $("header");
    $(window).on('scroll', function () {
    if ($(this).scrollTop() < 1) {
        header.removeClass("active");
    } else {
        header.addClass("active");
    }
    });
    //Click event to scroll to top
    $('.scrollToTop').on('click', function () {
    $('html, body').animate({
        scrollTop: 0
    }, 500);
    return false;
    });
    //Header Bar
    $('.header-bar').on('click', function () {
        $(this).toggleClass('active');
        $('.menu-area').toggleClass('active');
    })
    $('.cross--btn').on('click', function () {
      $('.menu-area').removeClass('active');
      $('.header-bar').removeClass('active');
    })
    $('.open--sidebar').on('click', function () {
      $('.left-sidebar').addClass('active');
    })
    $('.close--sidebar').on('click', function () {
      $('.left-sidebar').removeClass('active');
    })
    $('.faq__wrapper .faq__title').on('click', function (e) {
    var element = $(this).parent('.faq__item');
    if (element.hasClass('open')) {
        element.removeClass('open');
        element.find('.faq__content').removeClass('open');
        element.find('.faq__content').slideUp(200, "swing");
    } else {
        element.addClass('open');
        element.children('.faq__content').slideDown(200, "swing");
        element.siblings('.faq__item').children('.faq__content').slideUp(200, "swing");
        element.siblings('.faq__item').removeClass('open');
        element.siblings('.faq__item').find('.faq__title').removeClass('open');
        element.siblings('.faq__item').find('.faq__content').slideUp(200, "swing");
    }
    });
})(jQuery);