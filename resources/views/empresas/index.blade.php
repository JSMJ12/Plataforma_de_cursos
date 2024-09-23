@extends('adminlte::page')

@section('title', 'Lista de Usuarios')

@section('content_header')
    <h1>Empresas</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Lista de Empresas</h3>
        </div>

        <div class="card-body table-responsive">
            <table id="usuariosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Logo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->nombre }}</td>
                            <td>{{ $empresa->telefono }}</td>
                            <td>{{ $empresa->email }}</td>
                            <td>
                                @if ($empresa->logo)
                                    <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo" width="50">
                                @else
                                    No tiene logo
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('empresas.show', $empresa->id) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('empresas.edit', $empresa->id) }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST"
                                    style="display: inline-block;">
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
    </div>
@endsection
