@extends('adminlte::page')

{{--@section('adminlte_css')--}}
{{--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">--}}
{{--@stop--}}
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
            <th>Mas información</th>
            @if(auth()->user() &&  auth()->user()->isAdmin())
{{--            @if(auth()->user() && auth()->user()->role == 'admin')--}}
                {{--<th>Stock</th>--}}
                <th>Acciones</th>
            @endif
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Imagen</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Mas información</th>
            @if(auth()->user() && auth()->user()->isAdmin())
                {{--<th>Stock</th>--}}
                <th>Acciones</th>
            @endif
        </tr>
        </tfoot>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td><img style="max-height: 200px;" src="{{ asset('storage/'.$product->image) }}" class="img-responsive" alt=""></td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->title }}</td>
                <td>
                    <a href="#" class="btn btn-link"
                       data-toggle="modal" data-target="#exampleModal"
                       data-product="{{ $product }}"
                       data-stores="{{ $product->stores }}"
                    >
                        <i class="fa fa-plus-square-o fa-lg"></i>
                        Existencia: <span class="label label-default">{{ $product->total_available }}</span>
                        {{--<i class="fa fa-plus"></i>--}}
                    </a>
                </td>
                @if(auth()->user() && auth()->user()->isAdmin())
                    {{--<td>--}}
                        {{--<a href="#" class="btn btn-primary">--}}
                            {{--<i class="fa fa-archive"></i>--}}
                        {{--</a>--}}
                    {{--</td>--}}
                    <td>
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-link fa fa-edit fa-2x" style="text-decoration: none">
                            </a>
                            <a href="#" data-product-id="{{ $product->id }}" class="btn btn-link delete-product fa fa-trash fa-2x" style="text-decoration: none; color: tomato">
                            </a>
                        </div>

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
                            <img style="max-height: 200px;" src="#" class="img-responsive product-image" alt=""/>
                            <h4>Producto: <span class="product-title"></span></h4>
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
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{--<link href="maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">--}}
    {{--<link href="cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">--}}
    <!--  This must replaced by ajax */ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
                }
            });

            /* Modal */
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var product = button.data('product') // Extract info from data-* attributes
                var stores = button.data('stores') // Extract info from data-* attributes
                console.table(product);
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text('Product: ' + product.title)
                modal.find('.product-title').text(product.title)
                modal.find('.product-sku').text(product.sku)
                modal.find('.product-description').text(product.description)
                modal.find('.product-price').text('$ '+product.format_price)
                modal.find('.product-image').attr('src', 'storage/'+product.image)
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
                swal({
                    title: '¿Estas seguro de querer eliminar el elemento?',
                    text: 'De no estarlo se puede cancelar',
                    icon: "warning",
                    buttons: ['Cancelar', 'Eliminar item'],
                    dangerMode: true,
                    // showCancelButton: true,
                    // confirmButtonColor: '#dd00dd',
                    // cancelButtonColor: '#3dd',
                    // cancelButtonText: 'Cancelar',
                    // confirmButtonText: 'Eliminar item'
                }).then((result)=> {
                    console.log(result);
                    if(result){
                        $.ajax({
                            url: '/products/' + $(this).attr('data-product-id'),
                            type: 'DELETE',
                        });
                        swal("Elmento eliminado", {
                            icon: "success",
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });
            })
        });
    </script>
@stop