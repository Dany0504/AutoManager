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
            grid-template-columns:repeat(3, 1fr);
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
                grid-template-columns:1fr;
            }

            .timeline-horizontal{
                flex-wrap:wrap;
                justify-content:center;
            }

            .line{
                display:none;
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
                <a href="#" class="active">Inicio</a>
                <a href="#">Mis vehículos</a>
                <a href="#">Agendar cita</a>
                <a href="#">Mis citas</a>
                <a href="#">Rastrear orden</a>
                <a href="#">Historial</a>
                <a href="#">Autorizaciones</a>
                <a href="#">Perfil</a>
            </nav>

        </div>

        <div class="sidebar-bottom">
            <p>Sesión activa</p>
            <h4>{{ auth()->user()->name }}</h4>

            <a href="#">← Contraer</a>

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

            <div class="stats">
                <div class="card">
                    <small>Vehículos registrados</small>
                    <h2>2</h2>
                </div>

                <div class="card">
                    <small>Próxima cita</small>
                    <h2 class="red">5 Sep</h2>
                </div>

                <div class="card">
                    <small>Orden activa</small>
                    <h2>ORD-142</h2>
                </div>
            </div>

            <div class="section">
                <div class="section-header">Orden activa</div>

                <div class="section-body">

                    <div class="order-top">
                        <div class="order-badge">ORD-2026-00142</div>
                    </div>

                    <div class="timeline-horizontal">

                        <div class="step completed">
                            <div class="circle">✓</div>
                            <span>Recepción</span>
                        </div>

                        <div class="line completed"></div>

                        <div class="step completed">
                            <div class="circle">✓</div>
                            <span>Diagnóstico</span>
                        </div>

                        <div class="line completed"></div>

                        <div class="step current">
                            <div class="circle">•</div>
                            <span>En proceso</span>
                        </div>

                        <div class="line"></div>

                        <div class="step">
                            <div class="circle"></div>
                            <span>Control calidad</span>
                        </div>

                        <div class="line"></div>

                        <div class="step">
                            <div class="circle"></div>
                            <span>Entrega</span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="section">
                <div class="section-header">Mis vehículos</div>

                <div class="section-body">

                    <div class="vehicle-row">
                        <div class="vehicle-info">
                            <h3>Honda Accord 2005</h3>
                            <p>ABC-123-MX · 999,999 km</p>
                        </div>

                        <div class="vehicle-dot"></div>
                    </div>

                    <div class="vehicle-row">
                        <div class="vehicle-info">
                            <h3>GMC Sierra 2026</h3>
                            <p>XYZ-456-MX · 67 km</p>
                        </div>

                        <div class="vehicle-dot"></div>
                    </div>

                </div>
            </div>

        </div>

    </main>

</div>

</body>
</html>