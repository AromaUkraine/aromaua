
<div class="form-group repeater-{{$getId()}}">

    <div class="col-md-2 offset-md-10 form-group col-12">
        <button class="btn btn-icon rounded-circle btn-success" type="button" data-repeater-create="" style="margin-left: 7px">
            <i class="bx bx-plus"></i>
        </button>
        <span class="ml-1 font-weight-bold text-success">ADD</span>
    </div>

    <div data-repeater-list="data[routes][{{$getId()}}]">

        @foreach($jsonData as $element)
        <div data-repeater-item>
            <div class="row justify-content-between">
                @foreach($element as $key=>$value)
                <div class="col-md-{{$col}} col-sm-12 form-group">
                    <label for="{{$key}}">{{$key}} </label>
                    <input type="text" class="form-control"  name="{{$key}}" value="{{ $value }}">
                </div>
                @endforeach
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

@push('scripts')
    <script src="{{ asset('vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".repeater-{{$getId()}}").repeater({
                show: function () {
                    $(this).slideDown()
                }, hide: function (e) {
                    confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
                }
            })
        });
    </script>
@endpush
