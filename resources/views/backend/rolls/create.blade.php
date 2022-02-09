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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\RollController@store'), 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Padrón</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('name', 'Nombre') }}
                            {{ Form::text('name', null, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('name'))
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('last_name', 'Apellido') }}
                            {{ Form::text('last_name', null, ['class' => 'form-control '.($errors->has('last_name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('last_name'))
                                <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('dni', 'Documento de identidad') }}
                            {{ Form::text('dni', null, ['class' => 'form-control '.($errors->has('dni') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('dni'))
                                <span class="error invalid-feedback">{{ $errors->first('dni') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ Form::submit('Crear', ['class' => 'btn btn-success btn-lg float-right']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
@stop
