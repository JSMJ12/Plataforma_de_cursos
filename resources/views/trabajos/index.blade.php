@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Trabajos</h1>
        <a href="{{ route('trabajos.create') }}" class="btn btn-primary mb-3">Agregar Trabajo</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Salario</th>
                    <th>Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trabajos as $trabajo)
                    <tr>
                        <td>{{ $trabajo->titulo }}</td>
                        <td>{{ $trabajo->descripcion }}</td>
                        <td>{{ $trabajo->salario }}</td>
                        <td>{{ $trabajo->empresa->nombre }}</td>
                        <td>
                            <a href="{{ route('trabajos.show', $trabajo->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('trabajos.edit', $trabajo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('trabajos.destroy', $trabajo->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
