<div id="content">
    <div id="siteNotice">
    </div>
    <h3 id="firstHeading" class="firstHeading">{{$model->name}}</h3>
    <div id="bodyContent">
        @if($model->address)
            <p><b>{{__('cms.shop_address')}}</b> : {{$model->address}}</p>
        @endif
    </div>
</div>
