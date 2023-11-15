 const mix = require('laravel-mix');
 require('laravel-mix-alias');
 mix.alias('@', '/resources/js/web/vue/src/');




 /*----------------------------------------*/
 mix.js('resources/js/web/web.js', 'public/js')
     .sass('resources/sass/web/web.scss', 'public/css');



 mix.js('resources/js/cms/cms.js', 'public/js')
     .sass('resources/sass/cms/cms.scss', 'public/css')


 // mix.copyDirectory('resources/images', 'public/images');
 // mix.copyDirectory('resources/vendors', 'public/vendors');
 // mix.copyDirectory('resources/fonts', 'public/fonts');
 //
 // mix.copy('resources/js/cms/scripts/pickers/pickadate/picker.js', 'public/js/scripts/pickers/pickadate/picker.js');
 // mix.copy('resources/js/cms/scripts/pickers/pickadate/picker.date.js', 'public/js/scripts/pickers/pickadate/picker.date.js');
 // mix.copy('resources/js/cms/scripts/pickers/pickadate/picker.time.js', 'public/js/scripts/pickers/pickadate/picker.time.js');
 // mix.copy('resources/js/cms/scripts/pickers/pickadate/legacy.js', 'public/js/scripts/pickers/pickadate/legacy.js');
 // mix.copyDirectory('resources/js/cms/scripts/pickers/pickadate/translations', 'public/js/scripts/pickers/pickadate/translations');
 // mix.copy('resources/sass/cms/pickers/pickadate/pickadate.css', 'public/css/pickers/pickadate/pickadate.css');
 //
 //
 // mix.copyDirectory('node_modules/tinymce/icons', 'public/tinymce/icons');
 // mix.copyDirectory('node_modules/tinymce/plugins', 'public/tinymce/plugins');
 // mix.copyDirectory('node_modules/tinymce/skins', 'public/tinymce/skins');
 // mix.copyDirectory('node_modules/tinymce/themes', 'public/tinymce/themes');
 // mix.copyDirectory('resources/tinymce/langs', 'public/tinymce/langs');
 //
 // mix.copy('node_modules/tinymce/jquery.tinymce.js', 'public/tinymce/jquery.tinymce.js');
 // mix.copy('node_modules/tinymce/jquery.tinymce.min.js', 'public/tinymce/jquery.tinymce.min.js');
 // mix.copy('node_modules/tinymce/tinymce.js', 'public/tinymce/tinymce.js');
 // mix.copy('node_modules/tinymce/tinymce.min.js', 'public/tinymce/tinymce.min.js');


 // mix.disableNotifications();



 if (mix.inProduction()) {
     mix.version();
 }
