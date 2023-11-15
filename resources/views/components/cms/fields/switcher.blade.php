@if($languages)

    @foreach($languages as $lang)
        <div
            class="form-group lang @isset($options['maxlength']) maxlength @endisset"
            @if($lang->short_code !== $default_language) style="display: none"  @endif
            data-lang="{{$lang->short_code}}"
        >
            <div class="custom-control custom-switch custom-switch-success custom-control-inline ">
                <input type="checkbox"
                       id="switcher_{{ ($options['id']) ??  $lang->short_code.".".$name }}"
                       data-watch="{{$setName($lang->short_code)}}"
                       class="custom-control-input switcher"
                    {{ $isChecked($lang->short_code) ? 'checked' : ''  }}
                >
                <label class="custom-control-label" for="switcher_{{ ($options['id']) ??  $lang->short_code.".".$name }}">
                    <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                    <span class="switch-icon-right"><i class="bx bx-x"></i></span>
                </label>
                @isset($label)<span class="ml-2">{{ $label }} @isset($options['required']) * @endisset </span>@endisset
            </div>
            <input type="hidden"  name="{{ $setName($lang->short_code) }}" value="{{ $isChecked($lang->short_code) }}">
        </div>

    @endforeach

@else
    <div class="form-group @isset($options['maxlength']) maxlength @endisset">
        <div class="custom-control custom-switch custom-switch-success custom-control-inline ">
            <input type="checkbox"
                   id="switcher_{{$name}}"
                   data-watch="{{$setName()}}"
                   class="custom-control-input switcher"
                {{ $isChecked() ? 'checked' : ''  }}
            >
            <label class="custom-control-label" for="switcher_{{$name}}">
                <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                <span class="switch-icon-right"><i class="bx bx-x"></i></span>
            </label>
            @isset($label)<span class="ml-2">{{ $label }} @isset($options['required']) * @endisset </span>@endisset
        </div>
        <input type="hidden"  name="{{ $setName() }}" value="{{ $isChecked() }}">
    </div>
@endif

@push('scripts')
    <script>
        $(function () {
            let switcher = $(".switcher");
            switcher.map( function (idx, item) {
                if($(item).is(':checked'))
                    $(item).val(1);
                else
                    $(item).val(0);
            })
            switcher.change(function() {
                let name = $(this).data('watch');
                if(this.checked) {
                    $(this).attr("checked",true).val(1);
                }else{
                    $(this).removeAttr('checked').val(0);
                }
                $(`input[name='${name}']`).val($(this).val())
            });
        })

    </script>
@endpush

