@extends('layouts.app')
<title>Registro</title>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <img src="{{ asset('images/unesum.png') }}" alt="University Logo" class="logo">
                        <img src="vendor/adminlte/dist/img/posgrado-20.png" alt="University Seal" class="seal"><br><span class="university-name">UNIVERSIDAD ESTATAL DEL SUR DE MANABÍ</span><br>
                        <span class="institute">INSTITUTO DE POSGRADO</span><br>
                    </div>
                    <div class="divider"></div>
                    <div class="card-body">
                        <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Foto:</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                        <div id="imagePreview" style="margin-top: 10px; width: 200px; height: 170px; border: 1px solid #ccc; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center;"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Rol:</label>
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="" disabled selected>Selecciona un rol</option>
                                            <option value="Capacitador">Capacitador</option>
                                            <option value="Participante">Participante</option>
                                        </select>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="dni">Cédula / Pasaporte:</label>
                                        <input type="text" name="dni" class="form-control" required value="{{ old('dni') }}">
                                        @if ($errors->has('dni'))
                                            <div class="alert alert-danger">{{ $errors->first('dni') }}</div>
                                        @endif
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="name">Primer Nombre:</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="name2">Segundo Nombre:</label>
                                        <input type="text" name="name2" class="form-control">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="apellidop">Apellido Paterno:</label>
                                        <input type="text" name="apellidop" class="form-control" required>
                                    </div>

                                </div>
                    
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                    
                                    <div class="form-group">
                                        <label for="apellidom">Apellido Materno:</label>
                                        <input type="text" name="apellidom" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Correo Electrónico:</label>
                                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="celular">Celular:</label>
                                        <input type="text" name="celular" class="form-control">
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad:</label>
                                        <input type="text" name="ciudad" class="form-control">
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="edad">Edad:</label>
                                        <input type="number" name="edad" class="form-control">
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="sexo">Sexo:</label>
                                        <div class="form-check">
                                            <input type="radio" id="masculino" name="sexo" value="M" class="form-check-input" required>
                                            <label for="masculino" class="form-check-label">Masculino</label>
                                        </div>
                    
                                        <div class="form-check">
                                            <input type="radio" id="femenino" name="sexo" value="F" class="form-check-input" required>
                                            <label for="femenino" class="form-check-label">Femenino</label>
                                        </div>
                                        @if ($errors->has('sexo'))
                                            <div class="alert alert-danger">{{ $errors->first('sexo') }}</div>
                                        @endif
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="password">Contraseña:</label>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                            @if ($errors->has('password'))
                                                <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Contraseña:</label>
                                        <div class="input-group">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="current-password">
                                            @if ($errors->has('password_confirmation'))
                                                <div class="alert alert-danger">{{ $errors->first('password_confirmation') }}</div>
                                            @endif
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                    
                            <!-- Campos específicos para Capacitadores -->
                            <div id="capacitadorFields" style="display: none;">
                                <div class="form-group">
                                    <label for="titulo">Título Profesional:</label>
                                    <input type="text" name="titulo" class="form-control">
                                </div>
                    
                                <div class="form-group">
                                    <label for="especialidad">Especialidad:</label>
                                    <input type="text" name="especialidad" class="form-control">
                                </div>
                    
                                <div class="form-group">
                                    <label for="anos_experiencia">Años de Experiencia:</label>
                                    <input type="number" name="anos_experiencia" class="form-control">
                                </div>
                            </div>
                    
                            <!-- Campos específicos para Participantes -->
                            <div id="participanteFields" style="display: none;">
                                <div class="form-group">
                                    <label for="nivel_estudio">Nivel de Estudio:</label>
                                    <input type="text" name="nivel_estudio" class="form-control">
                                </div>
                    
                                <div class="form-group">
                                    <label for="interes">¿Está interesado en estudiar en el Instituto de Posgrado de la UNESUM?</label>
                                    <select name="interes" id="interes" class="form-control">
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                    
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@stop

<style>
    #imagePreview {
        width: 200px;
        height: 200px;
        border: 1px solid #ccc;
        margin-top: 10px;
        background-size: cover;
        background-position: center;
    }

    body {
        background: url('https://i.pinimg.com/originals/29/a7/c4/29a7c42277c305a04f33ebedae44a420.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .header {
        text-align: center;
        margin-top: 10px;
    }

    .logo {
        width: 74px;
        height: 80px;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .seal {
        width: 150px;
        height: 93px;
        position: absolute;
        top: 20px;
        right: 10px;
    }

    .university-name {
        font-size: 14pt;
        font-weight: bold;
    }

    .institute {
        font-size: 10pt;
    }

    .divider {
        width: 100%;
        height: 2px;
        background-color: #000;
        margin: 10px 0;
    }

    .custom-select-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .custom-select {
        display: block;
        width: 100%;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .custom-select:disabled {
        background-color: #e9ecef;
    }

    .custom-select::-ms-expand {
        background-color: transparent;
        border: 0;
    }

    .custom-select-wrapper::after {
        content: '\25BC';
        position: absolute;
        top: 50%;
        right: 0.75rem;
        transform: translateY(-50%);
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const discapacidadSelect = document.querySelector('[name="discapacidad"]');
        const divPorcentajeDiscapacidad = document.getElementById('divPorcentajeDiscapacidad');
        const divCodigoConadis = document.getElementById('divCodigoConadis');
        const divPDFConadis = document.getElementById('divPDFConadis');

        discapacidadSelect.addEventListener('change', function () {
            if (this.value === 'Si') {
                divPorcentajeDiscapacidad.style.display = 'block';
                divCodigoConadis.style.display = 'block';
                divPDFConadis.style.display = 'block';
            } else {
                divPorcentajeDiscapacidad.style.display = 'none';
                divCodigoConadis.style.display = 'none';
                divPDFConadis.style.display = 'none';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.querySelector('input[name="password"]');
        const message = document.createElement('p');
        message.classList.add('text-muted');
        passwordInput.parentElement.appendChild(message);
    
        passwordInput.addEventListener('input', function () {
            const value = passwordInput.value;
            let suggestions = [];
    
            if (value.length < 8) {
                suggestions.push('Debe tener al menos 8 caracteres.');
            }
            if (!/[A-Z]/.test(value)) {
                suggestions.push('Debe tener al menos una letra mayúscula.');
            }
            if (!/[a-z]/.test(value)) {
                suggestions.push('Debe tener al menos una letra minúscula.');
            }
            if (!/[0-9]/.test(value)) {
                suggestions.push('Debe tener al menos un número.');
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                suggestions.push('Debe tener al menos un carácter especial.');
            }
    
            message.textContent = suggestions.length > 0 ? suggestions.join(' ') : 'Contraseña segura.';
            message.style.color = suggestions.length > 0 ? 'red' : 'green';
        });
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const capacitadorFields = document.getElementById('capacitadorFields');
            const participanteFields = document.getElementById('participanteFields');
        
            roleSelect.addEventListener('change', function () {
                if (this.value === 'Capacitador') {
                    capacitadorFields.style.display = 'block';
                    participanteFields.style.display = 'none';
                } else if (this.value === 'Participante') {
                    capacitadorFields.style.display = 'none';
                    participanteFields.style.display = 'block';
                } else {
                    capacitadorFields.style.display = 'none';
                    participanteFields.style.display = 'none';
                }
            });
        });
        </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    // Mostrar/Ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });

    // Mostrar/Ocultar contraseña confirmación
    document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');
        
        if (passwordConfirmationInput.type === 'password') {
            passwordConfirmationInput.type = 'text';
            eyeIconConfirmation.classList.remove('fa-eye');
            eyeIconConfirmation.classList.add('fa-eye-slash');
        } else {
            passwordConfirmationInput.type = 'password';
            eyeIconConfirmation.classList.remove('fa-eye-slash');
            eyeIconConfirmation.classList.add('fa-eye');
        }
    });
</script>