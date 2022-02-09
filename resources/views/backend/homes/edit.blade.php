@extends('adminlte::page')

@section('title', 'Home | Editar')

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
                    {{ Form::open(['url' => action('\App\Http\Controllers\Backend\HomeController@update', $element), 'method' => 'PUT', 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Home</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('extra_information', 'Información Extra') }}
                            {{ Form::textarea('extra_information', $element->extra_information, ['class' => 'form-control '.($errors->has('extra_information') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('extra_information'))
                                <span class="error invalid-feedback">{{ $errors->first('extra_information') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('filename', 'Nombre del archivo') }}
                            {{ Form::text('filename', $element->filename, ['class' => 'form-control '.($errors->has('filename') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('filename'))
                                <span class="error invalid-feedback">{{ $errors->first('filename') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('file', 'Archivo') }}
                            {{ Form::file('file', ['class' => ''.($errors->has('file') ? 'is-invalid' : '')]) }}

                            <div>
                                @if($element->file != '')
                                    <a href="{{ asset('uploads/'.$element->file) }}" download="{{ $element->file }}">Ver archivo</a>
                                @endif
                            </div>

                            @if ($errors->has('file'))
                                <span class="error invalid-feedback">{{ $errors->first('file') }}</span>
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
