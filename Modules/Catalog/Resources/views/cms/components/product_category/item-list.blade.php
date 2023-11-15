<x-select
    label="{{__('cms.product_categories')}}"
    name="{{$name}}"
    id="category_tree"
    placeholder="{{ $options['placeholder'] ?? '' }}"
    options="{!! json_encode($options) !!}">
    @foreach($categories as $category)
        @include('catalog::cms.components.product_category._options_tree',['category'=>$category, 'level'=>0])
    @endforeach
</x-select>

@push('scripts')
    <script>
        // function formatState (data, container) {
        //     if (data.element) {
        //         $(container).addClass($(data.element).attr("class"));
        //     }
        //     if($(data.element).attr("class") === 'strong'){
        //         return $('<strong>').append(data.text);
        //     }
        //     return data.text;
        // };
        // $("#product_category").select2({
        //     templateResult: formatState,
        // });
        // // select2.select({
        // //     templateResult:(){
        // //
        // // }formatState
        // // })
        // // select2.templateResult( function (){
        // //
        // // });//: formatState
    </script>
{{--    <script>--}}
{{--        function formatState (data, container) {--}}
{{--            if (data.element) {--}}
{{--                $(container).addClass($(data.element).attr("class"));--}}
{{--            }--}}
{{--            if($(data.element).attr("class") === 'strong'){--}}
{{--                return $('<strong>').append(data.text);--}}
{{--            }--}}
{{--            return data.text;--}}
{{--        };--}}
{{--        // $("select").select2({--}}
{{--        //     theme: 'bootstrap',--}}
{{--        //     width: '100%',--}}
{{--        //     placeholder: $('#category_tree').attr('placeholder'),--}}
{{--        //     escapeMarkup: function(m) {--}}
{{--        //         return m;--}}
{{--        //     },--}}
{{--        //     allowClear: true,--}}
{{--        //     templateResult: formatState--}}
{{--        // });--}}
{{--    </script>--}}
@endpush
