@extends('layouts.cms')

@section('actions')
    <x-action
        href="{{ route('developer.module.index') }}"
        class="light text-capitalize"
        title="{{__('cms.buttons.list')}}"
        icon="bx bx-list-ul"></x-action>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 ">
            <x-card>
                <div class="row ">
                    <div class="col-md-3">

                        @foreach($types as $type)
                            <label for="{{$type}}">{{$type}}</label>
                        <ul class="nav nav-pills flex-column text-center text-md-left">
                            @foreach($modules as $item)
                                    @if($item['type'] == $type)
                                <li class="nav-item"  >
                                    <a class="nav-link "  href="{{route('developer.module.create', $item['alias'])}}">
                                        <span> {{  $item['name'] }} <small>({{$item['alias']}})</small></span>
                                    </a>
                                </li>
                                    @endif
                            @endforeach
                        </ul>
                        @endforeach

                    </div>

                    <div class="col-md-9">

                        @if($module)
                            <x-form expand options="{!! json_encode(['route' => 'developer.module.store']) !!} ">

                                <x-input
                                    name="name"
                                    label="Название модуля"
                                    value="{{$module['name']}}"
                                    options="{!! json_encode([
                                        'maxlength'=>255,
                                        'hint'=>'Желательно создавать уникальное, отражающее смысл название.',
                                        'required' => true
                                        ]) !!} "
                                ></x-input>

                                <x-input
                                    name="alias"
                                    value="{{$module['alias']}}"
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
                                    value="{{$module['type']}}"
                                    options="{!! json_encode([
                                        'readonly' => true,
                                        ]) !!} "
                                ></x-input>

                                <x-textarea
                                    name="description"
                                    label="Описание модуля"
                                    value="{{$module['description']}}"
                                >
                                </x-textarea>



                                {{--  Заменить как будет время  --}}
                                @isset($module['routes'])
                                    <textarea name="data[routes]" class="form-control my-2 routes" style="min-height: 300px"  id="" >{!! json_encode($module['routes'])  !!} </textarea>
                                @endisset
                                @isset($module['cms_navigation'])
                                    <textarea name="data[cms_navigation]" class="form-control my-2 navigation" style="min-height: 150px" id="" >{!! json_encode($module['cms_navigation'])  !!} </textarea>
                                @endisset
                                {{--  /Заменить как будет время  --}}



                                @isset($module['config'])
                                <div class="form-group repeater-config mb-5">
                                    <label for="">Config</label>
                                    <div class="col-md-2 offset-md-10 form-group col-12">
                                        <button class="btn btn-icon rounded-circle btn-success" type="button" data-repeater-create="" style="margin-left: 7px">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                        <span class="ml-1 font-weight-bold text-success">ADD</span>
                                    </div>
                                    <div data-repeater-list="data[config]">
                                        @foreach($module['config'] as $key=>$value)
                                            <div data-repeater-item>
                                                <div class="row justify-content-between">
                                                    <div class="col-md-4 col-sm-12 form-group">
                                                        <label for="label">Key </label>
                                                        <input type="text" class="form-control"  name="key" value="{{ $key }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 form-group">
                                                        <label for="icon">Value </label>
                                                        <input type="text" class="form-control"  name="value" value="{{ $value }}">
                                                    </div>
                                                    <div class="col-md-2 col-12 mt-2 form-group">
                                                        <button class="btn btn-icon btn-danger rounded-circle" type="button" data-repeater-delete="">
                                                            <i class="bx bx-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endisset



                                @section('form-buttons')
                                    <x-button
                                        type="submit"
                                        class="primary text-capitalize mr-1"
                                        title="{{__('cms.buttons.save')}}"
                                    ></x-button>
                                    <x-action
                                        href="{{ route('developer.module.index') }}"
                                        class="light text-capitalize "
                                        title="{{__('cms.buttons.cancel')}}"
                                    ></x-action>
                                @endsection
                            </x-form>
                        @endif
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection


@push('scripts')

    <script>
        $.fn.json_beautify = function() {
            if(typeof this.val() !== typeof undefined){
                var obj = JSON.parse( this.val() );
                var pretty = JSON.stringify(obj, undefined, 4);
                this.val(pretty);
            }
        };
        $('.routes').json_beautify();
        $('.navigation').json_beautify();
    </script>
    <script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script>

        $(document).ready(function () {
            $(".repeater-config").repeater({
                show: function () {
                    $(this).slideDown()
                }, hide: function (e) {
                    confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
                }
            })
        });
    </script>
@endpush
