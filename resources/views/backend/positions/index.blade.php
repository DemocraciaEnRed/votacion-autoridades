@extends('adminlte::page')

@section('title', 'Posiciones | Listar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Listar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\BlockController@index') }}">Lista de bloques</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\BlockController@edit', $block) }}">{{ $block->name }}</a></li>
                    <li class="breadcrumb-item active">Lista de posiciones</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @include('backend.partials._sweet-alerts')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Positions</h3>
                    <div class="card-tools">
                        <a class="btn btn-block btn-success btn-sm" href="{{ action('\App\Http\Controllers\Backend\PositionController@create', $block) }}"><i class="fas fa-plus"></i> Nueva</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered positions">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('js')
<script>
$(function () {

    var table = $('.positions').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('\App\Http\Controllers\Backend\PositionController@index', $block) }}",
        columns: [
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'action',
                name: 'action',
            },
        ]
    });

});
</script>
@endpush
