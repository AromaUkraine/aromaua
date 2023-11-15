"use strict";

/* ========== for only IE ========== */
$('.blog-article').each(function (indx, article) {
  var container = $('<div class="blog-article__content"/>');
  $(article).find('.blog-article__head').appendTo(container);
  $(article).find('.blog-article__text').appendTo(container);
  $(article).find('.blog-article__readmore').appendTo(container);
  container.appendTo(article);
});