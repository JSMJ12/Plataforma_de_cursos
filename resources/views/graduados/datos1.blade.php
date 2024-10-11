@extends('layouts.app')

@section('title', 'Datos Graduados')

@section('content_header')
    <h1>Datos Graduados</h1>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('graduados.store1') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Datos Personales</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">
                                    <i class="fas fa-camera"></i> Foto:
                                </label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <div id="imagePreview"
                                    style="margin-top: 10px; width: 200px; height: 170px; border: 1px solid #ccc; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="dni">
                                    <i class="fas fa-id-card"></i> Cédula / Pasaporte:
                                </label>
                                <input type="text" name="dni" class="form-control" required
                                    value="{{ old('dni') }}">
                                @if ($errors->has('dni'))
                                    <div class="alert alert-danger">{{ $errors->first('dni') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i> Primer Nombre:
                                </label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="name2">
                                    <i class="fas fa-user"></i> Segundo Nombre:
                                </label>
                                <input type="text" name="name2" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="apellidop">
                                    <i class="fas fa-user"></i> Apellido Paterno:
                                </label>
                                <input type="text" name="apellidop" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidom">
                                    <i class="fas fa-user"></i> Apellido Materno:
                                </label>
                                <input type="text" name="apellidom" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i> Correo Electrónico:
                                </label>
                                <input type="email" name="email" class="form-control" required
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="celular">
                                    <i class="fas fa-mobile-alt"></i> Celular:
                                </label>
                                <input type="text" name="celular" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="ciudad">
                                    <i class="fas fa-city"></i> Ciudad:
                                </label>
                                <input type="text" name="ciudad" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="edad">
                                    <i class="fas fa-calendar-alt"></i> Edad:
                                </label>
                                <input type="number" name="edad" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="sexo">
                                    <i class="fas fa-venus-mars"></i> Sexo:
                                </label>
                                <div class="form-check">
                                    <input type="radio" id="masculino" name="sexo" value="M"
                                        class="form-check-input" required>
                                    <label for="masculino" class="form-check-label">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="femenino" name="sexo" value="F"
                                        class="form-check-input" required>
                                    <label for="femenino" class="form-check-label">Femenino</label>
                                </div>
                                @if ($errors->has('sexo'))
                                    <div class="alert alert-danger">{{ $errors->first('sexo') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-lock"></i> Contraseña:
                                </label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="current-password">
                                    @if ($errors->has('password'))
                                        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">
                                    <i class="fas fa-lock"></i> Confirmar Contraseña:
                                </label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" required autocomplete="current-password">
                                    @if ($errors->has('password_confirmation'))
                                        <div class="alert alert-danger">{{ $errors->first('password_confirmation') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  -->
            <div class="card shadow-sm mb-4">
                <div class="card-header text-white" style="background-color: rgb(12, 89, 103)">
                    <h3 class="mb-0">Datos de Graduación</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Programa de Maestría -->
                        <div class="col-md-6 mb-3">
                            <label for="programa_maestria" class="form-label">Programa de Maestría Completado:</label>
                            <input type="text" class="form-control" id="programa_maestria" name="programa_maestria">
                        </div>

                        <!-- Fecha de Graduación -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha_graduacion" class="form-label">Fecha de Graduación:</label>
                            <input type="date" class="form-control" id="fecha_graduacion" name="fecha_graduacion"
                                required>
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
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4_mas">4 o más</option>
                            </select>
                        </div>
            
                        <div class="col-md-6 mb-3">
                            <label for="empleado_actualmente" class="form-label">¿Está Actualmente Empleado?</label>
                            <select class="form-control" id="empleado_actualmente" name="empleado_actualmente" required>
                                <option value="" selected>Seleccione una opción</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
            
                    <!-- Datos laborales adicionales (aparecen solo si está empleado) -->
                    <div id="datos_laborales" style="display: none;">
                        <div class="row">
                            <!-- Nombre de la empresa -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre_empresa" class="form-label">Nombre de la Empresa:</label>
                                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" value="">
                            </div>
            
                            <!-- Cargo actual -->
                            <div class="col-md-6 mb-3">
                                <label for="cargo_actual" class="form-label">Cargo Actual:</label>
                                <input type="text" class="form-control" id="cargo_actual" name="cargo_actual" value="">
                            </div>
                        </div>
            
                        <div class="row">
                            <!-- Trabajo vinculado -->
                            <div class="col-md-6 mb-3">
                                <label for="trabajo_vinculado" class="form-label">¿El Trabajo Está Vinculado al Programa de Maestría Estudiado?</label>
                                <select class="form-control" id="trabajo_vinculado" name="trabajo_vinculado">
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="totalmente">Sí, totalmente</option>
                                    <option value="parcialmente">Sí, parcialmente</option>
                                    <option value="no">No</option> <!-- Cambiado a minúscula para consistencia -->
                                </select>
                            </div>
            
                            <!-- Años de experiencia laboral -->
                            <div class="col-md-6 mb-3">
                                <label for="anos_experiencia_laboral" class="form-label">Años de Experiencia Laboral:</label>
                                <select class="form-control" id="anos_experiencia_laboral" name="anos_experiencia_laboral">
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="Menos_de_1">Menos de 1 año</option>
                                    <option value="1-3">1-3 años</option>
                                    <option value="4-6">4-6 años</option>
                                    <option value="7-10">7-10 años</option>
                                    <option value="Mas_de_10">Más de 10 años</option>
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
                                <option value="" selected>Seleccione una opción</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <!-- Actividades de desarrollo profesional continuo -->
                        <div class="col-md-6 mb-3">
                            <label for="desarrollo_profesional_continuo" class="form-label">¿Participa en actividades de
                                desarrollo profesional continuo (conferencias, talleres, seminarios)?</label>
                            <select class="form-control" id="desarrollo_profesional_continuo"
                                name="desarrollo_profesional_continuo" required>
                                <option value="" selected>Seleccione una opción</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
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
                                <option value="totalmente">Totalmente pertinente</option>
                                <option value="pertinente">Pertinente</option>
                                <option value="poco_pertinente">Poco pertinente</option>
                                <option value="nada_pertinente">Nada pertinente</option>
                            </select>
                        </div>

                        <!-- Satisfacción general -->
                        <div class="col-md-6 mb-3">
                            <label for="satisfaccion_programa" class="form-label">Satisfacción General:</label>
                            <div class="rating" id="satisfaccion_programa">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="satisfaccion_programa" value="{{ $i }}"
                                        id="star{{ $i }}" style="display:none;"
                                        onchange="updateRating(this.value);">
                                    <label for="star{{ $i }}" class="star" style="color: gray;">★</label>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Aspectos útiles del programa -->
                        <div class="col-md-6 mb-3">
                            <label for="aspectos_utiles" class="form-label">Aspectos Útiles del Programa:</label>
                            <textarea class="form-control" id="aspectos_utiles" name="aspectos_utiles"></textarea>
                        </div>

                        <!-- Aspectos mejorables del programa -->
                        <div class="col-md-6 mb-3">
                            <label for="aspectos_mejorables" class="form-label">Aspectos Mejorables del Programa:</label>
                            <textarea class="form-control" id="aspectos_mejorables" name="aspectos_mejorables"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Participación en investigación o extensión -->
                        <div class="col-md-6 mb-3">
                            <label for="actividades_investigacion" class="form-label">¿Ha tenido la oportunidad de
                                participar en actividades de investigación o extensión desde que se graduó?</label>
                            <select class="form-control" id="actividades_investigacion" name="actividades_investigacion"
                                required>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <!-- Recomendación del programa -->
                        <div class="col-md-6 mb-3">
                            <label for="recomendar_programa" class="form-label">¿Recomendaría este programa de maestría
                                a otros profesionales de su campo o áreas afines?</label>
                            <select class="form-control" id="recomendar_programa" name="recomendar_programa" required>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
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
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <!-- Temas de interés para capacitaciones continuas -->
                        <div class="col-md-6 mb-3" id="temasInteresContainer" style="display:none;">
                            <label for="temas_interes" class="form-label">Mención de temas de interés para capacitaciones
                                continuas:</label>
                            <textarea class="form-control" id="temas_interes" name="temas_interes" rows="3"></textarea>
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
                                                value="{{ strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', ' '], ['a', 'e', 'i', 'o', 'u', '_'], $nivel)) }}">
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
                <button type="submit" class="btn btn-primary">Guardar Datos</button>
            </div>
        </form>
    </div>
@endsection

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
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('empleado_actualmente').addEventListener('change', function() {
            var datosLaborales = document.getElementById('datos_laborales');
            if (this.value === 'Sí') {
                datosLaborales.style.display = 'block';
            } else {
                datosLaborales.style.display = 'none';
            }
        });
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

<script>
    function updateRating(value) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.style.color = (5 - index) <= value ? 'gold' : 'gray';
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.style.backgroundImage = `url(${e.target.result})`;
                    imagePreview.style.backgroundSize = 'cover';
                    imagePreview.style.backgroundPosition = 'center';
                    imagePreview.textContent = ''; // Clear any text content
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.backgroundImage = 'none';
                imagePreview.textContent = 'Selecciona una imagen'; // Optional: Add a placeholder text
            }
        });
    });
</script>


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
