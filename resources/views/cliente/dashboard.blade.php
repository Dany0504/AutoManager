<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AutoManager - Cliente</title>
</head>
<body>

    <h1>Dashboard Cliente</h1>

    <p>Bienvenido a AutoManager.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Cerrar sesión
        </button>
    </form>

</body>
</html>