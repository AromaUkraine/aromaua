@extends('layouts.cms')



@section('content')
    <div class="row">
        <div class="col-12">
            <x-card expand>
                <div class="col-md-4 ml-auto my-2">
                    <input type="search" class="form-control form-control-sm search" placeholder="">
                </div>
                <div class="table-responsive" id="table-search">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>method</th>
                            <th>uri</th>
                            <th>name</th>
                            <th>action</th>
                            <th>middleware</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($routes as $route)
                            <tr>
                                <td>{{ $route['method'] }}</td>
                                <td>{{ $route['uri'] }}</td>
                                <td>{{ $route['name'] }}</td>
                                <td>{{ $route['action'] }}</td>
                                <td>{{ $route['middleware'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('.search').on('change paste keyup', function(e){
                var value = $(this).val().toLowerCase();
                $("#table-search tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        })
    </script>
@endpush


