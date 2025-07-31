@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4 text-black font-weight-bold">Registro de Empresa</h1>

        <div class="card-body bg-light">
            <div class="card-header text-white" style="background-color: #218838">
                <h4>Datos Personales</h4>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <!-- Cédula -->
                        <div class="form-group col-md-6">
                            <label for="dni">Cédula / Pasaporte</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="dni" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="image">Foto:</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <!-- Segundo Nombre -->
                        <div class="form-group col-md-3">
                            <label for="name2">Segundo Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name2" class="form-control">
                            </div>
                        </div>
                        <!-- Apellido Paterno -->
                        <div class="form-group col-md-3">
                            <label for="apellidop">Apellido Paterno</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="apellidop" class="form-control" required>
                            </div>
                        </div>
                        <!-- Apellido Materno -->
                        <div class="form-group col-md-3">
                            <label for="apellidom">Apellido Materno</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="apellidom" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="celular">Celular</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="celular" class="form-control" required>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Contraseña -->
                        <div class="form-group col-md-6">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Confirmar Contraseña -->
                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">

                    <div class="card-header text-white" style="background-color: rgb(70, 69, 72)">
                        <h4>Datos de la Empresa</h4>
                    </div>
                    <div class="card-body bg-light">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Empresa</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="direccion" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_contacto">Email de Contacto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email_contacto" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sitio_web">Sitio Web</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                <input type="url" name="sitio_web" class="form-control" placeholder="https://example.com">
                            </div>
                            <small class="form-text text-muted">Por favor, ingrese una URL válida.</small>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" class="form-control-file" accept="image/*" required>
                            <small class="form-text text-muted">Solo se permiten imágenes (JPG, PNG, GIF).</small>
                        </div>

                        <button type="submit" class="btn btn-success">Registrar Empresa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/empresas_create.css') }}" rel="stylesheet">
@endsection
