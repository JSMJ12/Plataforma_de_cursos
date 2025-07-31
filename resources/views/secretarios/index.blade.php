@extends('adminlte::page')

@section('title', 'Lista de Capacitadores')

@section('content_header')
    <h1>Secretarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Secretarios</h3>
        </div>
        <div class="card-body table-responsive">
            <table id="capacitadoresTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Cedula/Pasaporte</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Celular</th>
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
            $('#capacitadoresTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('usuarios.secretarios') }}',
                columns: [
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'dni', name: 'dni' },
                    { data: 'name', name: 'name' },
                    { data: 'apellidop', name: 'apellidop' },
                    { data: 'email', name: 'email' },
                    { data: 'ciudad', name: 'ciudad' },
                    { data: 'celular', name: 'celular' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
