@if($tableData)
    <div class="table-responsive">
        <table id="permission-table" class="table table-hover datatable ">
            <thead>
            <th width="20%"><input type="search" class="form-control form-control-sm search" placeholder=""></th>
            <th width="80%"></th>
            </thead>
            <tbody>
                @foreach($tableData as $controller=>$actions)
                    <tr>
                        <td id="{{ __('cms.permission_'.$controller) }}">{{ __('cms.permission_'.$controller) }}</td>
                        <td>
                            <x-select
                            name="permissions[]"
                            options="{!! json_encode([
                                'type'=>'select2',
                                'id' => $controller,
                                'placeholder'=>__('cms.select.default'),
                                'multiple'=>true
                            ]) !!}"
                        >
                            @foreach($actions as $action)
                                @if($action)
                                    <option value="{{$action['id']}}" @if($checkSelected($action['slug'])) selected @endif>
                                        {{ $setActionName($action['action']) }}
                                    </option>
                                @endif
                            @endforeach
                        </x-select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('.search').on('change paste keyup', function(e){
                let term = e.target.value;
                let idx = $('.search').index(this)
                if(term !== 0){
                    callSearch( idx , term.toLowerCase() );
                }
            });
            function callSearch( idx, term ){
                $('tbody tr')
                    .map( (index, el) => $(el).children().get(idx))
                    .filter( (index, el) => ($(el).html().toLowerCase().indexOf(term) !== -1) ?  $(el).parent().show() : $(el).parent().hide() )
            }
        })
    </script>
@endpush

