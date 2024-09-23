@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Agregar Trabajo</h1>

        <form action="{{ route('trabajos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="salario">Salario</label>
                <input type="number" name="salario" class="form-control">
            </div>
            <div class="form-group">
                <label for="empresa_id">Empresa</label>
                <select name="empresa_id" class="form-control">
                    @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
