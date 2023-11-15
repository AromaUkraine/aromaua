<p>
    {!! __('translation.Note: translations are not available until they are exported back to the file using the :code command or the import button.',
       ['code'=>"<code>php artisan translations:import</code>"]) !!}
</p>
<p>
    {!!  __('translation.Note: translations are not displayed until they are imported into the database using the :code command or the publish button.',
        ['code'=>"<code>php artisan translation:export * </code>"]) !!}
</p>



@if(count($groups))
    <x-select
        name="group"
        id="group"
        label="{{__('translation.choose a group to display the group translations')}}"
        data-index="{{ route('root.translation.index') }}"
        options="{!! json_encode([
            'type' =>'select2 group-select'
]) !!}"
    >
        @foreach($groups as $key => $value)
            <option id="{{ $key }}" value="{{ route('root.translation.show', $key) }}"
                    @if($key == $group) selected @endif >{{ $value }}</option>
        @endforeach
    </x-select>

@endif

@if(!$group)
    <div class="form-group" id="create-group">
        <label for="">{{__('translation.Create group')}}</label>
        <input type="text" data-url="{{route('root.translation.index')}}" class="form-control create-group" name="group"
               placeholder="{{__('translation.Create group')}}">
    </div>
@else
    <div class="form-group" id="create-key">
        <label for="">{{__('translation.add key')}}</label>
        <textarea
            name="keys"
            data-url="{{route('root.translation.create', $group)}}"
            class="form-control create-key"
        ></textarea>
        <div class="col-11 float-left pl-0">
            <small class="text-muted">{{__('translation.Add 1 key per line, without the group prefix')}}</small>
        </div>
    </div>
@endif

@if(count($groups) && $group)

    @php $width = ceil( (100 - 10 ) / count($locales) + 2 ) @endphp

    <div class="col-sm-12 my-1 table-responsive">
        <table style="table-layout: fixed;" class="table table-striped  table__translation">
            <thead>
            <tr>
                <th style="width: {{$width}}%">{{__("translation.keys")}}</th>

                @foreach($locales as $locale)
                    <th style="width: {{$width}}%">{{ $locale }}</th>
                @endforeach
                <th style="width: 10%">&nbsp;</th>
            </tr>
            <tr>
                <th>
                    <input type="search"  class="form-control form-control-sm search">
                </th>
                @foreach($locales as $locale)
                    <th>
                        <input type="search"  class="form-control form-control-sm search">
                    </th>
                @endforeach
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($translations as $key => $translation)
                <tr id="{{ htmlentities($key, ENT_QUOTES, 'UTF-8', false) }}" >
                    <td  >{{ htmlentities($key, ENT_QUOTES, 'UTF-8', false) }}</td>

                    @foreach ($locales as $locale)
                        @php $t = isset($translation[$locale]) ? $translation[$locale] : null @endphp
                        <td  >
                            <a href="#"
                               class="editable status-{{$t ? $t->status : 0}} locale-{{$locale}}"
                               data-locale="{{ $locale }}"
                               data-name="{{ $locale."|".htmlentities($key, ENT_QUOTES, 'UTF-8', false) }}"
                               id="username" data-type="textarea" data-pk="{{ $t ? $t->id : 0 }}"
                               data-url="{{ route('root.translation.update', $group) }}"
                               data-title="Enter translation">{{ $t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : '' }}</a>
                        </td>
                    @endforeach
                    <td>
                        <a href="{{route('root.translation.destroy',  $key )}}"
                           class="btn btn-delete btn-icon rounded-circle btn-outline-danger  ml-1"
                           data-confirm="{{__('translation.Are you sure you want to delete the translations for')}} &laquo; {{htmlentities($key, ENT_QUOTES, 'UTF-8', false)}} &raquo; ?"
                           data-toggle="tooltip"
                           title="{{__('cms.buttons.delete')}}">
                            <i class="bx bx-trash"> </i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

@if( $group )
@section('form-fixed-buttons')

    <x-button
        type="button"
        class="primary text-capitalize my-2 mr-1 btn-publish"
        options="{!! json_encode(['data-href'=>route('root.translation.publish', $group)]) !!}"
        title="{{ ($group) ? __('cms.buttons.publish') : __('cms.buttons.publish all')}}"
    ></x-button>
    <x-action
        href="{{ route('root.translation.index') }}"
        class="light text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>

@endsection
@endif


@push('scripts')

    <script>
        $(document).ready(function () {

            let search = $('.search');
            search.on('change paste keyup', function(e){
                let term = e.target.value;
                let idx = $('.search').index(this)
                if(term !== 0){
                    callSearch( idx , term.toLowerCase() );
                }
            })
            search.on('search', function (e) {
                e.target.value = null;
                let idx = $('.search').index(this)
                callShowAll(idx);
            });

            function callSearch( idx, term ){
                $('.table__translation > tbody > tr')
                    .map( (index, el) => $(el).children()[idx])
                    .filter( (index, el) => ($(el).html().toLowerCase().indexOf(term) !== -1) ?  $(el).parent().show() : $(el).parent().hide() )
            }

            function callShowAll(idx)
            {
                $('.table__translation > tbody > tr')
                    .map( (index, el) => $(el).children()[idx])
                    .filter( (index, el) => ($(el).parent().hide()) ?  $(el).parent().show() :null )
            }

            $('.btn-find').on('click', function (e) {
                e.preventDefault();
                var self = this;
                var data = {
                    title: "{{__('translation.Find translations in files')}}",
                    message: "{{__('translation.Are you sure you want to scan you app folder? All found translation keys will be added to the database.') }}",
                    confirmButtonText: "{{ __('cms.buttons.create') }}",
                    cancelButtonText: "{{ __('cms.buttons.cancel') }}",
                }
                $.confirm(data, function (res) {
                    if (res) {
                        $.sendAjax({url: $(self).attr('href')}, function (res) {
                            window.location.reload();
                        });
                    }
                })
            });

            $('.btn-delete').on('click', function (e) {
                e.preventDefault();

                var self = this;
                var data = {
                    title: "{{__('datatable.delete.title')}}",
                    message: $(self).data('confirm'),
                    confirmButtonText: "{{ __('datatable.delete.confirmButtonText') }}",
                    cancelButtonText: "{{ __('datatable.delete.cancelButtonText') }}",
                }
                var row = $(self).closest('tr');
                $.confirm(data, function (result) {
                    if (result) {
                        $.sendAjax({url: $(self).attr('href'), type: "DELETE"}, function (res) {
                            row.remove();
                            window.location.reload();
                        });
                    }
                })
            });

            $('.btn-publish').on('click', function () {
                $.sendAjax({url: $(this).data('href'), type: "post"}, function (res) {
                    window.location.reload();
                })
            });

            $('.group-select').on('change', function () {
                window.location.href = ($(this).val()) ? $(this).val() : $(this).data('index')
            });

            $('.create-group').editable({
                mode: 'inline',
                type: 'text',
            }).on('save', function (e, reason) {
                window.location.href = $(this).data('url') + '/' + reason.newValue + '/show';
            })

            $('.create-key').editable({
                mode: 'inline',
                type: 'textarea',
            }).on('save', function (e, reason) {

                var data = {
                    url: $(this).data('url'),
                    data: {keys: reason.newValue},
                    type: 'post'
                }
                $.sendAjax(data, function (res) {
                    window.location.reload();
                });
            })

            $('.editable').editable({
                mode: 'inline',
                ajaxOptions: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'PATCH',
                }
            }).on('hidden', function (e, reason) {
                var locale = $(this).data('locale');
                if (reason === 'save') {
                    $(this).removeClass('status-0').addClass('status-1');
                }
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable.locale-' + locale);
                    setTimeout(function () {
                        $next.editable('show');
                    }, 300);
                }
            });
        });

    </script>
@endpush

