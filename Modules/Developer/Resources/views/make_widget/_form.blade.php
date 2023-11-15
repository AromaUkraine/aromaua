<x-select
name="page_id"
label="Выберите страницу"
options="{!! json_encode(['type'=>'select2', 'required'=>true, 'placeholder'=>__('cms.select.default')]) !!}"
>
    @foreach($pages as $item)
        <option value="{{$item->id}}">{{$item->name}}</option>
    @endforeach
</x-select>


<x-input
    name="name"
    label="Название виджета"
    value="{{$data['name']}}"
    options="{!! json_encode([
        'maxlength'=>255,
        'hint'=>'Желательно создавать уникальное, отражающее смысл название.',
        'required' => true
        ]) !!} "
></x-input>

<x-input
    name="alias"
    value="{{$data['alias']}}"
    label="Уникальный ключ "
    options="{!! json_encode([
        'required' => true,
        'maxlength'=>255,
        'hint'=>'Необходим для виджетов.'
        ]) !!} "
></x-input>

<x-input
    name="type"
    label="Тип"
    value="{{$data['type']}}"
    options="{!! json_encode([
        'readonly' => true,
        ]) !!} "
></x-input>

<x-textarea
    name="description"
    label="Описание модуля"
    value="{{$data['description']}}"
>
</x-textarea>

{{--  Заменить как будет время  --}}
@isset($data['routes'])
    <textarea name="data[routes]" class="form-control my-2 routes" style="min-height: 300px"
              id="">{!! json_encode($data['routes'])  !!} </textarea>
@endisset
@isset($data['cms_navigation'])
    <textarea name="data[cms_navigation]" class="form-control my-2 navigation" style="min-height: 150px"
              id="">{!! json_encode($data['cms_navigation'])  !!} </textarea>
@endisset

{{--  /Заменить как будет время  --}}
@section('form-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('developer.seo_page.index') }}"
        class="light text-capitalize "
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection





