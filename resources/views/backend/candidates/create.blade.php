@extends('adminlte::page')

@section('title', 'Candidatos | Crear')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\PlateController@index') }}">Lista de planchas</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\PlateController@edit', $plate) }}">{{ $plate->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\CandidateController@index', $plate) }}">Lista de candidatos</a></li>
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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\CandidateController@store', $plate), 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Candidato</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('position_id', 'Position') }}
                            {{ Form::select('position_id', $positions, null, ['class' => 'form-control '.($errors->has('position_id') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('position_id'))
                                <span class="error invalid-feedback">{{ $errors->first('position_id') }}</span>
                            @endif
                        </div>
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
                            {{ Form::label('photo', 'Photo') }}
                            {{ Form::file('photo', ['class' => ''.($errors->has('logo') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('photo'))
                                <span class="error invalid-feedback">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('link', 'Link') }}
                            {{ Form::text('link', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('link'))
                                <span class="error invalid-feedback">{{ $errors->first('link') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('order', 'Órden') }}
                            {{ Form::text('order', null, ['class' => 'form-control '.($errors->has('order') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('order'))
                                <span class="error invalid-feedback">{{ $errors->first('order') }}</span>
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
