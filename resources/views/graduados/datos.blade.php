@extends('adminlte::page')

@section('title', 'Actualización de Datos Graduados')

@section('content_header')
    <h1>Actualización de Datos Graduados</h1>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('graduados.update', Auth::user()->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tarjeta principal -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Datos de Graduación</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Programa de Maestría -->
                        <div class="col-md-6 mb-3">
                            <label for="programa_maestria" class="form-label">Programa de Maestría Completado:</label>
                            <input type="text" class="form-control" id="programa_maestria" name="programa_maestria"
                                value="{{ old('programa_maestria', $graduado->programa_maestria) }}">
                        </div>

                        <!-- Fecha de Graduación -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha_graduacion" class="form-label">Fecha de Graduación:</label>
                            <input type="date" class="form-control" id="fecha_graduacion" name="fecha_graduacion"
                                value="{{ old('fecha_graduacion', $graduado->fecha_graduacion) }}" required>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Datos Laborales -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Datos Laborales</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Empleos desde la graduación -->
                        <div class="col-md-6 mb-3">
                            <label for="empleos_desde_graduacion" class="form-label">Empleos Desde la Graduación:</label>
                            <select class="form-control" id="empleos_desde_graduacion" name="empleos_desde_graduacion">
                                <option value="0" {{ $graduado->empleos_desde_graduacion == 0 ? 'selected' : '' }}>0
                                </option>
                                <option value="1" {{ $graduado->empleos_desde_graduacion == 1 ? 'selected' : '' }}>1
                                </option>
                                <option value="2" {{ $graduado->empleos_desde_graduacion == 2 ? 'selected' : '' }}>2
                                </option>
                                <option value="3" {{ $graduado->empleos_desde_graduacion == 3 ? 'selected' : '' }}>3
                                </option>
                                <option value="4_mas"
                                    {{ $graduado->empleos_desde_graduacion == '4_mas' ? 'selected' : '' }}>4 o más</option>
                            </select>
                        </div>

                        <!-- Actualmente empleado -->
                        <div class="col-md-6 mb-3">
                            <label for="empleado_actualmente" class="form-label">¿Está Actualmente Empleado?</label>
                            <select class="form-control" id="empleado_actualmente" name="empleado_actualmente" required>
                                <option value="" {{ $graduado->empleado_actualmente == '' ? 'selected' : '' }}>
                                    Seleccione una opción</option>
                                <option value="Sí" {{ $graduado->empleado_actualmente == 'Sí' ? 'selected' : '' }}>Sí
                                </option>
                                <option value="No" {{ $graduado->empleado_actualmente == 'No' ? 'selected' : '' }}>No
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Datos laborales adicionales (aparecen solo si está empleado) -->
                    <div id="datos_laborales"
                        style="{{ $graduado->empleado_actualmente == 'Sí' ? 'display: block;' : 'display: none;' }}">
                        <div class="row">
                            <!-- Nombre de la empresa -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre_empresa" class="form-label">Nombre de la Empresa:</label>
                                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa"
                                    value="{{ $graduado->nombre_empresa }}">
                            </div>

                            <!-- Cargo actual -->
                            <div class="col-md-6 mb-3">
                                <label for="cargo_actual" class="form-label">Cargo Actual:</label>
                                <input type="text" class="form-control" id="cargo_actual" name="cargo_actual"
                                    value="{{ $graduado->cargo_actual }}">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Trabajo vinculado -->
                            <div class="col-md-6 mb-3">
                                <label for="trabajo_vinculado" class="form-label">¿El Trabajo Está Vinculado al Programa de
                                    Maestría Estudiado?</label>
                                <select class="form-control" id="trabajo_vinculado" name="trabajo_vinculado">
                                    <option value="No" {{ $graduado->trabajo_vinculado == 'No' ? 'selected' : '' }}>No
                                    </option>
                                    <option value="" {{ $graduado->trabajo_vinculado == '' ? 'selected' : '' }}>
                                        Seleccione una opción</option>
                                    <option value="totalmente"
                                        {{ $graduado->trabajo_vinculado == 'totalmente' ? 'selected' : '' }}>Sí, totalmente
                                    </option>
                                    <option value="parcialmente"
                                        {{ $graduado->trabajo_vinculado == 'parcialmente' ? 'selected' : '' }}>Sí,
                                        parcialmente
                                    </option>
                                </select>
                            </div>

                            <!-- Años de experiencia laboral -->
                            <div class="col-md-6 mb-3">
                                <label for="anos_experiencia_laboral" class="form-label">Años de Experiencia
                                    Laboral:</label>
                                <select class="form-control" id="anos_experiencia_laboral" name="anos_experiencia_laboral">
                                    <option value="Menos_de_1"
                                        {{ $graduado->anos_experiencia_laboral == 'Menos_de_1' ? 'selected' : '' }}>Menos
                                        de 1 año</option>
                                    <option value="1-3"
                                        {{ $graduado->anos_experiencia_laboral == '1-3' ? 'selected' : '' }}>1-3 años
                                    </option>
                                    <option value="4-6"
                                        {{ $graduado->anos_experiencia_laboral == '4-6' ? 'selected' : '' }}>4-6 años
                                    </option>
                                    <option value="7-10"
                                        {{ $graduado->anos_experiencia_laboral == '7-10' ? 'selected' : '' }}>7-10 años
                                    </option>
                                    <option value="Mas_de_10"
                                        {{ $graduado->anos_experiencia_laboral == 'Mas_de_10' ? 'selected' : '' }}>Más de
                                        10 años</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desarrollo Profecional -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Desarrollo Profesional</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Estudios adicionales -->
                        <div class="col-md-6 mb-3">
                            <label for="estudios_adicionales" class="form-label">¿Ha realizado estudios adicionales
                                (cursos, diplomados, otro posgrado) desde su graduación?</label>
                            <select class="form-control" id="estudios_adicionales" name="estudios_adicionales" required>
                                <option value="" {{ $graduado->estudios_adicionales == '' ? 'selected' : '' }}>
                                    Seleccione una opción</option>
                                <option value="Sí" {{ $graduado->estudios_adicionales == 'Sí' ? 'selected' : '' }}>Sí
                                </option>
                                <option value="No" {{ $graduado->estudios_adicionales == 'No' ? 'selected' : '' }}>No
                                </option>
                            </select>
                        </div>

                        <!-- Actividades de desarrollo profesional continuo -->
                        <div class="col-md-6 mb-3">
                            <label for="desarrollo_profesional_continuo" class="form-label">¿Participa en actividades de
                                desarrollo profesional continuo (conferencias, talleres, seminarios)?</label>
                            <select class="form-control" id="desarrollo_profesional_continuo"
                                name="desarrollo_profesional_continuo" required>
                                <option value=""
                                    {{ $graduado->desarrollo_profesional_continuo == '' ? 'selected' : '' }}>Seleccione una
                                    opción</option>
                                <option value="Sí"
                                    {{ $graduado->desarrollo_profesional_continuo == 'Sí' ? 'selected' : '' }}>Sí</option>
                                <option value="No"
                                    {{ $graduado->desarrollo_profesional_continuo == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluación del Programa -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Evaluación del Programa</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Pertinencia de la formación -->
                        <div class="col-md-6 mb-3">
                            <label for="pertinencia_formacion" class="form-label">¿La Formación fue Pertinente?</label>
                            <select class="form-control" id="pertinencia_formacion" name="pertinencia_formacion">
                                <option value="totalmente"
                                    {{ $graduado->pertinencia_formacion == 'totalmente' ? 'selected' : '' }}>Totalmente
                                    pertinente</option>
                                <option value="pertinente"
                                    {{ $graduado->pertinencia_formacion == 'pertinente' ? 'selected' : '' }}>Pertinente
                                </option>
                                <option value="poco_pertinente"
                                    {{ $graduado->pertinencia_formacion == 'poco_pertinente' ? 'selected' : '' }}>Poco
                                    pertinente</option>
                                <option value="nada_pertinente"
                                    {{ $graduado->pertinencia_formacion == 'nada_pertinente' ? 'selected' : '' }}>Nada
                                    pertinente</option>
                            </select>
                        </div>

                        <!-- Satisfacción general -->
                        <div class="col-md-6 mb-3">
                            <label for="satisfaccion_programa" class="form-label">Satisfacción General:</label>
                            <div class="rating" id="satisfaccion_programa">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="satisfaccion_programa" value="{{ $i }}"
                                        id="star{{ $i }}"
                                        {{ $graduado->satisfaccion_programa == $i ? 'checked' : '' }}
                                        style="display:none;" onchange="updateRating(this.value);">
                                    <label for="star{{ $i }}" class="star"
                                        style="{{ $graduado->satisfaccion_programa >= $i ? 'color: gold;' : 'color: gray;' }}">★</label>
                                @endfor
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Aspectos útiles del programa -->
                        <div class="col-md-6 mb-3">
                            <label for="aspectos_utiles" class="form-label">Aspectos Útiles del Programa:</label>
                            <textarea class="form-control" id="aspectos_utiles" name="aspectos_utiles">{{ $graduado->aspectos_utiles }}</textarea>
                        </div>

                        <!-- Aspectos mejorables del programa -->
                        <div class="col-md-6 mb-3">
                            <label for="aspectos_mejorables" class="form-label">Aspectos Mejorables del Programa:</label>
                            <textarea class="form-control" id="aspectos_mejorables" name="aspectos_mejorables">{{ $graduado->aspectos_mejorables }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Participación en investigación o extensión -->
                        <div class="col-md-6 mb-3">
                            <label for="actividades_investigacion" class="form-label">¿Ha tenido la oportunidad de
                                participar en actividades de investigación o extensión desde que se graduó?</label>
                            <select class="form-control" id="actividades_investigacion" name="actividades_investigacion"
                                required>
                                <option value="Sí"
                                    {{ $graduado->actividades_investigacion == 'Sí' ? 'selected' : '' }}>Sí</option>
                                <option value="No"
                                    {{ $graduado->actividades_investigacion == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Recomendación del programa -->
                        <div class="col-md-6 mb-3">
                            <label for="recomendar_programa" class="form-label">¿Recomendaría este programa de maestría
                                a otros profesionales de su campo o áreas afines?</label>
                            <select class="form-control" id="recomendar_programa" name="recomendar_programa" required>
                                <option value="Sí" {{ $graduado->recomendar_programa == 'Sí' ? 'selected' : '' }}>Sí
                                </option>
                                <option value="No" {{ $graduado->recomendar_programa == 'No' ? 'selected' : '' }}>No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Capacitación Continua -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Capacitación Continua</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Interés en capacitación continua -->
                        <div class="col-md-6 mb-3">
                            <label for="interes_capacitacion_continua" class="form-label">¿Estaría interesado en
                                capacitación continua?</label>
                            <select class="form-control" id="interes_capacitacion_continua"
                                name="interes_capacitacion_continua" required onchange="toggleTemasInput()">
                                <option value="">Seleccione una opción</option>
                                <option value="Sí"
                                    {{ $graduado->interes_capacitacion_continua == 'Sí' ? 'selected' : '' }}>Sí</option>
                                <option value="No"
                                    {{ $graduado->interes_capacitacion_continua == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Temas de interés para capacitaciones continuas -->
                        <div class="col-md-6 mb-3" id="temasInteresContainer"
                            style="{{ $graduado->interes_capacitacion_continua == 'Sí' ? '' : 'display:none;' }}">
                            <label for="temas_interes" class="form-label">Mención de temas de interés para capacitaciones
                                continuas:</label>
                            <textarea class="form-control" id="temas_interes" name="temas_interes" rows="3">{{ $graduado->temas_interes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Competencias y Habilidades -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Competencias y Habilidades</h3>
                </div>
                <div class="card-body">
                    <label>Calificación de Competencias:</label>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Competencia</th>
                                <th>Muy alta</th>
                                <th>Alta</th>
                                <th>Media</th>
                                <th>Baja</th>
                                <th>Muy baja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['Resolución de problemas', 'Comunicación oral', 'Análisis', 'Creatividad', 'Trabajo en equipo'] as $competencia)
                                <tr>
                                    <td>{{ $competencia }}</td>
                                    @foreach (['Muy alta', 'Alta', 'Media', 'Baja', 'Muy baja'] as $nivel)
                                        <td>
                                            <input type="radio"
                                                name="{{ strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', ' '], ['a', 'e', 'i', 'o', 'u', '_'], $competencia)) }}"
                                                value="{{ strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', ' '], ['a', 'e', 'i', 'o', 'u', '_'], $nivel)) }}"
                                                {{ isset($graduado->{strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', ' '], ['a', 'e', 'i', 'o', 'u', '_'], $competencia))}) && $graduado->{strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', ' '], ['a', 'e', 'i', 'o', 'u', '_'], $competencia))} == strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', ' '], ['a', 'e', 'i', 'o', 'u', '_'], $nivel)) ? 'checked' : '' }}>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Botón de Actualizar -->
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-primary">Actualizar Datos</button>
            </div>
        </form>
    </div>
@stop


@section('js')
    <script>
        document.getElementById('empleado_actualmente').addEventListener('change', function() {
            var datosLaborales = document.getElementById('datos_laborales');
            if (this.value === 'si') {
                datosLaborales.style.display = 'block';
            } else {
                datosLaborales.style.display = 'none';
            }
        });
    </script>
    <script>
        function toggleTemasInput() {
            var select = document.getElementById('interes_capacitacion_continua');
            var temasContainer = document.getElementById('temasInteresContainer');
            temasContainer.style.display = select.value === 'Sí' ? '' : 'none';
        }

        document.addEventListener('DOMContentLoaded', toggleTemasInput);
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#aspectos_utiles'), {
                language: 'es'
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#aspectos_mejorables'), {
                language: 'es'
            })
            .catch(error => {
                console.error(error);
            });
    </script>



    <script>
        function updateRating(value) {
            const stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                star.style.color = (5 - index) <= value ? 'gold' : 'gray';
            });
        }
    </script>

@stop

@section('css')
    <style>
        .rating {
            direction: rtl;
            display: inline-block;
            font-size: 24px;
        }

        .rating input {
            display: none;
        }

        .rating label {
            color: #ddd;
            cursor: pointer;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
        }
    </style>
@stop
