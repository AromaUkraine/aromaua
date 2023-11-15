<div class="{{ $options['fieldset-class'] ?? '' }}">
    @if($label) <label for="{{ $setId() }}">{{$label}} @isset($options['required']) * @endisset </label> @endif
    <fieldset class="form-group position-relative has-icon-left">
        <input
            type="text"
            id="{{ $setId() }}"
            data-start="{{ $setDate('start') }}"
            data-end="{{ $setDate('end') }}"
            name="date_range"
            class="form-control datetimerangepicker"
            @isset($options['placeholder']) placeholder="{{ \StringHelper::upper($options['placeholder']) }}" @endisset
        >
        <div class="form-control-position">
            <i class="bx bx-calendar-check"></i>
        </div>
        <div class="col-10 float-left pl-0">
            @error( $name )
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
            @enderror
        </div>
        @if(!$errors->has($name) && isset($options['hint']))
            <div class="col-10 float-left pl-0">
                <small class="text-muted">{!! $options['hint'] !!}</small>
            </div>
        @endif
    </fieldset>
</div>

@push('scripts')
<script>

let daterangepicker = $("#" + '{{$setId()}}')
let start, end = null;

if(daterangepicker.data('start'))
    start = new Date(daterangepicker.data('start'));
if(daterangepicker.data('start'))
    end = new Date(daterangepicker.data('end'));

daterangepicker.daterangepicker({
    timePicker: true,
    timePicker24Hour:!0,
    timePickerSeconds:!0,
    startDate: start ?? Date.now,
    endDate: end ?? Date.now,
    locale: {
        format: 'DD.MM.YYYY H:mm:ss',
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    }
});
</script>
@endpush
