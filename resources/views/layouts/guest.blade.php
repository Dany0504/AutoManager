<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' : '' }}AutoManager</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0f0f0f;
            color: white;
            min-height: 100vh;
        }

        a {
            color: inherit;
        }

        .auth {
            display: flex;
            min-height: 100vh;
        }

        /* ===== PANEL DE MARCA (IZQUIERDA) ===== */

        .auth-brand {
            position: relative;
            width: 50%;
            padding: 45px 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(180deg, rgba(15, 15, 15, .55) 0%, rgba(15, 15, 15, .85) 70%, #0f0f0f 100%),
                url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80') center / cover no-repeat;
            border-right: 1px solid #1f1f1f;
        }

        .logo {
            text-decoration: none;
            display: inline-block;
        }

        .logo h2 {
            color: #e11d2e;
            font-size: 34px;
        }

        .logo p {
            color: #aaa;
            font-size: 14px;
        }

        .auth-brand h1 {
            font-size: 56px;
            line-height: 1;
            margin-bottom: 20px;
            max-width: 520px;
        }

        .auth-brand h1 span {
            color: #e11d2e;
        }

        .auth-brand .lema {
            font-size: 18px;
            color: #c9c9c9;
            max-width: 460px;
            margin-bottom: 30px;
        }

        .beneficios {
            list-style: none;
            display: grid;
            gap: 14px;
        }

        .beneficios li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ddd;
            font-size: 15px;
        }

        .beneficios li::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #e11d2e;
            box-shadow: 0 0 0 4px rgba(225, 29, 46, .2);
            flex-shrink: 0;
        }

        .auth-brand footer {
            color: #888;
            font-size: 13px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px 24px;
        }

        /* ===== PANEL DEL FORMULARIO (DERECHA) ===== */

        .auth-main {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .auth-main .logo {
            display: none;
            margin-bottom: 30px;
            text-align: center;
        }

        .auth-card {
            width: 100%;
            max-width: 430px;
            background: #161616;
            border: 1px solid #262626;
            border-radius: 16px;
            padding: 38px 36px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .45);
        }

        .auth-card h3 {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .auth-card .subtitulo {
            color: #aaa;
            font-size: 15px;
            margin-bottom: 28px;
            line-height: 1.45;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #ccc;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .campo input {
            width: 100%;
            padding: 13px 14px;
            background: #0f0f0f;
            border: 1px solid #333;
            border-radius: 8px;
            color: white;
            font-family: inherit;
            font-size: 15px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .campo input::placeholder {
            color: #666;
        }

        .campo input:focus {
            border-color: #e11d2e;
            box-shadow: 0 0 0 3px rgba(225, 29, 46, .2);
        }

        .campo.con-error input {
            border-color: #e11d2e;
        }

        /* Fondo oscuro también cuando el navegador autocompleta */
        .campo input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 40px #0f0f0f inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 80px;
        }

        .ver-password {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #999;
            font-size: 13px;
            cursor: pointer;
            padding: 6px 8px;
            border-radius: 6px;
        }

        .ver-password:hover {
            color: white;
        }

        .error {
            list-style: none;
            color: #ff5a67;
            font-size: 13px;
            margin-top: 7px;
        }

        .alerta {
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .alerta.exito {
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(34, 197, 94, .4);
            color: #7ee2a0;
        }

        .fila {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .recordar {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ccc;
            cursor: pointer;
        }

        .recordar input {
            width: 16px;
            height: 16px;
            accent-color: #e11d2e;
            cursor: pointer;
        }

        .enlace {
            color: #e11d2e;
            text-decoration: none;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .enlace:hover {
            text-decoration: underline;
        }

        .btn-principal {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #e11d2e;
            color: white;
            font-size: 16px;
            font-weight: bold;
            font-family: inherit;
            cursor: pointer;
            transition: background .25s, transform .1s;
        }

        .btn-principal:hover {
            background: #c41223;
        }

        .btn-principal:active {
            transform: scale(.99);
        }

        .pie-card {
            text-align: center;
            margin-top: 24px;
            color: #aaa;
            font-size: 14px;
        }

        .volver {
            margin-top: 24px;
            color: #888;
            font-size: 14px;
            text-decoration: none;
        }

        .volver:hover {
            color: white;
        }

        /* ===== RESPONSIVE ===== */

        @media (max-width: 900px) {
            .auth-brand {
                display: none;
            }

            .auth-main {
                width: 100%;
            }

            .auth-main .logo {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .auth-main {
                padding: 30px 16px;
            }

            .auth-card {
                padding: 28px 20px;
            }

            .fila {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="auth">

    <aside class="auth-brand">

        <a href="/" class="logo">
            <h2>AutoManager</h2>
            <p>Taller Mecánico</p>
        </a>

        <div>
            <h1>Tu vehículo en las <span>mejores manos.</span></h1>

            <p class="lema">
                Agenda citas, autoriza reparaciones y sigue el estado de tu vehículo desde un solo lugar.
            </p>

            <ul class="beneficios">
                <li>Agenda tu cita en minutos</li>
                <li>Aprueba diagnósticos desde tu cuenta</li>
                <li>Rastrea tu vehículo con tu folio</li>
            </ul>
        </div>

        <footer>
            <span>Contacto: 662-123-4567</span>
            <span>Blvd. Solidaridad #2450, Hermosillo, Sonora</span>
        </footer>

    </aside>

    <main class="auth-main">

        <a href="/" class="logo">
            <h2>AutoManager</h2>
            <p>Taller Mecánico</p>
        </a>

        <div class="auth-card">
            {{ $slot }}
        </div>

        <a href="/" class="volver">← Volver al inicio</a>

    </main>

</div>

<script>
    document.querySelectorAll('.ver-password').forEach(function (boton) {
        boton.addEventListener('click', function () {
            var input = document.getElementById(boton.dataset.target);
            var oculto = input.type === 'password';
            input.type = oculto ? 'text' : 'password';
            boton.textContent = oculto ? 'Ocultar' : 'Mostrar';
            boton.setAttribute('aria-label', oculto ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    });
</script>


@include('partials.campos-obligatorios')
</body>

</html>
