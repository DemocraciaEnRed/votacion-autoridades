@extends('adminlte::page')

@section('title', 'Roles | Editar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\RoleController@index') }}">Lista de roles</a></li>
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
                    {{ Form::open(['url' => action('\App\Http\Controllers\Backend\RoleController@editPermissions', $element), 'files' => true]) }}

                    {{ Form::hidden('id', $element->id) }}

                    <div class="d-none" id="permissions-selected">

                    </div>

                    <div class="card-header">
                        <h3 class="card-title">Permisos del rol</h3>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-checkable no-datatable">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td></td>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
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

@push('js')
    <script>

        /** FUNCIONES */

        function initTable(idRole) {

            $.ajax({
                url: "/api/roles/" + idRole,
                method: 'GET',
            }).done( (response) => {

                let permissions = [];
                response.permissions.forEach( (permission, iPermission) => {
                    permissions.push(permission.id);
                });

                table.rows( ( idx, data, node) => {

                    if(permissions.includes(parseInt(data[1]))) {

                        let set = $(node).find('td:first-child .checkable');
                        $(set).prop('checked', true);
                        $(node).toggleClass('active');
                    }
                });

            }).fail( () => {
                Swal.fire("¡Error!", "Error al obtener el rol del usuario", "error");
            });
        }

        /** END HELPER FUNCTIONS */

        let table = null;

        $(document).ready( () => {

            table = $('table').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },

                headerCallback: function(thead, data, start, end, display) {
                    thead.getElementsByTagName('th')[0].innerHTML = `
                    <label class="checkbox checkbox-single">
                        <input type="checkbox" value="" class="group-checkable"/>
                        <span></span>
                    </label>`;
                },

                columnDefs: [
                    {
                        targets: 0,
                        width: '30px',
                        className: 'dt-left',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `
                        <label class="checkbox checkbox-single">
                            <input type="checkbox" value="" class="checkable"/>
                            <span></span>
                        </label>`;
                        },
                    },
                    {
                        targets: 1,
                        visible: false,
                        searchable: false
                    },
                ],
            });

            table.on('change', '.group-checkable', function() {
                let set = $(this).closest('table').find('td:first-child .checkable');
                let checked = $(this).is(':checked');

                $(set).each(function() {
                    if (checked) {
                        $(this).prop('checked', true);
                        $(this).closest('tr').addClass('active');
                    }
                    else {
                        $(this).prop('checked', false);
                        $(this).closest('tr').removeClass('active');
                    }
                });
            });

            table.on('change', 'tbody tr .checkbox', function() {
                $(this).parents('tr').toggleClass('active');
            });

            $('form').submit( (e) => {

                let rowsSelected = table.rows('.active').data();

                $('#permissions-selected').empty();
                for(let i = 0; i < rowsSelected.length; i++) {
                    let row = rowsSelected[i];

                    $('#permissions-selected').append(
                        '<input type="hidden" name="permissions[]" value="' + parseInt(row[1]) + '">'
                    );
                }
            });

            initTable($('input[name="id"]').val());
        });
    </script>
@endpush