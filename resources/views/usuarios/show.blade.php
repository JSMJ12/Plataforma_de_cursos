@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
    <h1>Detalles del Usuario</h1>
@stop

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header bg-success text-white text-center">
                <h1 class="m-0">{{ $user->apellidop }} {{ $user->apellidom }} {{ $user->name }} {{ $user->name2 }}</h1>
            </div>
            <div class="card-body text-center">
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Imagen de {{ $user->name }}" style="width: 200px; height: 200px; border-radius: 5px;">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            @if ($user->dni)
                                <tr>
                                    <th>Cedula/Pasaporte</th>
                                    <td>{{ $user->dni }}</td>
                                </tr>
                            @endif
                            @if ($user->name || $user->name2)
                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $user->name }} {{ $user->name2 }}</td>
                                </tr>
                            @endif
                            @if ($user->apellidop || $user->apellidom)
                                <tr>
                                    <th>Apellido</th>
                                    <td>{{ $user->apellidop }} {{ $user->apellidom }}</td>
                                </tr>
                            @endif
                            @if ($user->email)
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @endif
                            @if ($user->ciudad)
                                <tr>
                                    <th>Ciudad</th>
                                    <td>{{ $user->ciudad }}</td>
                                </tr>
                            @endif
                            @if ($user->celular)
                                <tr>
                                    <th>Celular</th>
                                    <td>{{ $user->celular }}</td>
                                </tr>
                            @endif
                            @if ($user->nivel_estudio)
                                <tr>
                                    <th>Nivel de Estudio</th>
                                    <td>{{ $user->nivel_estudio }}</td>
                                </tr>
                            @endif
                            @if ($user->titulo)
                                <tr>
                                    <th>Título</th>
                                    <td>{{ $user->titulo }}</td>
                                </tr>
                            @endif
                            @if ($user->especialidad)
                                <tr>
                                    <th>Especialidad</th>
                                    <td>{{ $user->especialidad }}</td>
                                </tr>
                            @endif
                            @if ($user->anos_experiencia)
                                <tr>
                                    <th>Años de Experiencia</th>
                                    <td>{{ $user->anos_experiencia }}</td>
                                </tr>
                            @endif
                            @if ($user->edad)
                                <tr>
                                    <th>Edad</th>
                                    <td>{{ $user->edad }}</td>
                                </tr>
                            @endif
                            @if ($user->sexo)
                                <tr>
                                    <th>Sexo</th>
                                    <td>{{ $user->sexo }}</td>
                                </tr>
                            @endif
                            @if ($user->interes)
                                <tr>
                                    <th>Intereses</th>
                                    <td>{{ $user->interes }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
