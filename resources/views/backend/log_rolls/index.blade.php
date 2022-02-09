@extends('adminlte::page')

@section('title', 'Log de padrón | Listar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Listar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Listar log de roles</li>
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
                        <h3 class="card-title">Logs del padrón</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered log_rolls">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Acción</th>
                                <th>Administrador</th>
                                <th>Nombre previo</th>
                                <th>Apellido previo</th>
                                <th>Documento de identidad previo</th>
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

            var table = $('.log_rolls').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ action('\App\Http\Controllers\Backend\LogRollController@index') }}",
                columns: [
                    {
                        data: 'date',
                        name: 'date',
                    },
                    {
                        data: 'action_log',
                        name: 'action_log',
                    },
                    {
                        data: 'administrator',
                        name: 'administrator',
                    },
                    {
                        data: 'previous_name',
                        name: 'previous_name',
                    },
                    {
                        data: 'previous_last_name',
                        name: 'previous_last_name',
                    },
                    {
                        data: 'previous_dni',
                        name: 'previous_dni',
                    },
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
