@extends('adminlte::page')

@section('title', 'Inventario')

@section('content_header')
    <h1>Productos</h1>
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
            <th>Ver +</th>
            @if(auth()->user() && auth()->user()->role == 'admin')
                <th>Stock</th>
                <th>Edit</th>
                <th>Delete</th>
            @endif
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Imagen</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Ver +</th>
            @if(auth()->user() && auth()->user()->role == 'admin')
                {{--<th>Stock</th>--}}
                <th>Edit</th>
                <th>Delete</th>
            @endif
        </tr>
        </tfoot>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td><img src="{{ $product->image }}" class="img-responsive" alt=""></td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->title }}</td>
                <td>
                    <a href="#" class="btn btn-primary"
                       data-toggle="modal" data-target="#exampleModal"
                       data-product="{{ $product }}"
                       data-stores="{{ $product->stores }}"
                    >
                        <i class="fa fa-plus"></i>
                    </a>
                </td>
                @if(auth()->user() && auth()->user()->role == 'admin')
                    {{--<td>--}}
                        {{--<a href="#" class="btn btn-primary">--}}
                            {{--<i class="fa fa-archive"></i>--}}
                        {{--</a>--}}
                    {{--</td>--}}
                    <td>
                        <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" data-product-id="{{ $product->id }}" class="btn btn-danger delete-product">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>


    {{--Modal--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="#" class="img-responsive product-image" alt=""/>
                            <h4>Product: <span class="product-title"></span></h4>
                            <hr>
                            <h4>Sku: <span class="product-sku"></span></h4>
                            <hr>
                            <h4>Descripción: <span class="product-description"></span></h4>
                            <hr>
                            <h4>Precio: <span class="product-price"></span></h4>
                            <hr>
                            {{--<div class="product-volume">Volume</div>--}}
                            {{--<div class="product-weight">Peso</div>--}}
                            {{--<div class="product-condition">Peso</div>--}}
                        </div>
                        <div class="col-md-6">
                            <h3>Existencia</h3>
                            <div class="product-stores"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    {{--<button type="button" class="btn btn-primary">Send message</button>--}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!--  This must replaced by ajax */ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            /* Modal */
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var product = button.data('product') // Extract info from data-* attributes
                var stores = button.data('stores') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text('Product: ' + product.title)
                modal.find('.product-title').text('Product: ' + product.title)
                modal.find('.product-sku').text('Product: ' + product.sku)
                modal.find('.product-description').text(product.description)
                modal.find('.product-price').text(product.price)
                modal.find('.product-image').attr('src', product.image)
                modal.find('.product-stores').html('')
                stores.forEach(function(store){
                    modal.find('.product-stores').append('<h3>' + store.name + ': ' +store.pivot.quantity +  '</h3>')
                })
            })

            /* Destroy item ( in future replaced by vue as example )*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete-product').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url: '/products/' + $(this).attr('data-product-id'),
                    type: 'DELETE',
                });
            })
        });
    </script>
@stop