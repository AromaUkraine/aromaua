(function (window, document, $) {
    'use strict';

    const body =  $('body');


    // Tooltip
    body.tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    // Simply page loader
        $.loader = function (stat) {
        var elem = $('#page-loader');
        if (stat === 'show')
            elem.show();
        if (stat === 'hide')
            elem.hide();
        if (stat === 'toggle')
            elem.toggle();
    }


    // Modal windows from confirm
    $.confirm = function ( data, callback ) {

        // console.log(data);
        Swal.fire({
            title: (data.title) ?? 'title',
            type: (data.type) ?? 'warning',
            html: (data.message) ?? 'message',
            showCancelButton: (data.showCancelButton) ?? true,
            confirmButtonColor: (data.confirmButtonColor) ?? '#d33',
            cancelButtonColor: (data.cancelButtonColor) ?? '#3085d6',
            confirmButtonText: (data.confirmButtonText) ?? 'Are you sure?',
            cancelButtonText: (data.cancelButtonText) ?? 'Cancel',
            confirmButtonClass: (data.confirmButtonClass) ?? 'btn btn-primary',
            cancelButtonClass: (data.cancelButtonClass) ?? 'btn btn-light ml-1',
            buttonsStyling: (data.buttonsStyling) ?? false,
        }).then(function (result) {
            callback(result.value);
        })
    }

    $.sendAjax = function( data, callback){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : (data.url) ?? "#",
            data: (data.data) ?? {},
            type : (data.type) ?? 'GET',
            beforeSend : (data.beforeSend) ?? $.loader('show'),
            dataType: (data.dataType) ?? 'text',
            success: function(response){
                // console.log(response);
                $.loader('hide')
                callback(response);
            },
            error: function(res){
                $.loader('hide')
                console.log(res);
                toastr.error('Server error ' + res.status, res.statusText )
            },
        })
    }

    /**** Advanced Filter ****/
    let advancedFilter = $(".advanced-filter");
    $('.advanced-filter-toggle').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(advancedFilter).toggleClass('open');
    });
    $('.advanced-filter-close').on('click', function () {
        $(advancedFilter).removeClass('open');
    });
    if ($('.advanced-filter-content').length > 0) {
        var customizer_content = new PerfectScrollbar('.advanced-filter-content', {
            wheelPropagation: false
        });
    }

})(window, document, jQuery);

