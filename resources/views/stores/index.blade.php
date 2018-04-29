@extends('adminlte::page')
{{--@section('adminlte_css')--}}
    {{--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">--}}
{{--@stop--}}

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
    <div class="box-body">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->address }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="/stores/{{ $store->id }}/products" class="btn btn-link fa fa-barcode fa-2x" style="text-decoration: none" title="Existencia"></a>
                            <a href="/stores/{{ $store->id }}/products/add" class="btn btn-link fa fa-plus-square-o fa-2x" style="text-decoration: none" title="Agregar producto"></a>
                            <a href="{{ route('stores.edit', ['id' => $store->id]) }}" class="btn btn-link fa fa-edit fa-2x" style="text-decoration: none" title="Editar"></a>
                            <a href="#" data-store-id="{{ $store->id }}" class="btn btn-link delete-store fa fa-trash fa-2x" style="text-decoration: none; color: tomato" title="Eliminar"></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('js')
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--  This must replaced by ajax */ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
                }
            });

            /* Destroy item ( in future replaced by vue as example )*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete-store').on('click', function(e){
                e.preventDefault();
                swal({
                    title: '¿Estas seguro de querer eliminar el elemento?',
                    text: 'De no estarlo se puede cancelar',
                    icon: "warning",
                    buttons: ['Cancelar', 'Eliminar item'],
                    dangerMode: true,
                }).then((result)=> {
                    console.log(result);
                    if(result){
                        $.ajax({
                            url: '/stores/' + $(this).attr('data-store-id'),
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