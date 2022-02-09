@extends('adminlte::page')

@section('title', 'Resultados de la votación')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Resultados de la votación</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Resultados de la votación</li>
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

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="results-tab" data-toggle="tab" data-target="#results" type="button" role="tab" aria-controls="results" aria-selected="true">Resultados</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="users-tab" data-toggle="tab" data-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Usuarios</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="statistics-tab" data-toggle="tab" data-target="#statistics" type="button" role="tab" aria-controls="statistics" aria-selected="false">Estadísticas</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="results" role="tabpanel" aria-labelledby="results-tab">
                        <div class="card">
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

                                            @foreach($block->votes as $voteResult)
                                                <p class="mb-0 mt-3">{{ $voteResult->plate->name }}</p>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $voteResult->percentage }}%;" aria-valuenow="{{ $voteResult->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $voteResult->percentage }}%
                                                    </div>
                                                </div>
                                                <small><strong>Cantidad de votos:</strong> {{ $voteResult->votes }}</small>
                                            @endforeach

                                                <p class="mb-0 mt-3">Votos en blanco</p>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $block->votes_blank->percentage }}%;" aria-valuenow="{{ $block->votes_blank->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $block->votes_blank->percentage }}%
                                                    </div>
                                                </div>
                                                <small><strong>Cantidad de votos:</strong> {{ $block->votes_blank->votes }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Usuarios que votaron</h3>
                                <div class="card-tools">

                                </div>
                            </div>

                            <div class="card-body">

                                <table class="table table-bordered users-voted">
                                    <thead>
                                    <tr>
                                        <th>Fecha en que votó</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($usersVote as $userVote)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($userVote->vote_date)->setTimezone('America/Bogota')->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="staticstics-tab">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Estadísticas</h3>
                                <div class="card-tools">

                                </div>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="card bg-light mb-3" style="max-width: 18rem;">
                                            <div class="card-header">Usuarios</div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <h6><strong>REGISTRADOS</strong></h6>
                                                        <h4>{{ count($allUsers) }}</h4>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <h6><strong>ACTIVADOS</strong></h6>
                                                        <h4>{{ count($usersAvailableForVote) }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="card bg-light mb-3" style="max-width: 18rem;">
                                            <div class="card-header">Conversión</div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <h6><strong>YA VOTARON</strong></h6>
                                                        <h4>{{ count($usersVote) }}</h4>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <h6><strong>FALTAN VOTAR</strong></h6>
                                                        <h4>{{ count($usersDontVote) }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="card bg-light mb-3" style="max-width: 18rem;">
                                            <div class="card-header">Padrón</div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <h6><strong>REGISTRADOS</strong></h6>
                                                        <h4>{{ count($allRolls) }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')

    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/lang/de_DE.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/geodata/germanyLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/fonts/notosans-sc.js"></script>

    <script>
        $(function () {

            var table = $('.users-voted').DataTable({
                columns: [
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'voted_date',
                        name: 'voted_date',
                    },
                ]
            });

        });
    </script>
@endpush
