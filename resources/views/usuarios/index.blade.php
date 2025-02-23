@extends('adminlte::page')

@section('title', 'Lista de Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    
    <div class="card">
        <div class="card-header text-white" style="background-color: #036f1b;">
            <h3 class="card-title">Listado de Usuarios</h3>
            <div class="card-tools">
                <a href="{{ route('usuarios.create.administrador') }}" class="btn btn-light btn-sm"><i class="fas fa-plus"></i> Agregar
                    nuevo</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table id="usuariosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cedula/Pasaporte</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Celular</th>
                        <th>Roles</th> <!-- Nueva columna para roles -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos serán cargados por DataTables -->
                </tbody>
            </table>
        </div>
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function () {
            $('#usuariosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('usuarios.index') }}',
                columns: [
                    { data: 'dni', name: 'dni' },
                    { data: 'name', name: 'name' },
                    { data: 'apellidop', name: 'apellidop' },
                    { data: 'email', name: 'email' },
                    { data: 'ciudad', name: 'ciudad' },
                    { data: 'celular', name: 'celular' },
                    { data: 'roles', name: 'roles' }, <!-- Nueva columna para roles -->
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop


    