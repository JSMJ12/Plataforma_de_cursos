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
                            <input type="text" name="dni" class="form-control" required>
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
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <!-- Segundo Nombre -->
                        <div class="form-group col-md-3">
                            <label for="name2">Segundo Nombre</label>
                            <input type="text" name="name2" class="form-control">
                        </div>
                        <!-- Apellido Paterno -->
                        <div class="form-group col-md-3">
                            <label for="apellidop">Apellido Paterno</label>
                            <input type="text" name="apellidop" class="form-control" required>
                        </div>
                        <!-- Apellido Materno -->
                        <div class="form-group col-md-3">
                            <label for="apellidom">Apellido Materno</label>
                            <input type="text" name="apellidom" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Celular</label>
                            <input type="text" name="celular" class="form-control" required>
                        </div>
                        <!-- Email -->
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Contraseña -->
                        <div class="form-group col-md-6">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Confirmar Contraseña -->
                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>
                    </div>
                    <hr class="my-4">

                    <div class="card-header text-white" style="background-color: rgb(70, 69, 72)">
                        <h4>Datos de la Empresa</h4>
                    </div>
                    <div class="card-body bg-light">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Empresa</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="sitio_web">Sitio Web</label>
                            <input type="url" name="sitio_web" class="form-control" placeholder="https://example.com">
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

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('image').addEventListener('change', function() {
                const imagePreview = document.getElementById('imagePreview');
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.style.backgroundImage = `url(${e.target.result})`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.backgroundImage = '';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');

            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.style.backgroundImage = `url(${e.target.result})`;
                        imagePreview.style.backgroundSize = 'cover';
                        imagePreview.style.backgroundPosition = 'center';
                        imagePreview.textContent = ''; // Clear any text content
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.backgroundImage = 'none';
                    imagePreview.textContent = 'Selecciona una imagen'; // Optional: Add a placeholder text
                }
            });
        });
    </script>
@endsection
