@extends('adminlte::page')

@section('title', 'Stores')

@section('content_header')
    <h1>Stores</h1>
@stop

@section('content')
    {{--<div class="col-md-4">--}}
    {{--<!-- Apply any bg-* class to to the info-box to color it -->--}}
    {{--<div class="info-box bg-red">--}}
    {{--<span class="info-box-icon"><i class="fa fa-comments-o"></i></span>--}}
    {{--<div class="info-box-content">--}}
    {{--<span class="info-box-text">Likes</span>--}}
    {{--<span class="info-box-number">41,410</span>--}}
    {{--<!-- The progress section is optional -->--}}
    {{--<div class="progress">--}}
    {{--<div class="progress-bar" style="width: 70%"></div>--}}
    {{--</div>--}}
    {{--<span class="progress-description">--}}
    {{--70% Increase in 30 Days--}}
    {{--</span>--}}
    {{--</div>--}}
    {{--<!-- /.info-box-content -->--}}
    {{--</div>--}}
    {{--<!-- /.info-box -->--}}
    {{--</div>--}}

    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Stock</th>
            <th>Set products</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Stock</th>
            <th>Set products</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($stores as $store)
            <tr>
                <td>{{ $store->name }}</td>
                <td>{{ $store->address }}</td>
                <td>
                    <a href="#" class="btn btn-primary">
                        <i class="fa fa-archive"></i>
                    </a>
                </td>
                <td>
                    <a href="#" class="btn btn-primary">
                        <i class="fa fa-archive"></i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('stores.edit', ['id' => $store->id]) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
                <td>
                    <a href="#" data-stores-id="{{ $store->id }}" class="btn btn-danger delete-product">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop

@section('js')
    <!--  This must replaced by ajax */ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            /* Destroy item ( in future replaced by vue as example )*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete-store').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url: '/stores/' + $(this).attr('data-store-id'),
                    type: 'DELETE',
                });
            })
        });
    </script>script>
@stop