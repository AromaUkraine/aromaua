
<!DOCTYPE html>
@php
    $configData = TemplateHelper::all();
@endphp
<html lang="{{ \App::getLocale() }}" data-textdirection="{{$configData['direction'] == 'rtl' ? 'rtl' : 'ltr' }}">
<!-- BEGIN: Head-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body >
{{--{!! app()->settings->get('after-body') !!} --}}

<!-- BEGIN: Content-->
<div class="app-content content" id="app">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">

        </div>
        <div class="content-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Welcome page</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

</body>
<!-- END: Body-->
</html>


