"use strict";

/* ========== jQuery ========== */
(function ($) {
  $(function () {
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
    /* ========== forms ========== */
    // for focus on the desktop form

    $('input.form__input').on('change', function () {
      if ($(this).val) {
        $(this).addClass('has-content');
      } else {
        $(this).removeClass('has-content');
      }
    });
    /* ========== svg4everybody adds SVG External Content support to all browsers ========== */

    svg4everybody({});

    /* ========== hack for IE 11 ========== */

    function ieObjectFit() {
      $('.ie').each(function (indx, wrapImg) {
        if ($(wrapImg).find('img').length > 0) {
          $(wrapImg).css('background-image', 'url(' + $(wrapImg).find('img').attr('src') + ')');
        }
      });
    }

    if (!Modernizr.objectfit) {
      ieObjectFit();
    }
  }); // end DOM ready
})(jQuery); // end jQuery
