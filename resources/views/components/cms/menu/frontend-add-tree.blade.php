<button type="button" class="btn btn-outline-primary block  mr-1" data-toggle="modal" data-target="#border-less">
    {{__('cms.permission_frontend_menu')}}
</button>
@section('modal-content')
    {{ Form::open(['route'=>['root.frontend_menu.add_tree'] ,'id'=>'add-tree']) }}
    <div class="modal-header">
        <h3 class="modal-title">Добавить все элементы в меню </h3>
        <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="model" value="{{$model}}" />
        <input type="hidden" name="prev_root_id" value="{{$root->id ?? null}}" />

        <x-select
{{--            label="{{__('Добавить все элементы в меню')}}"--}}
            name="root_id"
            id="menu_tree"
            options="{!! json_encode(['type'=>'select2', 'placeholder'=>__('cms.select.default')]) !!}">
            @foreach($menu as $item)
                @include('components.cms.menu._options',['menu'=>$item, 'level'=>0])
            @endforeach
        </x-select>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light-primary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Отменить</span>
        </button>
        <button type="submit" class="btn btn-primary ml-1" >
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Добавить</span>
        </button>
    </div>
    {{ Form::close() }}
@endsection


@push('scripts')
    <script>

        $('#add-tree').submit(function (e){
            e.preventDefault();
            let formData = $(this).serialize();
            let data = {
                url:$(this).attr('action'),
                type:$(this).attr('method'),
                data: formData,
                dataType:'json'
            }

            $.sendAjax(data, function (response){

                 toastr.success(response.message, response.title);
            })
        })

    </script>
@endpush
