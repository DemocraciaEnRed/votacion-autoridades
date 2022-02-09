@extends('adminlte::page')

@section('title', 'Planchas | Crear')

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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\PlateController@store'), 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Plancha</h3>
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
                            {{ Form::label('description', 'Description') }}
                            {{ Form::text('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('description'))
                                <span class="error invalid-feedback">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('logo', 'Logo') }}
                            {{ Form::file('logo', ['class' => ''.($errors->has('logo') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('logo'))
                                <span class="error invalid-feedback">{{ $errors->first('logo') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('link', 'Link') }}
                            {{ Form::text('link', null, ['class' => 'form-control '.($errors->has('link') ? 'is-invalid' : '')]) }}

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

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Bloques</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($blocks as $block)
                                        <div class="col-12 col-sm-4">
                                            <div class="form-check">
                                                {{ Form::checkbox('blocks[]', $block->id, 0, ['class' => 'form-check-input']) }}
                                                {{ Form::label('blocks[]', $block->name, ['class' => 'form-check-label']) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($errors->has('blocks[]'))
                                    <span class="error invalid-feedback">{{ $errors->first('blocks') }}</span>
                                @endif

                                @if ($errors->has('blocks'))
                                    <span class="error invalid-feedback">{{ $errors->first('blocks') }}</span>
                                @endif

                                @if ($errors->has('blocks.*'))
                                    <span class="error invalid-feedback">{{ $errors->first('blocks.*') }}</span>
                                @endif

                            </div>
                            <div class="card-footer">
                            </div>
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
