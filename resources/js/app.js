import './bootstrap';
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
