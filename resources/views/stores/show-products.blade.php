@extends('adminlte::page')

@section('title', "Products in {$store->name}")

@section('content_header')
    <h1>Products in {{ $store->name }}</h1>
@stop

@section('content')
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Imagen</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Qty.</th>
            <th>Price</th>
            <th>Alta</th>
            <th>Baja</th>
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
            <th>Alta</th>
            <th>Baja</th>
            {{--<th>Delete</th>--}}
        </tr>
        </tfoot>
        <tbody>
        {{--<span class="hidden" id="store" data="{{ $store }}"></span>--}}
        @foreach($store->products as $product)
            <tr>
                <td><img style="max-height: 200px;" src="{{ asset($product->image) }}" class="img-responsive" alt=""></td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>${{ $product->price }}</td>
                <td>
                    <a href="#" data-product-id="{{ $product->id }}" class="add_reduce_button btn btn-link fa fa-plus-square-o fa-2x" style="text-decoration: none"></a>
                    <div class="hidden input-group">
                        <input type="number" id="{{ $product->id }}_quantity_add" value="0" min="0" class="form-control quantity" aria-label="Cantidad">
                        <div class="input-group-btn">
                            <button data-product-id="{{ $product->id }}"  type="button" class="btn btn-primary add" aria-label="Help">
                                <span class="fa fa-check-square-o"></span>
                            </button>
                            <button type="button" class="btn btn-danger cancel">
                                <span class="fa fa-ban"></span>
                            </button>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="#" data-product-id="{{ $product->id }}" class="add_reduce_button btn btn-link fa fa-minus-square-o fa-2x" style="text-decoration: none; color: tomato"></a>
                    <div class="hidden input-group">
                        <input id="{{ $product->id }}_quantity_reduce" type="number" min="0" value="0" class="form-control" aria-label="Cantidad">
                        <div class="input-group-btn">
                            <button data-product-id="{{ $product->id }}" type="button" class="btn btn-primary reduce" aria-label="Help">
                                <span class="fa fa-check-square-o"></span>
                            </button>
                            <button type="button" class="btn btn-danger cancel">
                                <span class="fa fa-ban"></span>
                            </button>
                        </div>
                    </div>
                    {{--<div class="input-group input-group-sm col-md-6">--}}
                        {{--<input type="number" class="form-control">--}}
                        {{--<span class="input-group-btn">--}}
                            {{--<button type="button" class="btn btn-danger btn-flat fa fa-minus-square-o fa-2x"></button>--}}
                        {{--</span>--}}
                    {{--</div>--}}
                    {{--<a href="#" class="btn btn-link delete-product fa fa-minus-square-o fa-2x" style="text-decoration: none; color: tomato"--}}
                       {{--data-toggle="modal" data-target="#exampleModal"--}}
                       {{--data-product="{{ $product }}"--}}
                    {{-->--}}
                    {{--</a>--}}
                </td>
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

    <!-- Modal -->
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
                            {{--<hr>--}}
                            {{--<h4>Descripción: <span class="product-description"></span></h4>--}}
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
                            <input type="number" min="0" class="form-control" id="toAddOrReduce">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    {{--<button type="button" class="btn btn-primary">Send message</button>--}}
                </div>
            </div>
        </div>
    </div> <!-- Fin modal -->

@stop

@section('js')
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--  This must replaced by ajax */ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            let store = {{ $store->id }}
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
            });
            // Accionando botones toggle
            $( ".add_reduce_button" ).click(function() {
                var parent= $(this).parents('td');
                parent.css('min-width', '200px');
                parent.find('.input-group').removeClass('hidden');
                parent.find('.add_reduce_button').addClass('hidden');
            });

            $( ".add" ).click(function(e) {
                e.preventDefault();
                hideButtonsShowActionButton($(this));
                // Proceso de salvar agregar
                let product = $(this).attr('data-product-id');
                let quantity = $('#' + product + '_quantity_add').val();
                let url = '/stores/' + store + '/products/' + product + '/add';
                let verb = 'alta';
                console.log(quantity);
                updateStock(url, quantity, verb)
            });
            $( ".reduce" ).click(function(e) {
                e.preventDefault();
                hideButtonsShowActionButton($(this));
                // Proceso de salvar reducir
                let product = $(this).attr('data-product-id');
                let quantity = $('#' + product + '_quantity_reduce').val();
                let url = '/stores/' + store + '/products/' + product + '/reduce';
                let verb = 'alta';
                console.log(quantity);
                updateStock(url, quantity, verb)
            });
            $( ".cancel" ).click(function() {
                hideButtonsShowActionButton($(this));
                // Aca no se hace nada
            });

            function hideButtonsShowActionButton(e){
                var parent= e.parents('td');
                parent.find('.input-group').addClass('hidden');
                parent.find('.add_reduce_button').removeClass('hidden');
                parent.css('min-width', '0px');
            }

            function updateStock(url, quantity, verb){
                console.log(url);
                console.log(quantity);
                console.log(verb);
                swal({
                    title: '¿Estas seguro de querer dar de ' + verb + ' estos ' +  quantity +' elementos?',
                    text: 'De no estarlo se puede cancelar',
                    icon: "warning",
                    buttons: ['Cancelar', 'Confirmar'],
                    dangerMode: true,
                }).then((result)=> {
                    console.log(result);
                    if(result){
                        $.ajax({
                            data: {'quantity': quantity},
                            url: url,
                            type: 'POST',
                        });
                        swal("Proceso satisfactorio", {
                            icon: "success",
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });
            }
        });
    </script>
@stop