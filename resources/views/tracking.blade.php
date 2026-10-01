<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rastrear vehículo - AutoManager</title>
</head>

<body>

    <h1>Rastrear vehículo</h1>

    <p>Ingresa el folio de tu servicio para consultar el estado de tu vehículo.</p>

    <form method="POST" action="{{ route('tracking.search') }}">

        @csrf

        <label for="folio">Folio:</label>

        <input
            type="text"
            id="folio"
            name="folio"
            value="{{ old('folio') }}"
            placeholder="Ej. AM-2026-000001"
        >

        <button type="submit">
            Rastrear vehículo
        </button>

    </form>


    @if(session('error'))

        <p>
            {{ session('error') }}
        </p>

    @endif


    @if($errors->any())

        @foreach($errors->all() as $error)

            <p>{{ $error }}</p>

        @endforeach

    @endif


    @isset($appointment)

        <hr>

        <h2>Información del servicio</h2>

        <p>
            <strong>Folio:</strong>
            {{ $appointment->folio }}
        </p>

        <p>
            <strong>Vehículo:</strong>
            {{ $appointment->vehicle->brand }}
            {{ $appointment->vehicle->model }}
        </p>

        <p>
            <strong>Año:</strong>
            {{ $appointment->vehicle->year }}
        </p>

        <p>
            <strong>Color:</strong>
            {{ $appointment->vehicle->color }}
        </p>

        <p>
            <strong>Servicio:</strong>
            {{ $appointment->service_type }}
        </p>

        <p>
            <strong>Estado:</strong>
            {{ $appointment->status }}
        </p>

    @endisset

</body>
</html>