<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AutoManager - Administrador</title>
</head>
<body>

    <h1>Dashboard Administrador</h1>

    <p>Panel de administración de AutoManager.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Cerrar sesión
        </button>
    </form>

</body>
</html>