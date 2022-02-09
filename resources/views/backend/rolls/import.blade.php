@extends('adminlte::page')

@section('title', 'Padrón | Crear')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\RollController@index') }}">Lista de padrones</a></li>
                    <li class="breadcrumb-item active">Crear</li>
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
                    {{ Form::open(['url' => action('\App\Http\Controllers\Backend\RollController@importPost'), 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Importar padrón</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('file', 'Archivo') }}
                            {{ Form::file('file', ['class' => ''.($errors->has('file') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('file'))
                                <span class="error invalid-feedback">{{ $errors->first('file') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ Form::submit('Importar', ['class' => 'btn btn-success btn-lg float-right']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@stop
