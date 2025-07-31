@extends('adminlte::page')

@section('title', 'Lista de Capacitadores')

@section('content_header')
    <h1>Capacitadores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header text-white" style="background-color: #036f1b;">
            <h3 class="card-title">Lista de Capacitadores</h3>
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
                        <th>Título</th>
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
                ajax: '{{ route('usuarios.capacitadores') }}', // Ruta para cargar datos
                columns: [
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'dni', name: 'dni' },
                    { data: 'name', name: 'name' },
                    { data: 'apellidop', name: 'apellidop' },
                    { data: 'email', name: 'email' },
                    { data: 'ciudad', name: 'ciudad' },
                    { data: 'celular', name: 'celular' },
                    { data: 'titulo', name: 'titulo' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
