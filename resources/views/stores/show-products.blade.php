@extends('adminlte::page')

@section('title', "Products in {$store->name}")

@section('content_header')
    <h1>Products in {{ $store->name }}</h1>
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
            <th>Imagen</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Qty.</th>
            <th>Price</th>
            {{--<th>Edit</th>--}}
            {{--<th>Delete</th>--}}
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Imagen</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Qty.</th>
            <th>Price</th>
            {{--<th>Edit</th>--}}
            {{--<th>Delete</th>--}}
        </tr>
        </tfoot>
        <tbody>
        @foreach($store->products as $product)
            <tr>
                <td><img style="max-height: 200px;" src="{{ asset($product->image) }}" class="img-responsive" alt=""></td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>${{ $product->price }}</td>
                {{--<td>--}}
                    {{--<a href="#" class="btn btn-primary">--}}
                        {{--<i class="fa fa-edit"></i>--}}
                    {{--</a>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<a href="#" class="btn btn-danger delete-productsssssss">--}}
                        {{--<i class="fa fa-trash"></i>--}}
                    {{--</a>--}}
                {{--</td>--}}
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
                alert('hola');
                $.ajax({
                    url: '/stores/' + $(this).attr('data-store-id'),
                    type: 'DELETE',
                });
            })
        });
    </script>
@stop