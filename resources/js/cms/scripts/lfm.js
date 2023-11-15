let iframe, iframeDoc = null;

window.lfm = function(idZone, idInput, type,  options) {
    let zone = document.getElementById(idZone);

    zone.addEventListener('click', function () {
        
        let popup = 'width=' + (screen.width * 0.8);
        popup += ', height=' + (screen.height * 0.8);
        popup += ', top=' + (screen.height * 0.1);
        popup += ', left=' + (screen.height * 0.1);

        window.open(route_prefix + '?type='+type + '&multiple=0', 'FileManager', popup);

        window.SetUrl = function (items) {
            var file_path = [];
            items.map(function (item) {
                var url = item.url.replace(window.location.protocol + '//' + window.location.host + "/", "/");
                file_path.push(url);
            });
            $('#'+idInput).val(JSON.stringify(file_path));
            window.fm_callback(idInput);
        };
    });
};



function getUrlParam(paramName) {
    var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
    var match = $(iframe).attr('src').match(reParam);
    return(match && match.length > 1) ? match[1] : null;
}

/**
     *  Change type files
     */
 $('.show').on('click', function(){
    let type = $(this).hasClass('images') ? 'images' : $(this).hasClass('files') ? 'files' : 'images'; 
    $('#lfm').attr('src', $('#lfm').data('url') + '?type=' + type);
})

log(iframe.document)