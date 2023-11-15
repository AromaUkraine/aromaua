window._ = require('lodash');


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    /* =============== Libs =============== */

    // bootstrap
    require('bootstrap/js/src/tooltip');
    require('bootstrap/js/src/tab');
    require('bootstrap/js/src/popover');
    require('bootstrap/js/src/modal');
    require('../../bootstrap4-editable/js/bootstrap-editable')


    //datatable
    require('datatables.net-bs4');
    require('./scripts/datatables/buttons.server-side');

    // select2
    require('select2/dist/js/select2.full');
    // JQuery UI sortable
    require('jquery-ui/ui/widgets/sortable');

    //JSTree
    require('jstree/dist/jstree');
    require('jstree/src/jstree.dnd');
    require('./scripts/extensions/jstree-actions');

    //SweetAlert2 Popup alert (delete confirmation)
    window.Swal = require('./scripts/extensions/sweetalert2.all.min')
    require('./scripts/extensions/polyfill.min')

    //Toastr
    window.toastr = require('toastr');

    //bootstrap-touchspin - to number field
    require('bootstrap-touchspin/dist/jquery.bootstrap-touchspin');

    // PerfectScrollbar~
    require('perfect-scrollbar');


    // bootstrap-daterangepicker
    require('bootstrap-daterangepicker/daterangepicker');


    /* =============== Custom Js Scripts =============== */

    // calc, validation input string length
    require('./scripts/jQuery.maxlength');
    // sortable datatable
    require('./scripts/datatables/sortable');
    // file-manager drop-zone
    require('./scripts/jQuery.fmdropzone');
    // initialize scripts
    require('./scripts/scripts');
    //laravel filemanager add custom callback
    require('./scripts/lfm');
    //global serch items on cms
    require('./scripts/cms-search');


} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
// window.axios = require('axios');
// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
