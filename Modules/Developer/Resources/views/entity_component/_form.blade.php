
<x-input
    :model="$item"
    label="Имя таблицы"
    name="table"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Имя таблицы записи в БД к которой крепится компонент (например articles к ней крепится галлерея)',
    'required'=>true ]) !!}"
></x-input>
<br>
<x-input
    :model="$item"
    label="Путь к модели"
    name="model"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Полный путь к модели записи к которой прикреплен компонент. Например : Modules\Article\Entities\Article',
    'required'=>true ]) !!}"
></x-input>
<br>

<x-input
    :model="$item"
    label="Имя роута к компоненту "
    name="slug"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Дефолтное имя роута для перехода к компоненту (например module.gallery.index для перехода к галлереи записи).',
    'required'=>true
    ]) !!}"
></x-input>
<br>
<x-input
    :model="$item"
    label="Роут записи без action"
    name="route_key"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Имя роута без action для возвращения назад к записи из компонента (например module.article для возвращения назад к статье из компонента).',
    'required'=>true
    ]) !!}"
></x-input>
<br>
<x-input
    :model="$item"
    label="Метод в модели связывающий компонент и запись"
    name="relation"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Имя метода в модели записи связывающий запись и ее компонент (нужен для того чтобы при удалении записи удалялись и ее компоненты).
    При удалении использую DestroyEntityEvent который удаляет страницу записи, компоненты записи (если они есть) и саму запись.',
    'required'=>true
    ]) !!}"
></x-input>

<br>
<x-input
    :model="$item"
    label="Название пункта в меню"
    name="name"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Ключ перевода для названия пукта в меню у записи (например сms.gallery).',
    'required'=>true ]) !!}"
></x-input>
<br>
<x-input
    :model="$item"
    label="Иконка"
    name="icon"
    options="{!! json_encode(['maxlength'=>255,
    'hint'=>'Иконка для пункта в меню, полное имя (например fa fa-cog).']) !!}"
></x-input>

@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('developer.module.index') }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection
