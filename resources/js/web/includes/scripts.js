"use strict";

$(function(){


    /* ========== open youtybe ========== */
    $('.js-popup-youtube').magnificPopup({
        type: 'iframe',
        iframe: {
            patterns: {
                youtube: {
                    index: 'youtube.com/',
                    id: 'v=',
                    src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0'
                }
            }
        },
        closeMarkup: '<button class="mfp-close mfp-close--icon" type="button" title="Закрыть (Esc)"></button>'
    });


    /* ========== gallery ========== */

    function openLightGallery(container) {
        container.lightGallery({
            selector: '.gallery__link',
            loop: true,
            thumbnail: false,
            download: false,
            zoom: false,
            autoplayControls: false,
            autoplay: false,
            fullScreen: false,
            hideControlOnEnd: false
        });
    }

    openLightGallery($('.js-gallery'));

    /* ========== main slider ========== */
    $('#js-main-slider').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 4000,
        pauseOnHover: true,
        pauseOnDotsHover: true,
        infinite: true,
        cssEase: 'linear',
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    /* ========== menu ========== */
    // open the menu on mobile
    $('button#js-hamburger').on('click', function () {
        $('nav#js-menu').slideToggle(200);
        $(this).toggleClass('hamburger--active');
        $('body').toggleClass('body--lock');
    }); // open dropdown

    $('.js-menu-btn').on('click', function () {
        $(this).closest('.open').find('.open').not($(this).next()).removeClass('open');
        $(this).next().toggleClass('open');
        $(this).closest('.open').find('.active').not($(this).parent()).removeClass('active');
        $(this).parent().toggleClass('active');
    }); // nav close by clicking on document

    $(document).on('click', function (e) {
        var menu = $('nav.menu'),
            hamburger = $('button.hamburger');

        if (!menu.is(e.target) && menu.has(e.target).length === 0 && !hamburger.is(e.target) && hamburger.has(e.target).length === 0) {
            menu.find('.submenu').removeClass('open');
            menu.find('.submenu-2').removeClass('open');
            menu.find('.menu__item').removeClass('active');
            menu.find('.submenu__item').removeClass('active');
            menu.find('.submenu-2__item').removeClass('active');
            hamburger.removeClass('hamburger--active');
        }
    });

    $('.js-filter-btn-toggle').on('click', function () {
        $(this).toggleClass('open').next().slideToggle(150);
    }); // select tags

})

