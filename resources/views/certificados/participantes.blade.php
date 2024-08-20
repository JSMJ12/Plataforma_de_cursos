<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        @page {
            margin: 0; /* Elimina los márgenes de la página */
        }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .certificate-container {
            width: 100%;
            height: 100vh; /* Usa 100vh para que cubra toda la altura visible de la ventana del navegador */
            padding: 0;
            background-image: url("{{ public_path('images/fondo_certificado.png') }}");
            background-size: cover; /* Asegura que la imagen de fondo cubra toda la página */
            background-repeat: no-repeat;
            background-position: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
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
            margin: 20px 0;
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
            margin-bottom: 20px;
            position: relative;
        }
        .footer img {
            max-width: 130px;
            display: block;
            margin: 30px auto 0;
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
            margin-top: 60px;
        }
        .footer .signature p {
            margin: 5px 0;
        }
        #qr-code {
            position: absolute;
            bottom: 110px; /* Ajusta la posición del QR code según sea necesario */
            right: 25px;
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
