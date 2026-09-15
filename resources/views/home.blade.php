<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AutoManager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: white;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .botones button {
            padding: 10px 15px;
            margin-left: 10px;
            cursor: pointer;
        }

        .principal {
            text-align: center;
            padding: 100px 20px;
            background-color: white;
        }

        .principal h1 {
            font-size: 45px;
            margin-bottom: 10px;
        }

        .principal p {
            color: #666;
        }

        .rastreo {
            width: 400px;
            max-width: 90%;
            margin: 40px auto;
            padding: 25px;
            border: 1px solid #ddd;
            background-color: white;
        }

        .rastreo input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .rastreo button {
            width: 100%;
            padding: 12px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <header>

        <div class="logo">
            AutoManager
        </div>

        <div class="botones">
            <a href="/login">
                <button>Iniciar sesión</button>
            </a>
            <a href="/register">
                <button>Registrarse</button>
            </a>
        </div>

    </header>

    <section class="principal">

        <h1>Tu vehículo,<br>bajo control.</h1>

        <p>
            Seguimiento en tiempo real del servicio,
            historial completo y citas sin complicaciones.
        </p>

        <div class="rastreo">

            <h3>Rastrea tu vehículo</h3>

            <p>
                Ingresa tu número de referencia para ver el estado de tu orden.
            </p>

            <input
                type="text"
                placeholder="Ej. ORD-2026-0001"
            >

            <button>
                Rastrear
            </button>

        </div>

    </section>

</body>

</html>