<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'AutoManager | Mecánico')</title>

    <link rel="stylesheet" href="{{ asset('css/mecanico.css') }}?v={{ filemtime(public_path('css/mecanico.css')) }}">
    @stack('styles')
</head>

<body>

    @include('mecanico.partials.sidebar')

    <main class="mechanic-main">
        @yield('content')
    </main>

    @stack('scripts')


@include('partials.campos-obligatorios')
</body>

</html>