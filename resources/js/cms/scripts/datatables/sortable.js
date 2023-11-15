$( ".sortable" ).sortable({
    items: "tbody>tr",
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
    $.loader('show')

    $('tr.row-sort').each(function(index,element) {
        order.push({
            id: $(this).attr('data-id'),
            order: index+1
        });
    });

    let tableId = $(table).attr('id');
    let url = $(table).attr('data-url');

    let sendData = {
        url: url,
        data: { model:$(table).attr('data-model'), order: order},
        type:'POST',
        dataType:'json'
    }
    $.sendAjax(sendData, function(response){
        window.LaravelDataTables[tableId].ajax.reload();
        $.loader('hide');
        toastr.success(response.original.message, response.original.title);
    })
}
