
<div class="row">

    @isset($options['left'])
    <div class="col-sm-6 d-flex flex-column">
        <h4 class="my-1">{{ $options['left']['label'] ?? 'left' }}</h4>
        @isset($options['search'])
            <x-input name="left" options="{!! json_encode(['class'=>'search', 'id'=>'left_search','placeholder'=>__('cms.search')]) !!}" ></x-input>
        @endisset
        <ul class="list-group draggable-list flex-grow-1" id="left" @isset($options['height']) style="height: {{$options['height']}}px" @endisset >
            @isset($options['left']['data'])
                @foreach($options['left']['data'] as $item)

                    <li  class="list-group-item handle @if($isFixed($item)) fixed @endif " data-item="{{ json_encode($item) }}" >
                        @if($isFixed($item))<i class="fas fa-ban"></i>  @else <i class="fas fa-arrows-alt "></i> @endif {{ $item['name'] }}
                        @isset($item['description'])
                            <i class="fas fa-info float-right" data-toggle="tooltip" title="{{ $item['description'] }}"></i>
                        @endisset
                    </li>

                @endforeach
            @endisset
        </ul>
        @isset($options['left']['name'])
            <input type="hidden" class="handle-input" name="{{ $options['left']['name'] }}" id="left-input">
        @endisset
    </div>
    @endisset
    @isset($options['right'])
        <div class="col-sm-6 d-flex flex-column">

            <h4 class="my-1">{{ $options['right']['label'] ?? 'right' }}</h4>

            @isset($options['search'])
                <x-input name="right" options="{!! json_encode(['class'=>'search','id'=>'right_search','placeholder'=>__('cms.search')]) !!}" ></x-input>
            @endisset

            @isset($options['right']['data'])
            <ul class="list-group draggable-list flex-grow-1" id="right" >

                @foreach($options['right']['data'] as $item)

                    <li class="list-group-item handle @if($isFixed($item)) fixed @endif " data-item="{{ json_encode($item) }}" >
                        @if($isFixed($item))<i class="fas fa-ban"></i>  @else <i class="fas fa-arrows-alt "></i> @endif {{ $item['name'] }}
                        @isset($item['description'])
                            <i class="fas fa-info float-right" data-toggle="tooltip" title="{{ $item['description'] }}"></i>
                        @endisset
                    </li>

                @endforeach

            </ul>
            @endisset

            @isset($options['right']['name'])
                <input type="hidden" class="handle-input" name="{{ $options['right']['name'] }}" id="right-input">
            @endisset

        </div>
    @endisset
</div>

@push('scripts')
    <script src="{{asset('js/scripts/extensions/dragula.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            new PerfectScrollbar('.draggable-list#left', {
                wheelSpeed: 2,
                wheelPropagation: true,
                minScrollbarLength: 20
            });
            new PerfectScrollbar('.draggable-list#right', {
                wheelSpeed: 2,
                wheelPropagation: true,
                minScrollbarLength: 20
            });

            let left = document.getElementById("left");
            let right = document.getElementById("right");
            let data = {};

            function setData() {
                data = {
                    'left':[],
                    'right':[]
                };
                $(left).find('li').map(function ( idx, el ) {
                    data.left.push($(el).data('item'));
                })
                $(right).find('li').map(function ( idx, el ) {
                    data.right.push($(el).data('item'));
                })
            }

            function fillInput() {
                setData();
                for (const [key, value] of Object.entries(data)) {
                    let input = document.getElementById(key+"-input");
                    $(input).val(JSON.stringify(value));
                }
            }

            fillInput();

             dragula([document.getElementById("left"), document.getElementById("right")],{
                accepts: function (el, target, source, sibling) {

                    fillInput();
                    return true; // elements can be dropped in any of the `containers` by default
                    //return target !== document.getElementById("handle-left")
                },
                 moves: function (el, source, handle, sibling) {
                     return !$(el).hasClass('fixed');
                 },
            });

            $('input.search').on('change paste keyup', function(e){
                let term = e.target.value;
                if(term !== 0){
                    callSearch( $(this).attr('name') , term.toLowerCase() );
                }
            })

            function callSearch(idx, term)
            {
                $('ul#'+idx+' li')
                    .filter( (index, el) => ($(el).html().toLowerCase().indexOf(term) !== -1) ?  $(el).show() : $(el).hide() )
                // drake();
            }

        });
    </script>
@endpush



