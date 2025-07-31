@extends('adminlte::page')

@section('title', 'Lista de Empresas')

@section('content_header')
    <h1>Empresas</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Lista de Empresas</h3>
        </div>

        <div class="card-body table-responsive">
            <table id="empresasTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Logo</th>
                        <th>Encargado</th> <!-- Nueva columna para el encargado -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#empresasTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('empresas.index') }}',
                columns: [
                    { data: 'nombre', name: 'nombre' },
                    { data: 'direccion', name: 'direccion' },
                    { data: 'telefono', name: 'telefono' },
                    { data: 'email', name: 'email' },
                    { data: 'logo', name: 'logo', orderable: false, searchable: false },
                    { data: 'usuario', name: 'usuario', orderable: false, searchable: false } 
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection
