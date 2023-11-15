<div class="product__info">
    @if ($columns)
        @foreach ($columns as $column)
            <div class="product__standard">
                <div class="product__name">{{ $column['column_name'] }}@if($column['series'] != '') {{ __('web.Series') }} {{ $column['series'] }}@endif</div>
                <dl class="product__price">
                    <dt> {{ __('web.The cost') }}: <span>{{ $column['price'] }}</span>
                        <small>{{ $column['currency'] }}</small>
                    </dt>
                </dl>

                @if ($issetDocumentation())
                <div class="product__documentation">{{ __('web.Quality documents for products') }}
{{--                    <span>{{$product->name}} {{ $column['column_name'] }}@if($column['series'] != '') {{ __('web.Series') }} {{ $column['series'] }}@endif {{ $getProductCode() }}</span>--}}
                </div>

                <table class="product__pdf">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            @foreach ($langs as $lang)
                                <th>{{ $lang }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getDocumentsByColumnNumber($column['column_number']) as $document)
                            <tr>
                                <td>@if(isset($document['name'])){{ $document['name'] }}:@endif</td>
                                @foreach ($langs as $lang)
                                    <td>
                                        @if(isset($document['locale'][$lang]))
                                            @if($document['locale'][$lang]['href'])
                                                <a target="_blank" href="{{ asset('uploads/files/'.$document['locale'][$lang]['href']) }}"></a>
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                @endif
            </div>
        @endforeach
    @endif
</div>

