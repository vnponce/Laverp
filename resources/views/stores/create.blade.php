@extends('adminlte::page')

@section('title','Create store' )

@section('content_header')
    <h1>Create Store</h1>
@stop

@section('content')
    {{--<h1>Crear producto.</h1>--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">New store</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="/stores/create">
            {{ csrf_field() }}
            <div class="box-body">
                {!! Field::text('name', ['name' => 'title', 'label' => 'Name', 'placeholder' => 'Store name'])  !!}
                {!! Field::text('address', ['name' => 'description','label' => 'Address', 'placeholder' => 'Store address'])  !!}
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