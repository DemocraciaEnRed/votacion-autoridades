@extends('adminlte::page')

@section('title', 'Planchas | Editar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\PlateController@index') }}">Lista de planchas</a></li>
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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\PlateController@update', $element), 'method' => 'PUT', 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Plancha</h3>
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
                            {{ Form::label('description', 'Description') }}
                            {{ Form::text('description', $element->description, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('description'))
                                <span class="error invalid-feedback">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('logo', 'Logo') }}
                            {{ Form::file('logo', ['class' => ''.($errors->has('logo') ? 'is-invalid' : '')]) }}

                            <div>
                                @if($element->logo != '')

                                    <img src="{{ asset('uploads/'.$element->logo) }}" class="img-fluid" style="max-height: 75px;">
                                @endif
                            </div>

                            @if ($errors->has('logo'))
                                <span class="error invalid-feedback">{{ $errors->first('logo') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('link', 'Link') }}
                            {{ Form::text('link', $element->link, ['class' => 'form-control '.($errors->has('link') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('link'))
                                <span class="error invalid-feedback">{{ $errors->first('link') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('order', 'Órden') }}
                            {{ Form::text('order', $element->order, ['class' => 'form-control '.($errors->has('order') ? 'is-invalid' : '')]) }}

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
                                                {{ Form::checkbox('block'.$block->id, $block->id, !empty($element->blocks()->where('block_id', $block->id)->first()), ['class' => 'form-check-input', 'id' => 'block'.$block->id]) }}
                                                {{ Form::label('block'.$block->id, $block->name, ['class' => 'form-check-label']) }}
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
                        {{ Form::submit('Guardar', ['class' => 'btn btn-success btn-lg float-right']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
@stop
