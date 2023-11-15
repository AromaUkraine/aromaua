
<div class="row mb-3 ">
    <div class="col-6"><a href="#" class="anchor" onclick="jstreeToggleState(this)" >
           <span style="display: none;">Развернуть все</span> <span >Свернуть все</span> <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <div class="col-6">
        <x-input  name="element_search" class="form-control-sm col-sm-3 float-right mt-1" placeholder="{{__('cms.search')}}" ></x-input>
    </div>
</div>
<div id="menu-nested-tree"></div>
<div id="test"></div>

@push('scripts')
    <script>
        let container = $('#menu-nested-tree');
        container.jstree({
            'plugins': [
                "dnd",  "actions", 'wholerow',
                "state", "types", "search"
            ],
            'core' : {
                "animation" : 0,
                "check_callback" : function (operation, node, parent, position, more) {
                    if(operation === "move_node") {
                        if(more.core) {
                            $.loader('show');
                            let sendData = {
                                url: '{{route("move")}}',
                                data: {node, parent, position, 'model':'menu'},
                                type:'POST',
                                dataType:'json'
                            }
                            $.sendAjax(sendData, function(response){
                                $.loader('hide');
                                toastr.success(response.message, response.title);
                            })
                        }
                    }
                    return true;
                },
                "themes" : { "stripes" : false, "selected":false, responsive: true},
                'data': {
                    'beforeSend': function(){
                        $.loader('show');
                    },
                    'url': '{{route($route,['parent_id'=>0])}}',
                    'success': function(res){
                        console.log(res)
                        $.loader('hide');
                        return res;
                    }
                },
                'strings':{
                    'Loading ...' : ''
                },
            },
            "search": {
                "show_only_matches": true
            }
        });



        container.jstree(true).add_action("all", function() {
            return {
                "id": "data-create",
                "class": "btn btn-icon bx bx-plus rounded-circle btn-outline-primary mr-10 jstree-action",
                "after": true,
                'title': "{{__('cms.buttons.add')}}",
                "attributes":{
                    'data-toggle':'tooltip',
                },
                "selector": "a",
            }
        })

        container.jstree(true).add_action("all", function() {
            return {
                "id": "data-edit",
                "class": "btn btn-icon bx bx-paint rounded-circle btn-outline-primary mr-10 jstree-action",
                "after": true,
                'title': "{{__('cms.buttons.edit')}}",
                "attributes":{
                    'data-toggle':'tooltip',
                },
                "selector": "a",
            }
        })

        container.jstree(true).add_action("all", function() {

            return {
                "id": "data-active",
                "class": "btn btn-icon rounded-circle  mr-5 jstree-action",
                "classByCondition" : {
                    'attr':'active',
                    'class':{
                        1:'bx bx-show-alt btn-outline-success',
                        0:'bx bx-hide btn-outline-danger'
                    },
                },
                "attributes":{
                    'data-toggle':'tooltip',
                },
                'title':{
                    1:"{{__('cms.buttons.active')}}",
                    0: "{{__('cms.buttons.not_active')}}"
                },
                "after": true,
                "selector": "a",
                "event": "click",
                "callback": function (nodeId, node, actionId, actionElement) {
                    $.loader('show');
                    let sendData = {
                        url: actionElement.href,
                        type:'POST',
                        dataType:'json'
                    }
                    $.sendAjax(sendData, function(response){
                        $.loader('hide');
                        toastr.success(response.message, response.title);
                        container.jstree(true).refresh_node(node);
                    })
                }
            }
        })

        container.jstree(true).add_action("all", function(){

            return {
                "id": "data-delete",
                "class": "btn btn-icon bx bx-trash rounded-circle btn-outline-danger mr-1  jstree-action",
                "after": true,
                "selector": "a",
                'title': "{{__('cms.buttons.delete')}}",
                "attributes":{
                    'data-toggle':'tooltip',
                },
                "event": "click",
                "callback": function(nodeId, node, actionId, actionElement) {

                    Swal.fire({
                        title: " {{ __('datatable.delete.title') }}  ",
                        text: " {{ __('datatable.delete.text') }}  ",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: " {{ __('datatable.delete.confirmButtonText') }} ",
                        cancelButtonText: " {{ __('datatable.delete.cancelButtonText') }} ",
                        confirmButtonClass: 'btn btn-danger',
                        cancelButtonClass: 'btn btn-light ml-1',
                        buttonsStyling: false,
                    }).then(function (result) {

                        if(result.value){
                            $.loader('show');
                            let sendData = {
                                url: actionElement.href,
                                type:'DELETE',
                                dataType:'json'
                            }
                            $.sendAjax(sendData, function(response){
                                $.loader('hide');
                                toastr.success(response.message, response.title);
                                container.jstree(true).refresh();
                                // location.reload();
                            })
                        }
                    })

                }
            }
        });

        $("#element_search").on('change paste keyup input', function(){
            if($(this).val()){
                $('.anchor').hide()
            }else{
                $('.anchor').show()
            }
            container.jstree(true).search($(this).val());

        });


        var isTreeOpen = true;

        function jstreeToggleState(button) {
            $(button).find('i').toggleClass('fas fa-chevron-right fas fa-chevron-down');
            $(button).find('span').toggle();
            if(isTreeOpen){
                $(".jstree").jstree('close_all');
            }else{
                $(".jstree").jstree('open_all');
            }
            isTreeOpen =! isTreeOpen;
        }

    </script>
@endpush
