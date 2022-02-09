@extends('adminlte::page')

@section('title', 'Designaciones')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Listar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\DesignationController@index') }}">Designaciones</a></li>
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

                    {{ Form::open(['url' => action('\App\Http\Controllers\Backend\DesignationController@store'), 'files' => true]) }}

                    <div class="card-header">
                        <h3 class="card-title">Designaciones</h3>
                        <div class="card-tools">
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach($blocks as $block)

                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $block->name }}</h3>
                                    <div class="card-tools">

                                    </div>
                                </div>

                                <div class="card-body">

                                    @foreach($block->positions as $position)
                                        <div class="form-group">
                                            {{ Form::label('position_'.$position->id, $position->name) }}
                                            {{ Form::select('position_'.$position->id, $position->candidates_for_select, $position->candidate_selected, ['class' => 'form-control '.($errors->has('position_'.$position->id) ? 'is-invalid' : ''), 'placeholder' => 'Seleccionar candidato', 'required' => 'required']) }}

                                            @if ($errors->has('position_'.$position->id))
                                                <span class="error invalid-feedback">{{ $errors->first('position_'.$position->id) }}</span>
                                            @endif
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        @endforeach
                    </div>

                    <div class="card-footer">
                        {{ Form::submit('Guardar', ['class' => 'btn btn-success btn-lg float-right']) }}
                    </div>
                    s
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script>

    </script>
@endpush
