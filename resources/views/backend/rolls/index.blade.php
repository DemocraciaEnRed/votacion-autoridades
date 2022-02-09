@extends('adminlte::page')

@section('title', 'Roles | Listar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Listar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Lista de roles</li>
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
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title flex-grow-1">Censo</h3>
                    <div class="card-tools m-0">
                        <a class="btn btn-block btn-success btn-sm" href="{{ action('\App\Http\Controllers\Backend\RollController@create') }}"><i class="fas fa-plus"></i> Nuevo</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered rolls">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Documento de identidad</th>
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

    var table = $('.rolls').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('\App\Http\Controllers\Backend\RollController@index') }}",
        columns: [
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'last_name',
                name: 'last_name',
            },
            {
                data: 'dni',
                name: 'dni',
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
