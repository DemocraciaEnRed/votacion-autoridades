@extends('adminlte::page')

@section('title', 'Usuarios | Editar')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\HomeController@index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ action('\App\Http\Controllers\Backend\UserController@index') }}">Lista de usuarios</a></li>
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
                {{ Form::open(['url' => action('\App\Http\Controllers\Backend\UserController@update', $element), 'method' => 'PUT', 'files' => true]) }}
                    <div class="card-header">
                        <h3 class="card-title">User</h3>
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
                                                @foreach($element->photos()->orderBy('order', 'asc')->get() as $photo)
                                                    <div class="col-12 col-sm-2 text-center">
                                                        <img src="{{ asset('uploads/'.$photo->filename) }}" class="img-fluid" style="width: 100px; height: 100px;">
                                                        <input type="hidden" name="upload_photos[]" value="{{ $photo->filename }}" />
                                                        <div class="deleteUploadedPhoto" data-photo-id="{{ $photo->id }}">
                                                            <span>X</span>
                                                        </div>
                                                    </div>
                                                @endforeach
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
                            {{ Form::text('name', $element->name, ['class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('name'))
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('last_name', 'Apellido') }}
                            {{ Form::text('last_name', $element->last_name, ['class' => 'form-control '.($errors->has('last_name') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('last_name'))
                                <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('dni', 'Documento de identidad') }}
                            {{ Form::text('dni', $element->dni, ['class' => 'form-control '.($errors->has('dni') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('dni'))
                                <span class="error invalid-feedback">{{ $errors->first('dni') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::email('email', $element->email, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('email'))
                                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password') }}
                            {{ Form::password('password', ['class' => 'form-control '.($errors->has('password') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('password'))
                                <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', 'Confirm Password') }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control '.($errors->has('password_confirmation') ? 'is-invalid' : '')]) }}

                            @if ($errors->has('password_confirmation'))
                                <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('active', 'Activo?') }}
                            {{ Form::select('active', [0 => 'No', 1 => 'Sí'], $element->active, ['class' => 'form-control '.($errors->has('active') ? 'is-invalid' : ''), 'required' => 'required']) }}

                            @if ($errors->has('active'))
                                <span class="error invalid-feedback">{{ $errors->first('active') }}</span>
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

@push('css')
    <style>
        .deleteUploadPhoto,
        .deleteUploadedPhoto {
            position: absolute;
            top: 0;
            left: 90%;
        }

        .deleteUploadPhoto span,
        .deleteUploadedPhoto span {
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

            function loadButtonDeleteUploadPhoto (i) {

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
                                    '<div class="col-12 col-sm-2 text-center">' +
                                    '   <img src="/uploads/' + photo + '" class="img-fluid uploadedPhoto" style="width: 100px; height: 100px;">' +
                                    '   <input type="hidden" name="upload_photos[]" value="' + photo + '" />' +
                                    '   <div class="deleteUploadPhoto">' +
                                    '       <span>X</span>' +
                                    '   </div>' +
                                    '</div>'
                                );

                                $('#photosUploaded').append(photoUploaded);
                            });

                            loadButtonDeleteUploadPhoto();
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

            $('.deleteUploadedPhoto').click(function() {

                if(confirm('Are you sure want delete this photo?')) {
                    const parent = $(this).parent();
                    const idPhoto = $(this).attr('data-photo-id');

                    $.ajax({
                        url: '/api/user-photos/' + idPhoto,
                        type: 'DELETE',
                        success: (response) => {

                            Swal.fire({
                                title: response.message,
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: "Ok"
                            });
                        },
                        error: (response) => {
                            console.log(data);
                        }
                    });

                    parent.remove();
                }

            });

            /** END IMAGES **/

            /** FORM SUBMIT */

            // Disable button once is clicked
            $('form').submit( (e) => {
                $('input[type="submit"]').attr('disabled', 'true');
            });

            /** END FORM SUBMIT */
        });

    </script>
@endpush
