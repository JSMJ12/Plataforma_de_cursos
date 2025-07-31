@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Usuario</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="role">Rol</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="Capacitador">Capacitador</option>
                                <option value="Participante">Participante</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Secretario/a EPSU">Secretaria/o EPSU</option>
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DNI -->
                        <div class="form-group">
                            <label for="dni">Cedula/Pasaporte</label>
                            <input type="text" name="dni" id="dni" class="form-control" required value="{{ old('dni') }}">
                            @error('dni')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Segundo Nombre -->
                        <div class="form-group">
                            <label for="name2">Segundo Nombre</label>
                            <input type="text" name="name2" id="name2" class="form-control" value="{{ old('name2') }}">
                            @error('name2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Apellido Paterno -->
                        <div class="form-group">
                            <label for="apellidop">Apellido Paterno</label>
                            <input type="text" name="apellidop" id="apellidop" class="form-control" required value="{{ old('apellidop') }}">
                            @error('apellidop')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Apellido Materno -->
                        <div class="form-group">
                            <label for="apellidom">Apellido Materno</label>
                            <input type="text" name="apellidom" id="apellidom" class="form-control" value="{{ old('apellidom') }}">
                            @error('apellidom')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ciudad -->
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control" value="{{ old('ciudad') }}">
                            @error('ciudad')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Celular -->
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" name="celular" id="celular" class="form-control" required value="{{ old('celular') }}">
                            @error('celular')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Nivel de Estudio -->
                        <div class="form-group">
                            <label for="nivel_estudio">Nivel de Estudio</label>
                            <input type="text" name="nivel_estudio" id="nivel_estudio" class="form-control" value="{{ old('nivel_estudio') }}">
                            @error('nivel_estudio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Título -->
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}">
                            @error('titulo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Especialidad -->
                        <div class="form-group">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" name="especialidad" id="especialidad" class="form-control" value="{{ old('especialidad') }}">
                            @error('especialidad')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Años de Experiencia -->
                        <div class="form-group">
                            <label for="anos_experiencia">Años de Experiencia</label>
                            <input type="number" name="anos_experiencia" id="anos_experiencia" class="form-control" value="{{ old('anos_experiencia') }}">
                            @error('anos_experiencia')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Edad -->
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad') }}">
                            @error('edad')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sexo -->
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('sexo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Imagen -->
                        <div class="form-group">
                            <label for="image">Foto de Perfil</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-custom">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop