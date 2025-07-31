@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Empresa</h1>
        
        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $empresa->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ $empresa->direccion }}">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ $empresa->telefono }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $empresa->email }}" required>
            </div>
            <div class="form-group">
                <label for="sitio_web">Sitio Web</label>
                <input type="text" name="sitio_web" class="form-control" value="{{ $empresa->sitio_web }}">
            </div>
            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" name="logo" class="form-control-file">
                @if ($empresa->logo)
                    <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo" width="50">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
