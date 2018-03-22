@extends('adminlte::page')

@section('title',$product->title )

@section('content_header')
    <h1>{{ $product->title }}</h1>
@stop

@section('content')
    {{ $product->title }}
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

    {{--<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">--}}
    {{--<thead>--}}
    {{--<tr>--}}
    {{--<th>Nombre</th>--}}
    {{--<th>Lugar</th>--}}
    {{--<th>Inventario</th>--}}
    {{--<th>Editar</th>--}}
    {{--<th>Eliminar</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tfoot>--}}
    {{--<tr>--}}
    {{--<th>Nombre</th>--}}
    {{--<th>Lugar</th>--}}
    {{--<th>Inventario</th>--}}
    {{--<th>Editar</th>--}}
    {{--<th>Eliminar</th>--}}
    {{--</tr>--}}
    {{--</tfoot>--}}
    {{--<tbody>--}}
    {{--@foreach($products as $product)--}}
    {{--<tr>--}}
    {{--<td>{{ $product->name }}</td>--}}
    {{--<td>Veracruz</td>--}}
    {{--<td>--}}
    {{--<a href="#" class="btn btn-primary">--}}
    {{--<i class="fa fa-archive"></i>--}}
    {{--</a>--}}
    {{--</td>--}}
    {{--<td>--}}
    {{--<a href="#" class="btn btn-primary">--}}
    {{--<i class="fa fa-edit"></i>--}}
    {{--</a>--}}
    {{--</td>--}}
    {{--<td>--}}
    {{--<a href="#" class="btn btn-danger">--}}
    {{--<i class="fa fa-trash"></i>--}}
    {{--</a>--}}
    {{--</td>--}}
    {{--</tr>--}}
    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}

@stop

{{--@section('js')--}}
{{--<script>--}}
{{--$(document).ready(function() {--}}
{{--$('#example').DataTable();--}}
{{--});--}}
{{--</script>script>--}}
{{--@stop--}}