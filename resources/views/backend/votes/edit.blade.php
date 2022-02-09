@extends('adminlte::page')

@section('title', 'Votes | Editar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
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
                    {{ Form::open(['url' => action('\App\Http\Controllers\Backend\VoteController@update', $element), 'method' => 'PUT', 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Votación</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('state_id', 'Estado') }}
                            {{ Form::select('state_id', $states, $element->state_id, ['class' => 'form-control '.($errors->has('state_id') ? 'is-invalid' : ''), 'placeholder' => 'Seleccionar estado', 'required' => 'required']) }}

                            @if ($errors->has('state_id'))
                                <span class="error invalid-feedback">{{ $errors->first('state_id') }}</span>
                            @endif
                        </div>
                        @if($element->state_id == 4 && !$element->mail_results_sended)
                            <div class="form-group">

                                <a href="{{ action('\App\Http\Controllers\Backend\VoteController@sendMailResults', $element) }}" class="btn btn-info">
                                    Notificar usuarios
                                </a>
                            </div>
                        @endif
                        <div class="form-group">
                            {{ Form::label('day_close_inscriptions', 'Día de cierre de inscripciones') }}
                            {{ Form::date('day_close_inscriptions', \Carbon\Carbon::parse($element->day_close_inscriptions)->format('Y-m-d'), ['class' => 'form-control '.($errors->has('day_close_inscriptions') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('day_close_inscriptions'))
                                <span class="error invalid-feedback">{{ $errors->first('day_close_inscriptions') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('day_start', 'Día de inicio de votación') }}
                            {{ Form::date('day_start', \Carbon\Carbon::parse($element->day_start)->format('Y-m-d'), ['class' => 'form-control '.($errors->has('day_start') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('day_start'))
                                <span class="error invalid-feedback">{{ $errors->first('day_start') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('day_finish', 'Día de finalización de votación') }}
                            {{ Form::date('day_finish', \Carbon\Carbon::parse($element->day_finish)->format('Y-m-d'), ['class' => 'form-control '.($errors->has('day_finish') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('day_finish'))
                                <span class="error invalid-feedback">{{ $errors->first('day_finish') }}</span>
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
