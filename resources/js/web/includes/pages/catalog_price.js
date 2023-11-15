"use strict";

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
/* ========== simulated links for table tr ========== */

$('.price-table').on('click', 'tr[data-href]', function (e) {
  var url = $(this).data('href');

  if (url) {
    window.open(url, '_blank');
    window.focus();
  }
});