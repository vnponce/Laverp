@extends('adminlte::page')

@section('title','Agregar producto' . $store->name )

@section('content_header')
    <h1>Agregar producto {{ $store->name }}</h1>
@stop

@section('content')
    {{--<h1>Crear producto.</h1>--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Agregar</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="/stores/{{ $store->id }}/products/">
            {{ csrf_field() }}
            <div class="box-body">
                {!! Field::select('product_id', $products->pluck('title', 'id')->toArray(), ['empty' => 'Select product'], ['class' => 'product']) !!}
                {!! Field::text('quantity', ['name' => 'quantity', 'label' => 'Unidades.', 'placeholder' => 'Quantity'])  !!}
                {!! Field::hidden('price', '0', ['name' => 'price','label' => 'Precio', 'placeholder' => 'Price'])  !!}
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $('.product').select2();
    </script>
@stop