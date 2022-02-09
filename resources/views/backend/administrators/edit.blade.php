@extends('adminlte::page')

@section('title', 'Administradores | Editar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\AdministratorController@index') }}">Lista de Administradores</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\AdministratorController@update', $element), 'method' => 'PUT', 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Administradores</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('name', 'Nombre') }}
                            {{ Form::text('name', $element->name, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('name'))
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::email('email', $element->email, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('email'))
                                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password') }}
                            {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('password'))
                                <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', 'Confirm Password') }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control '.($errors->has('password_confirmation') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('password_confirmation'))
                                <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('role', 'Rol') }}
                            {{ Form::select('role', $roles, $element->roles()->first()->id, ['class' => 'form-control '.($errors->has('role') ? 'is-invalid' : ''), 'required' => 'required', 'placeholder' => 'Seleccionar']) }}

                            @if ($errors->has('role'))
                                <span class="error invalid-feedback">{{ $errors->first('role') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ Form::submit('Guardar', ['class' => 'btn btn-success btn-lg float-right']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
@stop
