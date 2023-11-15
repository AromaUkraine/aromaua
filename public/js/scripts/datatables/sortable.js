$( ".sortable" ).sortable({
    items: "tr",
    cursor: 'move',
    opacity: 0.6,
    helper: fixWidthHelper,
    update: function() {
        sendOrderToServer(this);
    },
});
function fixWidthHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
}
function sendOrderToServer(table) {
    let order = [];

    $('tr.row-sort').each(function(index,element) {
        order.push({
            id: $(this).attr('data-id'),
            order: index+1
        });
    });

    sendAjax(order, table)
}

function sendAjax(order, table) {
    let token = $('meta[name="csrf-token"]').attr('content');
    let model = $(table).attr('data-model');
    let tableId = $(table).attr('id');
    let url = $(table).attr('data-url');

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: {
            model: model,
            order: order,
            _token: token
        },
        success: function(response) {
            window.LaravelDataTables[tableId].ajax.reload();
        }
    });
}
