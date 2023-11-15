"use strict";

/* ========== main slider ========== */
function mainSlider(elem) {
  elem.slick({
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
}

mainSlider($('#js-main-slider'));
/* ========== tabs  ========== */

$('.tabs__nav').on('click', 'li.tabs__nav-item:not(.tabs__nav-item--active)', function () {
  $(this).addClass('tabs__nav-item--active').siblings().removeClass('tabs__nav-item--active').closest('.tabs').find('.tabs__content-item').removeClass('tabs__content-item--active').eq($(this).index()).addClass('tabs__content-item--active');
});
/* ========== search ========== */
// open dropdown

$('.js-filter-btn-toggle').on('click', function () {
  $(this).toggleClass('open').next().slideToggle(150);
}); // select tags

function multiselect() {
  $('.js-filter-item-parent').each(function () {
    var that = $(this);
    var checkboxes = $(this).find('input.checkbox__input');
    checkboxes.each(function () {
      var checkbox = $(this);
      var tag = that.find("li.tag[data-index='" + $(this).data('index') + "']");

      if (checkbox.is(':checked')) {
        if (tag.length === 0) {
          var newTag = '<li class="tag show" data-index="' + $(this).data('index') + '">' + '<span class="tag__text">' + checkbox.siblings('.checkbox__text').text() + '</span>' + '<button class="tag__close" type="button">×</button></li>';
          that.find('.filter__tags').append(newTag);
        }
      } else {
        that.find("li.tag[data-index='" + $(this).data('index') + "']").remove();
      }
    });
  });
}

$('.filter-select__btn').on('click', function () {
  multiselect();
  $(this).closest('.filter-select__dropdown').slideUp(150);
  $(this).closest('.js-filter-item-parent').find('.js-filter-btn-toggle').removeClass('open');
}); // remove tags

$('.filter__tags').on('click', 'button.tag__close', function () {
  var indx = $(this).parent().data('index');
  var checkboxes = $(this).parent().closest('.js-filter-item-parent').find('.checkbox__input');
  checkboxes.each(function () {
    if ($(this).data('index') === indx) {
      $(this).prop('checked', false);
    }
  });
  $(this).parent().remove();
});
/* ========== forms ========== */
// inputMask

$('input[type="tel"]').inputmask(); // for focus on the desktop form

$('input.form__input').on('change', function () {
  if ($(this).val) {
    $(this).addClass('has-content');
  } else {
    $(this).removeClass('has-content');
  }
}); // demo validate form

$('#form_chouse').on('submit', function (e) {
  e.preventDefault();
  $(this).validate({
    rules: {
      chouse_name: 'required',
      chouse_phone: 'required'
    },
    messages: {
      chouse_name: 'Введите имя',
      chouse_phone: 'Введите номер'
    }
  });

  if ($(this).valid()) {
    // demo modal
    $.magnificPopup.open({
      items: {
        src: '#modal-successful'
      },
      showCloseBtn: false,
      type: 'inline',
      fixedBgPos: true,
      fixedContentPos: true,
      removalDelay: 500,
      midClick: true
    });
  }
});
$(document).on('click', '.modal__close', function () {
  $.magnificPopup.close();
});
/* ====================== js cropping string =========================== */

function croppingString(string, size) {
  var textStringAll = $(string);

  for (var i = 0; i < textStringAll.length; i++) {
    var textString = textStringAll[i];
    var text = textString.innerText;

    if (text.length > size) {
      textString.innerText = text.slice(0, size) + ' ...';
    }
  }
}

croppingString('.prev-news__text', 118);
