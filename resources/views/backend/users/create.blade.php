@extends('adminlte::page')

@section('title', 'Users | Crear')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\UserController@index') }}">Lista de usuarios</a></li>
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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\UserController@store'), 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('photos', 'Upload photos') }}
                            <div class="row">
                                <div class="col-12 col-sm-1">
                                    <div class="card text-center pt-3 bg-gradient-gray" id="uploadPhotos" style="cursor: pointer">
                                        <i class="fa fa-upload mb-2"></i>
                                        <p><strong>Upload</strong></p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-11">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title">Photos uploaded</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="row" id="photosUploaded">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::file('photos', ['class' => ''.($errors->has('photos') ? 'is-invalid' : ''), 'style' => 'visibility: hidden', 'multiple' => 'multiple']) }}

                            @if ($errors->has('upload_photos[]'))
                                <span class="error invalid-feedback">{{ $errors->first('upload_photos[]') }}</span>
                            @endif

                            @if ($errors->has('upload_photos'))
                                <span class="error invalid-feedback">{{ $errors->first('upload_photos') }}</span>
                            @endif

                            @if ($errors->has('upload_photos.*'))
                                <span class="error invalid-feedback">{{ $errors->first('upload_photos.*') }}</span>
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
                            {{ Form::label('dni', 'Documento de identidad') }}
                            {{ Form::text('dni', null, ['class' => 'form-control '.($errors->has('dni') ? 'is-invalid' : ''), 'required' => 'required', 'id' => 'inputDNI']) }}

                            @if ($errors->has('dni'))
                                <span class="error invalid-feedback">{{ $errors->first('dni') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::email('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('email'))
                                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password') }}
                            {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('password'))
                                <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', 'Confirm Password') }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control '.($errors->has('password_confirmation') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('password_confirmation'))
                                <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('active', 'Active?') }}
                            {{ Form::select('active', [0 => 'No', 1 => 'Sí'], 0, ['class' => 'form-control '.($errors->has('active') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('active'))
                                <span class="error invalid-feedback">{{ $errors->first('active') }}</span>
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

@push('css')
    <style>
        .deleteAttributeValue,
        .deleteUploadPhoto {
            position: absolute;
            top: 0;
            left: 90%;
        }

        .deleteAttributeValue span,
        .deleteUploadPhoto span {
            color: red;
            cursor: pointer;
        }


    </style>
@endpush

@push('js')

    <script>

        $(document).ready( () => {

            /** IMAGES */

            $('#uploadPhotos').click( () => {
                $('input[type="file"][name="photos"]').trigger('click');
            });

            function loadButtonDeleteUploadPhoto () {

                $('.deleteUploadPhoto').click(function() {

                    const parent = $(this).parent();

                    parent.remove();
                });
            }

            function loadPhotosUploaded(input) {

                if (input.files && input.files.length > 0) {

                    let formData = new FormData();

                    for (let i = 0; i < input.files.length; i++) {
                        formData.append("photos[]", input.files[i]);
                    }

                    $.ajax({
                        url: '/api/user-photos/upload',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: (responsePhotos) => {

                            responsePhotos.forEach( (photo, iPhoto) => {

                                let photoUploaded = $(
                                    '<div class="col-12 col-sm-2">' +
                                    '   <img src="/uploads/' + photo + '" class="img-fluid uploadedPhoto">' +
                                    '   <input type="hidden" name="upload_photos[]" value="' + photo + '" />' +
                                    '   <div class="deleteUploadPhoto">' +
                                    '       <span>X</span>' +
                                    '   </div>' +
                                    '</div>'
                                );

                                $('#photosUploaded').append(photoUploaded);
                            });

                            loadButtonDeleteUploadPhoto();
                            loadButtonsOrder();
                        },
                        error: (response) => {
                            console.log(data);
                        }
                    });
                }
            }

            $('input[type="file"][name="photos"]').change(function() {
                loadPhotosUploaded(this);
            });

            /** FORM SUBMIT */

            // Disable button once is clicked
            $('form').submit( (e) => {
                $('input[type="submit"]').attr('disabled', 'true');

                $.ajax({
                    method: "POST",
                    url: "/api/auth/valid-dni",
                    data: {
                        dni: $('#inputDNI').val(),
                    },
                })
                .done(( responseValidDNI ) => {
                    console.log(responseValidDNI);
                }).fail( (errorValidDNI) => {
                    if(errorValidDNI.status === 404) {
                        if(confirm('Atención! estás registrando a un votante que no se encuentra en el censo')) {
                            return true;
                        }
                    }
                });

            });

            /** END FORM SUBMIT */
        });

    </script>
@endpush
