@extends('adminlte::page')

@section('title','Edit Store' )

@section('content_header')
    <h1>Edit Store {{ $store->name }}</h1>
@stop

@section('content')
    {{--<h1>Crear producto.</h1>--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit {{ $store->name }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::model($store, ['route' => ['stores.update', $store->id], 'method' => 'put'])  !!}
        <div class="box-body">
            {!! Field::text('name', ['name' => 'name', 'label' => 'Name', 'placeholder' => 'Store name'])  !!}
            {!! Field::text('address', ['name' => 'address','label' => 'Address', 'placeholder' => 'Store Address'])  !!}
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
        {!! Form::close()  !!}
    </div>
@stop

@section('js')
    <script>

    </script>
@stop