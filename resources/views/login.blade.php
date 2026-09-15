<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inicio de sesión - AutoManager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        .contenedor {
            width: 400px;
            max-width: 90%;
            margin: 100px auto;
            background-color: white;
            padding: 40px;
            box-sizing: border-box;
        }

        h1 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: #e3262e;
            color: white;
            border: none;
            cursor: pointer;
        }

        .volver {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Iniciar sesión</h1>

        <p>Accede a tu cuenta de AutoManager</p>

        <form>

            <label>Correo electrónico</label>
            <input type="email" placeholder="correo@ejemplo.com">

            <label>Contraseña</label>
            <input type="password" placeholder="********">

            <button type="submit">
                Ingresar
            </button>

        </form>

        <a class="volver" href="/">
            Volver al inicio
        </a>

    </div>

</body>

</html>