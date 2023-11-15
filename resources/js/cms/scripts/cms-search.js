(function (window, document, $) {
    'use strict';

    let cmsSearch = $(".search-input input")[0];

    $(cmsSearch).on('input', function(){

        if($(this).val().length >= 3){

            var data = {
                url: $(this).data('href'),
                data: {search: $(this).val()},
                type:'get',
                dataType: 'json'
            }

            $.sendAjax(data, function(response){
                if(response.result.length){
                    serchResult(response.result);
                }
                console.log(response);
            })
        }
    })

    let serchResult = function(arrList){
        var $arrList = '';
        $("ul.search-list li").remove();

        for (var i = 0; i < arrList.length; i++) {

            $arrList += `<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                            <a class="d-flex align-items-center justify-content-between w-100" href="${arrList[i].route}">
                                <div class="d-flex justify-content-start">
                                <span class="mr-75 ${arrList[i].icon}" data-icon="${arrList[i].icon}">
                                </span><span>${arrList[i].name}</span>
                                </div>
                            </a>
                        </li>`
        }

    $("ul.search-list").append($arrList)
 }


})(window, document, jQuery);

