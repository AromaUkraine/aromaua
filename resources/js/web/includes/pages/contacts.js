"use strict";

/* ========== google maps ========== */
function initMap() {
  var ukr = {
    lat: 46.94022295344001,
    lng: 32.03840236244414
  };
  var arm = {
    lat: 55.685706098022436,
    lng: 37.736248948890314
  };
  var rus = {
    lat: 55.685706098022436,
    lng: 37.736248948890314
  };
  var map1 = new google.maps.Map(document.getElementById('map-ukr'), {
    zoom: 17,
    center: ukr
  });
  var marker1 = new google.maps.Marker({
    position: ukr,
    map: map1,
    title: 'пр. Октябрьский, 47/3. Центральный офис ООО "РосКосметика"'
  });
  var map2 = new google.maps.Map(document.getElementById('map-arm'), {
    zoom: 17,
    center: arm
  });
  var marker2 = new google.maps.Marker({
    position: arm,
    map: map2,
    title: 'ул. Люблинская, 42, офис 111'
  });
  var map3 = new google.maps.Map(document.getElementById('map-rus'), {
    zoom: 17,
    center: rus
  });
  var marker2 = new google.maps.Marker({
    position: rus,
    map: map3,
    title: 'ул. Люблинская, 42, офис 111'
  });
}

google.maps.event.addDomListener(window, 'load', initMap);
/* ========== tabs  ========== */

$('.js-tabs__nav').on('click', 'li.js-tabs__nav-item:not(.js-tabs__-item--active)', function () {
  $(this).addClass('js-tabs__nav-item--active').siblings().removeClass('js-tabs__nav-item--active').closest('.js-tabs').find('.js-tabs__content-item').fadeOut().removeClass('js-tabs__content-item--active').eq($(this).index()).fadeIn().addClass('js-tabs__content-item--active');
});