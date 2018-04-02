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
        <form role="form" method="POST" action="/products">
            {{ csrf_field() }}
            <div class="box-body">
                {!! Field::text('title', ['name' => 'title', 'label' => 'Título', 'placeholder' => 'Título de producto'])  !!}
                {!! Field::text('description', ['name' => 'description','label' => 'Descripción', 'placeholder' => 'Descripción de producto'])  !!}
                {!! Field::file('photo', ['name' => 'photo', 'label' => 'Imagen'])  !!}
                {!! Field::text('code', ['name' => 'code', 'label' => 'Código', 'placeholder' => 'Código de producto'])  !!}
                {!! Field::text('sku', ['name' => 'sku', 'label' => 'SKU', 'placeholder' => 'SKU de producto'])  !!}
                {!! Field::text('volume', ['name' => 'volume', 'label' => 'Volumen', 'placeholder' => 'Volume de producto en cm'])  !!}
                {!! Field::text('weight', ['name' => 'weight', 'label' => 'Peso', 'placeholder' => 'Peso de producto en gramos'])  !!}
                {!! Field::text('price', ['name' => 'price', 'label' => 'Precio', 'placeholder' => 'Precio del producto'])  !!}
                {!! Field::text('cost', ['name' => 'cost', 'label' => 'Costo', 'placeholder' => 'Costo del producto'])  !!}
                {!! Field::select('condition', ['new' => 'Nuevo', 'prime' => 'Matería Prime', 'both' => 'Ambos'], ['empty' => 'Seleccionar condición del artículo']) !!}
                {!! Field::text('days_to_deliver', ['name' => 'days_to_deliver', 'label' => 'Días de entrega', 'placeholder' => 'Días de entrega por parte del proveedor'])  !!}
                {!! Field::text('available_quantity', ['name' => 'available_quantity', 'label' => 'Available Qty.', 'placeholder' => '[RECIBIDOS] total Quantity'])  !!}
                {{--'category_id',  // habrá categorias--}}
                {{--                {!! Field::text('Costo', ['name' => 'cost', 'placeholder' => 'Costo del producto'])  !!}--}}
                {!! Field::select('unit_of_measure', ['piece' => 'Pieza'], ['empty' => 'Seleccionar tipo de unidad de medida']) !!}
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