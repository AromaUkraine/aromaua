<x-slot name="title">Создать страницу из сео-страниц вне каталога</x-slot>

<x-select
    :model="$page"
    label="Выберите страницу"
    name="pageable_id"
    options="{!! json_encode( ['type'=>'select2', 'placeholder'=>__('cms.select.default')] ) !!}"
>
    @foreach($pages as $page)
        <option value="{{$page->pageable_id}}"  > {{ $page->name }} </option>
    @endforeach
</x-select>

<div class="form-group input">
    <label for="slug">Уникальный ключ </label>
    <input type="text" name="alias" id="slug" class="form-control">
</div>

<div class="form-group input">
    <label for="controller">{{__('cms.controller')}}</label>
    <input type="text" name="controller" id="controller" class="form-control">
</div>


@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('developer.seo_page.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection


@push('scripts')
    <script>
        let group = $('.form-group.input');
        group.hide();
        let slug = $('#slug');
        let controller = $('#controller');

        $('#pageable_id').select2({
            theme: 'bootstrap',
            width: '100%',
            placeholder: $('#pageable_id').attr('placeholder'),
            escapeMarkup: function(m) {
                return m;
            },
            allowClear: true,
        }).on("change", function (e) {
            group.hide();
            slug.val();
            controller.val();

           let data = {
               url : "{{route('seo_page_get')}}",
               data: {"pageable_id" : $(this).val()},
               'type':'POST',
               'dataType':'json'
           }
            $.sendAjax(data, function (response){
                slug.val(response.slug);
                controller.val(response.controller);
                group.show();
            });
        });
    </script>
@endpush
