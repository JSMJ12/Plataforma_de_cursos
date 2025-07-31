@extends('adminlte::page')

@section('title', 'Trabajos')

@section('content_header')
    <h1>Crear Trabajo</h1>
@stop

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Publicar un Nuevo Trabajo</h2>
    <div class="card p-4 shadow-sm">
        <form action="{{ route('trabajos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="empresa_id" value="{{ Auth::user()->empresas->first()->id }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="titulo">Título del Trabajo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                        </div>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="ubicacion">Ubicación</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipo_contrato">Tipo de Contrato</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                        </div>
                        <select name="tipo_contrato" id="tipo_contrato" class="form-control" required>
                            <option value="fijo">Fijo</option>
                            <option value="temporal">Temporal</option>
                            <option value="practicante">Practicante</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="salario">Salario</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="number" step="0.01" name="salario" id="salario" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción del Trabajo</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                    </div>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="requisitos">Requisitos</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                    </div>
                    <textarea name="requisitos" id="requisitos" class="form-control" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha_publicacion">Fecha de Publicación</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" name="fecha_publicacion" id="fecha_publicacion" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="fecha_limite">Fecha Límite</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                        </div>
                        <input type="date" name="fecha_limite" id="fecha_limite" class="form-control" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-block">Publicar Trabajo</button>
        </form>
    </div>
</div>
@stop

