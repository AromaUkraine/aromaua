<x-input
    :model="$module"
    label="Название модуля"
    name="name"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('menu.name'), 'required'=>true ]) !!}"
></x-input>

<x-input
    name="alias"
    :model="$module"
    label="Уникальный ключ"
    options="{!! json_encode([
        'required' => true,
        'maxlength'=>255,
        ]) !!} "
></x-input>

<x-input
    name="type"
    label="Тип"
    :model="$module"
    options="{!! json_encode([
        'readonly' => true,
        ]) !!} "
></x-input>

<x-textarea
    name="description"
    label="Описание модуля"
    :model="$module"
>
</x-textarea>


{{--  Заменить как будет время  --}}
@isset($module->routes)
    <textarea name="data[routes]" class="form-control json my-2" style="min-height: 400px"  id="" >{!! json_encode($module->routes)  !!} </textarea>
@endisset
@isset($module->data['cms_navigation'])
    <textarea name="data[cms_navigation]" class="form-control nav-json my-2" style="min-height: 150px"  id="" >{!! json_encode($module->data['cms_navigation'])  !!} </textarea>
@endisset
{{--  /Заменить как будет время  --}}

{{--<div class="form-group repeater-config mb-5">--}}
{{--    <label for="">Config</label>--}}
{{--    <div class="col-md-2 offset-md-10 form-group col-12">--}}
{{--        <button class="btn btn-icon rounded-circle btn-success" type="button" data-repeater-create="" style="margin-left: 7px">--}}
{{--            <i class="bx bx-plus"></i>--}}
{{--        </button>--}}
{{--        <span class="ml-1 font-weight-bold text-success">ADD</span>--}}
{{--    </div>--}}
{{--    <div data-repeater-list="data[config]">--}}

{{--        @foreach($module->data['config'] as $key=>$value)--}}
{{--            <div data-repeater-item>--}}
{{--                <div class="row justify-content-between">--}}
{{--                    <div class="col-md-4 col-sm-12 form-group">--}}
{{--                        <label for="label">Key </label>--}}
{{--                        <input type="text" class="form-control"  name="key" value="{{ $key }}">--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4 col-sm-12 form-group">--}}
{{--                        <label for="icon">Value </label>--}}
{{--                        <input type="text" class="form-control"  name="value" value="{{ $value }}">--}}
{{--                    </div>--}}
{{--                    <div class="col-md-2 col-12 mt-2 form-group">--}}
{{--                        <button class="btn btn-icon btn-danger rounded-circle" type="button" data-repeater-delete="">--}}
{{--                            <i class="bx bx-x"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}

{{--    </div>--}}
{{--</div>--}}

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



@push('scripts')
    <script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script>

        $.fn.json_beautify= function() {
            console.log(this);
            if(typeof this.val() !== typeof undefined) {
                var obj = JSON.parse( this.val() );
                var pretty = JSON.stringify(obj, undefined, 4);
                this.val(pretty);
            }
        };

        // Then use it like this on any textarea
        $('.json').json_beautify();
        $('.nav-json').json_beautify();

        $(document).ready(function () {
            $(".repeater-navigation").repeater({
                show: function () {
                    $(this).slideDown()
                }, hide: function (e) {
                    confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
                }
            })
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













