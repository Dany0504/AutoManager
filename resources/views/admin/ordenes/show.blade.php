
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de orden - AutoManager</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #111;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #333;
            text-decoration: none;
        }

        .back:hover {
            color: #e11d2e;
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 28px;
        }

        .card {
            background: white;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 24px;
        }

        .card h2 {
            font-size: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
            margin-top: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .field strong {
            display: block;
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .field p {
            margin: 0;
            font-size: 15px;
            overflow-wrap: anywhere;
        }

        .notes {
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        @media (max-width: 650px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <a href="{{ route('ordenes.index') }}" class="back">
            ← Volver a Gestión de órdenes
        </a>

        <h1>Detalle de orden</h1>

        <p class="subtitle">
            Folio: {{ $orden->folio ?: 'ORD-' . $orden->id }}
        </p>

        <div class="card">
            <h2>Información general</h2>

            <div class="grid">
                <div class="field">
                    <strong>Cliente</strong>
                    <p>{{ $orden->client?->user?->name ?? 'Sin cliente' }}</p>
                </div>

                <div class="field">
                    <strong>Vehículo</strong>
                    <p>
                        {{ $orden->vehicle?->brand ?? 'Sin vehículo' }}
                        {{ $orden->vehicle?->model ?? '' }}
                        {{ $orden->vehicle?->year ?? '' }}
                    </p>
                </div>

                <div class="field">
                    <strong>Mecánico asignado</strong>
                    <p>{{ $orden->mechanic?->name ?? 'Sin asignar' }}</p>
                </div>

                <div class="field">
                    <strong>Estado</strong>
                    <p>{{ ucfirst(str_replace('_', ' ', $orden->status)) }}</p>
                </div>

                <div class="field">
                    <strong>Fecha</strong>
                    <p>{{ $orden->appointment_date?->format('d/m/Y') ?? '—' }}</p>
                </div>

                <div class="field">
                    <strong>Hora</strong>
                    <p>{{ $orden->appointment_time ?? '—' }}</p>
                </div>

                <div class="field">
                    <strong>Tipo de servicio</strong>
                    <p>{{ $orden->service_type }}</p>
                </div>

                <div class="field">
                    <strong>Costo estimado</strong>
                    <p>
                        @if ($orden->estimated_cost !== null)
                            ${{ number_format((float) $orden->estimated_cost, 2) }}
                        @else
                            Pendiente
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Diagnóstico y autorización</h2>

            <div class="field" style="margin-bottom: 20px;">
                <strong>Diagnóstico</strong>
                <p class="notes">{{ $orden->diagnosis ?: 'Sin diagnóstico registrado.' }}</p>
            </div>

            <div class="field">
                <strong>Estado de autorización</strong>
                <p>{{ ucfirst($orden->authorization_status) }}</p>
            </div>
        </div>

        <div class="card">
            <h2>Notas de la cita</h2>

            <p class="notes">
                {{ $orden->notes ?: 'No hay notas registradas.' }}
            </p>
        </div>

    </div>
</body>
</html>
