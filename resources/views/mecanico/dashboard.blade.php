<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AutoManager - Mecánico</title>
</head>
<body>

    <h1>Dashboard Mecánico</h1>

    <p>Panel de trabajo del mecánico.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Cerrar sesión
        </button>
    </form>
    
</body>
</html>