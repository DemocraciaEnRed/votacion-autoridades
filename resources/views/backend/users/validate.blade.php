@extends('adminlte::page')

@section('title', 'Users | Validate')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\UserController@index') }}">Users list</a></li>
                    <li class="breadcrumb-item active">Validar</li>
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

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Validate user</h3>
                    </div>
                    <div class="card-body">

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Photos</h3>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    @foreach($user->photos as $photo)
                                        <div class="col-12 col-sm-4">
                                            <img src="{{ asset('/uploads/'.$photo->filename) }}" class="img-responsive" style="max-height: 200px;">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="card-footer">

                            </div>
                        </div>

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Información:</h3>
                            </div>
                            <div class="card-body">
                                <h5><strong>Nombre:</strong> {{ $user->name }}</h5>
                                <h5><strong>Apellido:</strong> {{ $user->last_name }}</h5>
                                <h5><strong>Documento de identidad:</strong> {{ $user->dni }}</h5>

                            </div>
                            <div class="card-footer">

                            </div>
                        </div>

                    </div>
                    <div class="card-footer">

                        <div class="d-flex align-items-center justify-content-end">
                            {{ Form::open(['url' => action('\App\Http\Controllers\Backend\UserController@validateUser', [$index, $user]), 'files' => true]) }}

                            {{ Form::hidden('validate', 1) }}
                            {{ Form::submit('Aprobar', ['class' => 'btn btn-success btn-lg  mr-2']) }}

                            {{ Form::close() }}

                            {{ Form::open(['url' => action('\App\Http\Controllers\Backend\UserController@validateUser', [$index, $user]), 'files' => true]) }}

                            {{ Form::hidden('validate', 0) }}
                            {{ Form::submit('Desaprobar', ['class' => 'btn btn-danger btn-lg']) }}

                            {{ Form::close() }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
@stop

@push('css')

@endpush

@push('js')

@endpush
