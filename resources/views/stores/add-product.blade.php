@extends('adminlte::page')

@section('title','Add Product' )

@section('content_header')
    <h1>Add Product</h1>
@stop

@section('content')
    {{--<h1>Crear producto.</h1>--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add product</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="/stores/{{ $store->id }}/products/">
            {{ csrf_field() }}
            <div class="box-body">
                {!! Field::select('product_id', $products->pluck('title', 'id')->toArray(), ['empty' => 'Select product']) !!}
                {!! Field::text('quantity', ['name' => 'quantity', 'label' => 'Qty.', 'placeholder' => 'Quantity'])  !!}
                {!! Field::text('price', ['name' => 'price','label' => 'Price', 'placeholder' => 'Price'])  !!}
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>

    </script>
@stop