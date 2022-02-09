@extends('adminlte::page')

@section('title', 'Resultados de la votación')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cargar votos manualmente</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Cargar votos manualmente</li>
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

                    {{ Form::open(['url' => action('\App\Http\Controllers\Backend\VoteResultController@loadVotesManuallyPost'), 'files' => true]) }}

                    <div class="card-header">
                        <h3 class="card-title">Resultados</h3>
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

                                    @foreach($block->plates as $blockPlate)

                                        <div class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <h6 class="mr-3">{{ $blockPlate->plate->name }}</h6>
                                                {{ Form::text('vote_'.$block->id.'_'.$blockPlate->plate->id, 0, ['class' => 'form-control']) }}
                                            </div>
                                            <small><strong>Cantidad de votos manuales:</strong> {{ $block->votes()->where('plate_id', $blockPlate->plate->id)->first()->manuals }}</small>
                                        </div>
                                    @endforeach

                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="mr-3">Voto en blanco</h6>
                                                {{ Form::text('vote_'.$block->id.'_blank', 0, ['class' => 'form-control']) }}
                                            </div>
                                            <small><strong>Cantidad de votos manuales:</strong> {{ $block->votes_blank->manuals }}</small>
                                        </div>
                                </div>
                            </div>
                        @endforeach
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

@push('js')
    <script>

    </script>
@endpush
