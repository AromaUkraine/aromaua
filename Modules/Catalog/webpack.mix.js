
const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setResourceRoot('../../resource').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', '/js/catalog.js')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'css/catalog.css');


if (mix.inProduction()) {
    mix.version();
}

