<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Diagnóstico - AutoManager</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #111;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background: #050505;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 6px;
        }

        .header p {
            color: #777;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
        }

        .info span {
            display: block;
            color: #777;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .info strong {
            font-size: 15px;
        }

        .status {
            display: inline-block;
            margin-top: 15px;
            padding: 7px 12px;
            border-radius: 999px;
            background: #fee2e2;
            color: #b91c1c;
            font-size: 13px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        textarea,
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        button {
            border: none;
            border-radius: 8px;
            padding: 12px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .draft {
            background: #050505;
            color: white;
        }

        .submit {
            background: #e11d2e;
            color: white;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .warning {
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 700px) {

            .info-grid {
                grid-template-columns: 1fr;
            }

            .buttons {
                flex-direction: column;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <a
        href="{{ route('mecanico.dashboard') }}"
        class="back"
    >
        ← Volver a mis citas
    </a>


    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="header">

        <h1>
            Detalle de orden
        </h1>

        <p>
            Folio: <strong>{{ $cita->folio }}</strong>
        </p>

    </div>


    <div class="card">

        <h2>
            Información del vehículo
        </h2>

        <div class="info-grid">

            <div class="info">

                <span>
                    Cliente
                </span>

                <strong>
                    {{ $cita->client->name }}
                </strong>

            </div>


            <div class="info">

                <span>
                    Vehículo
                </span>

                <strong>
                    {{ $cita->vehicle->brand }}
                    {{ $cita->vehicle->model }}
                    ({{ $cita->vehicle->year }})
                </strong>

            </div>


            <div class="info">

                <span>
                    Servicio solicitado
                </span>

                <strong>
                    {{ $cita->service_type }}
                </strong>

            </div>


            <div class="info">

                <span>
                    Kilometraje
                </span>

                <strong>
                    {{ number_format($cita->vehicle->mileage) }} km
                </strong>

            </div>

        </div>


        <div class="status">

            @switch($cita->status)

                @case('pendiente')
                    Pendiente
                    @break

                @case('diagnostico')
                    Diagnóstico
                    @break

                @case('esperando_aprobacion')
                    Esperando autorización
                    @break

                @case('en_proceso')
                    En proceso
                    @break

                @case('control_calidad')
                    Control de calidad
                    @break

                @case('listo')
                    Listo para entrega
                    @break

                @default
                    {{ ucfirst($cita->status) }}

            @endswitch

        </div>

    </div>


    @if($cita->status === 'esperando_aprobacion')

        <div class="warning">

            El diagnóstico ya fue enviado al cliente.

            <br>

            Puedes modificarlo y volver a enviarlo posteriormente.

        </div>

    @endif


    <div class="card">

        <h2>
            Diagnóstico
        </h2>

        <form
            method="POST"
            action="{{ route('mecanico.citas.updateDiagnosis', $cita) }}"
        >

            @csrf
            @method('PATCH')


            <div class="form-group">

                <label for="diagnosis">
                    Descripción del diagnóstico
                </label>

                <textarea
                    id="diagnosis"
                    name="diagnosis"
                    placeholder="Describe las fallas encontradas, pruebas realizadas y reparación recomendada..."
                    required
                >{{ old('diagnosis', $cita->diagnosis) }}</textarea>

                @error('diagnosis')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <label for="estimated_cost">
                    Costo estimado de reparación
                </label>

                <input
                    type="number"
                    id="estimated_cost"
                    name="estimated_cost"
                    min="0"
                    step="0.01"
                    value="{{ old('estimated_cost', $cita->estimated_cost) }}"
                    placeholder="0.00"
                    required
                >

                @error('estimated_cost')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="buttons">

                <button
                    type="submit"
                    name="action"
                    value="draft"
                    class="draft"
                >
                    Guardar borrador
                </button>


                <button
                    type="submit"
                    name="action"
                    value="submit"
                    class="submit"
                    onclick="return confirm('¿Enviar el diagnóstico al cliente?')"
                >
                    Enviar diagnóstico
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>