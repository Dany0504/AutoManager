<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente - AutoManager</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
            color:#111;
        }

        .layout{
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */
        .sidebar{
            width:220px;
            background:#050505;
            color:white;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
        }

        .sidebar-top{
            padding:18px 0;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            padding:0 18px 20px;
            border-bottom:1px solid #1d1d1d;
        }

        .brand-box{
            width:26px;
            height:26px;
            border-radius:4px;
            background:#e11d2e;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:13px;
            font-weight:bold;
        }

        .brand-text h2{
            font-size:18px;
            line-height:1.1;
        }

        .brand-text p{
            color:#bbb;
            font-size:12px;
            margin-top:3px;
        }

        .menu{
            margin-top:8px;
        }

        .menu a{
            display:block;
            padding:14px 18px;
            color:white;
            text-decoration:none;
            font-size:16px;
        }

        .menu a.active{
            background:#1a1a1a;
            border-left:4px solid #e11d2e;
            padding-left:14px;
        }

        .menu a:hover{
            background:#111;
        }

        .sidebar-bottom{
            padding:18px;
            border-top:1px solid #1d1d1d;
        }

        .sidebar-bottom p{
            color:#aaa;
            font-size:12px;
            margin-bottom:6px;
        }

        .sidebar-bottom h4{
            font-size:22px;
            margin-bottom:14px;
        }

        .sidebar-bottom a,
        .sidebar-bottom button{
            display:block;
            color:#bbb;
            text-decoration:none;
            font-size:15px;
            margin-top:12px;
            background:none;
            border:none;
            cursor:pointer;
            padding:0;
        }

        .sidebar-bottom button{
            color:#bbb;
        }

        /* MAIN */
        .main{
            flex:1;
            padding:0;
        }

        .topbar{
            background:#f5f5f5;
            border-bottom:1px solid #ddd;
            padding:24px 28px 18px;
        }

        .topbar h1{
            font-size:24px;
            margin-bottom:4px;
        }

        .topbar p{
            color:#777;
            font-size:14px;
        }

        .content{
            padding:28px;
        }

        .stats{
            display:grid;
            grid-template-columns:repeat(4, 1fr);
            gap:16px;
            margin-bottom:22px;
        }

        .card{
            background:white;
            border:1px solid #ddd;
            padding:18px 20px;
        }

        .card small{
            display:block;
            color:#777;
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.5px;
            margin-bottom:12px;
            font-weight:bold;
        }

        .card h2{
            font-size:20px;
        }

        .card .red{
            color:#e11d2e;
        }

        .section{
            background:white;
            border:1px solid #ddd;
            margin-bottom:22px;
        }

        .section-header{
            padding:16px 22px;
            border-bottom:1px solid #ddd;
            font-weight:bold;
            font-size:18px;
        }

        .section-body{
            padding:20px 22px;
        }


        /* AVISOS (mensajes y autorizaciones pendientes) */
        .flash{
            padding:12px 16px;
            margin-bottom:18px;
            border:1px solid #bbf7d0;
            background:#dcfce7;
            color:#166534;
            font-size:14px;
        }

        .card.alert{
            border-color:#e11d2e;
            box-shadow:inset 4px 0 0 #e11d2e;
        }

        .card a.card-link{
            display:inline-block;
            margin-top:6px;
            color:#e11d2e;
            font-size:13px;
            font-weight:bold;
            text-decoration:none;
        }

        .pending{
            border:2px solid #e11d2e;
            background:#fff;
            margin-bottom:22px;
        }

        .pending-header{
            display:flex;
            align-items:center;
            gap:10px;
            padding:14px 22px;
            background:#e11d2e;
            color:#fff;
            font-weight:bold;
            font-size:17px;
        }

        .pending-count{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:24px;
            height:24px;
            padding:0 7px;
            border-radius:999px;
            background:#fff;
            color:#e11d2e;
            font-size:13px;
        }

        .pending-item{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            padding:18px 22px;
            border-bottom:1px solid #eee;
        }

        .pending-item:last-child{
            border-bottom:0;
        }

        .pending-info h3{
            font-size:16px;
            margin-bottom:4px;
        }

        .pending-info p{
            color:#666;
            font-size:13px;
            line-height:1.5;
        }

        .pending-total{
            margin-top:8px;
            font-size:20px;
            font-weight:bold;
            color:#111;
        }

        .pending-actions{
            display:flex;
            flex-wrap:wrap;
            gap:8px;
            flex-shrink:0;
        }

        .pending-actions form{
            margin:0;
        }

        .pending-actions a,
        .pending-actions button{
            display:inline-block;
            padding:11px 16px;
            border:1px solid #111;
            background:#fff;
            color:#111;
            font-family:inherit;
            font-size:13px;
            font-weight:bold;
            text-decoration:none;
            cursor:pointer;
        }

        .pending-actions button.approve{
            border-color:#e11d2e;
            background:#e11d2e;
            color:#fff;
        }

        .pending-actions button.approve:hover{
            background:#c41223;
        }

        @media(max-width:700px){
            .pending-item{
                flex-direction:column;
                align-items:stretch;
            }

            .pending-actions > *{
                flex:1;
            }

            .pending-actions a,
            .pending-actions button{
                width:100%;
                text-align:center;
            }
        }

        /* ORDEN ACTIVA */
        .order-top{
            display:flex;
            justify-content:flex-end;
            margin-bottom:18px;
        }

        .order-badge{
            background:#e11d2e;
            color:white;
            font-size:13px;
            font-weight:bold;
            padding:6px 12px;
        }

        .timeline-horizontal{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            width:100%;
            margin-top:10px;
        }

        .step{
            display:flex;
            flex-direction:column;
            align-items:center;
            min-width:90px;
            text-align:center;
        }

        .step .circle{
            width:22px;
            height:22px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
            font-weight:bold;
            margin-bottom:8px;
            border:2px solid #ddd;
            background:white;
            color:#999;
        }

        .step.completed .circle{
            background:#000;
            border-color:#000;
            color:white;
        }

        .step.current .circle{
            background:#e11d2e;
            border-color:#e11d2e;
            color:white;
        }

        .step span{
            font-size:13px;
            color:#888;
        }

        .step.completed span{
            color:#555;
        }

        .step.current span{
            color:#e11d2e;
            font-weight:bold;
        }

        .line{
            flex:1;
            height:2px;
            background:#ddd;
            margin:0 8px;
            min-width:40px;
        }

        .line.completed{
            background:#666;
        }

        /* VEHICULOS */
        .vehicle-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:16px 0;
            border-bottom:1px solid #eee;
        }

        .vehicle-row:last-child{
            border-bottom:none;
        }

        .vehicle-info h3{
            font-size:16px;
            margin-bottom:6px;
        }

        .vehicle-info p{
            color:#777;
            font-size:14px;
        }

        .vehicle-dot{
            width:10px;
            height:10px;
            background:#e11d2e;
            border-radius:50%;
        }

        @media(max-width:1100px){
            .stats{
                grid-template-columns:repeat(2, 1fr);
            }

            .timeline-horizontal{
                flex-wrap:wrap;
                justify-content:center;
            }

            .line{
                display:none;
            }
        }

        @media(max-width:560px){
            .stats{
                grid-template-columns:1fr;
            }
        }

        @media(max-width:850px){
            .layout{
                flex-direction:column;
            }

            .sidebar{
                width:100%;
            }

            .content{
                padding:18px;
            }
        }
    </style>
</head>
<body>

<div class="layout">

    <aside class="sidebar">

        <div class="sidebar-top">

            <div class="brand">
                <div class="brand-box">A</div>

                <div class="brand-text">
                    <h2>AutoManager</h2>
                    <p>Cliente</p>
                </div>
            </div>

            <nav class="menu">
            @include('cliente.partials.menu')
        </nav>

        </div>

        <div class="sidebar-bottom">
            <p>Sesión activa</p>
            <h4>{{ auth()->user()->name }}</h4>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">◦ Cerrar sesión</button>
            </form>
        </div>

    </aside>

    <main class="main">

        <div class="topbar">
            <h1>Bienvenido, {{ auth()->user()->name }}</h1>
            <p>Resumen de tu cuenta</p>
        </div>

        <div class="content">

            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            {{-- PRESUPUESTOS POR AUTORIZAR (visibles desde el inicio) --}}
            @if($pendingAuthorizationsList->isNotEmpty())
                <section class="pending" id="autorizaciones-pendientes">
                    <div class="pending-header">
                        <span class="pending-count">{{ $pendingAuthorizationsList->count() }}</span>
                        {{ $pendingAuthorizationsList->count() === 1 ? 'Tienes un presupuesto por autorizar' : 'Tienes presupuestos por autorizar' }}
                    </div>

                    @foreach($pendingAuthorizationsList as $pendiente)
                        @php $total = number_format((float) $pendiente->estimated_cost, 2); @endphp

                        <div class="pending-item">
                            <div class="pending-info">
                                <h3>
                                    {{ $pendiente->vehicle?->brand }} {{ $pendiente->vehicle?->model }} {{ $pendiente->vehicle?->year }}
                                    · {{ $pendiente->folio }}
                                </h3>
                                <p>{{ \Illuminate\Support\Str::limit($pendiente->diagnosis, 160) }}</p>
                                <p>{{ $pendiente->orderItems->count() }} concepto(s)</p>
                                <div class="pending-total">${{ $total }} MXN</div>
                            </div>

                            <div class="pending-actions">
                                <a href="{{ route('cliente.autorizaciones') }}">Ver detalle</a>

                                <form
                                    action="{{ route('cliente.autorizaciones.reject', $pendiente) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de rechazar esta reparación?')"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">Rechazar</button>
                                </form>

                                <form
                                    action="{{ route('cliente.autorizaciones.approve', $pendiente) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Deseas autorizar esta reparación por ${{ $total }} MXN?')"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="approve">Autorizar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif

            <div class="stats">
                <div class="card">
                    <small>Vehículos registrados</small>
                    <h2>{{ $vehicles->count() }}</h2>
                </div>

                <div class="card">
                    <small>Próxima cita</small>
                    <h2>
                        @if($nextAppointment)
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('d/m/Y') }}
                        @else
                            Sin cita
                        @endif
                    </h2>
                </div>

                <div class="card">
                    <small>Orden activa</small>
                    <h2 class="red">
                        {{ $activeOrder?->folio ?? 'Sin orden' }}
                    </h2>
                </div>

                <div class="card {{ $pendingAuthorizationsList->isNotEmpty() ? 'alert' : '' }}">
                    <small>Autorizaciones pendientes</small>
                    <h2 class="{{ $pendingAuthorizationsList->isNotEmpty() ? 'red' : '' }}">
                        {{ $pendingAuthorizationsList->count() }}
                    </h2>
                    @if($pendingAuthorizationsList->isNotEmpty())
                        <a class="card-link" href="#autorizaciones-pendientes">Revisar ahora ↑</a>
                    @endif
                </div>
            </div>

            <div class="section">
                <div class="section-header">Orden activa</div>

                <div class="section-body">

                    @if($activeOrder)

    <div class="order-top">
        <div class="order-badge">
            {{ $activeOrder->folio }}
        </div>
    </div>

    @php
        // Etapas que ve el cliente y en cuál va su orden.
        $etapas = [
            'Recepción' => ['pendiente'],
            'Diagnóstico' => ['diagnostico', 'esperando_aprobacion'],
            'En proceso' => ['en_proceso'],
            'Control calidad' => ['control_calidad'],
            'Entrega' => ['listo'],
        ];
        $actual = 0;
        foreach (array_values($etapas) as $i => $estados) {
            if (in_array($activeOrder->status, $estados, true)) {
                $actual = $i;
            }
        }
    @endphp

    <p style="color:#666; margin-bottom:6px;">
        {{ $activeOrder->vehicle?->brand }} {{ $activeOrder->vehicle?->model }}
        · Estado: <strong>{{ $activeOrder->status_label }}</strong>
    </p>

    <div class="timeline-horizontal">
        @foreach(array_keys($etapas) as $i => $etapa)
            @if($i > 0)
                <div class="line {{ $i <= $actual ? 'completed' : '' }}"></div>
            @endif

            <div class="step {{ $i < $actual ? 'completed' : '' }} {{ $i === $actual ? 'current' : '' }}">
                <div class="circle">{{ $i < $actual ? '✓' : ($i === $actual ? '•' : '') }}</div>
                <span>{{ $etapa }}</span>
            </div>
        @endforeach
    </div>

        @else

            <div style="text-align:center; color:#777; padding:20px;">
                No tienes una orden activa.
            </div>

        @endif

                </div>
            </div>

            <div class="section">
                <div class="section-header">Mis vehículos</div>

                <div class="section-body">

    @forelse($vehicles as $vehicle)

        <div class="vehicle-row">

            <div class="vehicle-info">
                <h3>
                    {{ $vehicle->brand }}
                    {{ $vehicle->model }}
                    {{ $vehicle->year }}
                </h3>

                <p>
                    {{ $vehicle->plates ?: 'Sin placas' }}
                    ·
                    {{ number_format($vehicle->mileage ?? 0) }} km
                </p>
            </div>

            <div class="vehicle-dot"></div>

        </div>

                        @empty

                            <div style="text-align:center; color:#777; padding:20px;">
                                No tienes vehículos registrados.
                            </div>

                        @endforelse

                    </div>

                </div>
            </div>

        </div>

    </main>

</div>

</body>
</html>