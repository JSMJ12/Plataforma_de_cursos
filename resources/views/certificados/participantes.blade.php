<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            color: #333;
        }
        .certificate-container {
            width: 100%;
            height: 100%;
            padding: 0;
            background-image: url("{{ public_path('images/fondo_certificado.png') }}");
            background-size: 110% 110%; /* Aumenta el tamaño del fondo para cubrir más área */
            background-repeat: no-repeat;
            background-position: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative; /* Cambiado de absolute a relative */
            top: -20px; /* Expande el fondo hacia arriba */
            left: -10px; /* Ajusta este valor para mover el fondo más a la derecha */
            right: -10px; /* Expande el fondo hacia la derecha */
            bottom: -20px; /* Expande el fondo hacia abajo */
        }
        .header {
            text-align: center;
            margin-top: 20px;
        }
        .header img {
            max-width: 90px; /* Tamaño del logo reducido */
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            color: #000;
            margin: 0;
        }
        .header h2 {
            font-size: 20px;
            color: #000;
            margin: 5px 0;
        }
        .content {
            text-align: center;
            margin-top: 20px;
        }
        .content p {
            font-size: 14px;
            margin: 10px 0;
        }
        .content h3 {
            font-size: 22px;
            color: #000;
            margin: 15px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-bottom: 20px; /* Ajusta este valor para mover el sello más abajo */
            position: relative;
        }
        .footer img {
            max-width: 130px; /* Tamaño del sello aumentado */
            display: block;
            margin: 20px auto 0; /* Mueve el sello más abajo y lo centra horizontalmente */
        }
        .footer p {
            font-size: 14px;
            color: #333;
            margin: 5px 0;
        }
        .footer .signature {
            display: inline-block;
            width: 45%;
            vertical-align: top;
            margin-top: 60px; /* Ajusta este valor según sea necesario */
        }
        .footer .signature p {
            margin: 5px 0;
        }
        #qr-code {
            position: absolute;
            bottom: 50px;
            right: 5px;
        }
        
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <img src="{{ public_path('images/logo_unesum_certificado.png') }}" alt="Logo Institución">
            <h1>UNIVERSIDAD ESTATAL DEL SUR DE MANABÍ</h1>
            <h2>INSTITUTO DE POSGRADO</h2>
        </div>
        <div class="content">
            <p>Confiera el siguiente Certificado a</p>
            <h3>{{ $usuario->name }} {{ $usuario->apellidop }}</h3>
            <p>Por su asistencia y aprobación del Curso:</p>
            <p><strong>"{{ $curso->nombre }}"</strong></p>
            <p>Organizado por el Instituto de Posgrado UNESUM, realizado los días:</p>
            <p><strong>{{ $fechasFormateadas }}</strong></p>
            <p>Con una duración de {{ $curso->horas_academicas }} horas académicas.</p>
        </div>
        <div class="footer">
            <div class="signature">
                @if ($curso->tipo == 'Instituto')
                    <p><strong>Dr. C. Leopoldo Venegas Loor</strong></p>
                    <p>DIRECTOR POSGRADO UNESUM</p>
                @else
                    <p><strong>{{ $curso->coordinador_maestria }}</strong></p>
                    <p>COORDINADOR DE LA {{ $curso->nombre_maestria }}</p>
                @endif
            </div>
            <div class="signature">
                <p><strong>{{ $curso->capacitador->getFullNameAttribute() }}</strong></p>
                <p>{{ $curso->capacitador->especialidad }}</p>
            </div>
            <img src="{{ public_path('/images/cello_certificado.png') }}" alt="Sello Institución">
        </div>
        <div id="qr-code">
            <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="Código QR">
        </div>
    </div>
</body>
</html>
