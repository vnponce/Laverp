@extends('adminlte::page')

@section('title','Create product' )

@section('content_header')
    <h1>Crear producto</h1>
@stop

@section('content')
    {{--<h1>Crear producto.</h1>--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Ingresar datos de producto nuevo</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="/products" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                {!! Field::text('title', ['name' => 'title', 'label' => 'Título', 'placeholder' => 'Título de producto'])  !!}
                {!! Field::text('description', ['name' => 'description','label' => 'Descripción', 'placeholder' => 'Descripción de producto'])  !!}
                {!! Field::file('image', ['name' => 'image', 'label' => 'Imagen'])  !!}
                {!! Field::text('code', ['name' => 'code', 'label' => 'Código', 'placeholder' => 'Código de producto'])  !!}
{{--                {!! Field::text('sku', ['name' => 'sku', 'label' => 'SKU', 'placeholder' => 'SKU de producto'])  !!}--}}
{{--                {!! Field::text('volume', '0', ['name' => 'volume', 'label' => 'Volumen', 'placeholder' => 'Volume de producto en cm'])  !!}--}}
                {!! Field::hidden('volume', '0')  !!}
                {!! Field::hidden('weight', '0')  !!}
{{--                {!! Field::hidden('weight', '0', ['name' => 'weight', 'label' => 'Peso', 'placeholder' => 'Peso de producto en gramos'])  !!}--}}
                {!! Field::text('price', ['name' => 'price', 'label' => 'Precio', 'placeholder' => 'Precio del producto'])  !!}
                {!! Field::hidden('cost', '0')  !!}
{{--                {!! Field::hidden('cost', ['name' => 'cost', 'label' => 'Costo', 'placeholder' => 'Costo del producto'])  !!}--}}
{{--                {!! Field::select('condition', ['new' => 'Nuevo', 'prime' => 'Matería Prime', 'both' => 'Ambos'], ['empty' => 'Seleccionar condición del artículo']) !!}--}}
                {!! Field::hidden('condition', '1') !!}
                {!! Field::hidden('days_to_deliver', '0', ['name' => 'days_to_deliver', 'label' => 'Días de entrega', 'placeholder' => 'Días de entrega por parte del proveedor'])  !!}
                {!! Field::text('available_quantity', ['name' => 'available_quantity', 'label' => 'Available Qty.', 'placeholder' => 'En almacen para ser distribuidos'])  !!}
                {{--'category_id',  // habrá categorias--}}
                {{--                {!! Field::text('Costo', ['name' => 'cost', 'placeholder' => 'Costo del producto'])  !!}--}}
                {!! Field::hidden('unit_of_measure', '0') !!}
{{--                {!! Field::select('unit_of_measure', ['piece' => 'Pieza'], ['empty' => 'Seleccionar tipo de unidad de medida']) !!}--}}
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>

    </script>
@stop