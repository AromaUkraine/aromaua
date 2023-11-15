@extends('layouts.cms')

{{ \Breadcrumbs::make([ 'last'=>[ 'name'=> __('cms.change_order') ] ]) }}

@section('actions')

    <x-cms-menu-frontend-add-tree
        model={{\Modules\Catalog\Entities\ProductCategory::class}}
    ></x-cms-menu-frontend-add-tree>

    <x-action
        href="{{ route('catalog.product_category.create') }}"
        class="success text-capitalize mr-1"
        title="{{__('cms.buttons.create')}}"
        icon="bx bx-plus"></x-action>
    <x-action
        href="{{ route('catalog.product_category.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>

@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <x-card expand>

                <div class="row mb-3 ">
                    <div class="col-6"><a href="#" class="anchor" onclick="jstreeToggleState(this)" >
                            <span style="display: none;">Развернуть</span> <span >Свернуть</span> <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <div class="col-6">
                        <x-input  name="element_search" class="form-control-sm col-sm-3 float-right mt-1" placeholder="{{__('cms.search')}}" ></x-input>
                    </div>
                </div>
                <div id="category-nested-tree" data-class="{{\Modules\Catalog\Entities\ProductCategory::class}}"></div>

            </x-card>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        let container = $('#category-nested-tree');
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
                                data: {node, parent, position, 'model':'product_categories', 'class': container.data('class')},
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
                    'url': '{{route(\Request::route()->getName(),['parent_id'=>0])}}',
                    'success': function(res){
                        $.loader('hide');
                        return res;
                    }
                },
                'strings':{
                    'Loading ...' : ''
                },
            },
            "dnd" : {
                "is_draggable" : function(node) {
                    //остановить движение ноды
                    // console.log('is_draggable called: ', node[0]);
                    // if (node[0].type != 'MY-DRAGGABLE-TYPE') {
                    //     alert('this type is not draggable');
                    //     return false;
                    // }
                    return true;
                }
            },
            "search": {
                "show_only_matches": true
            }
        });

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
