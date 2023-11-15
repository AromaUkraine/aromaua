"use strict";

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