<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de usuarios - AutoManager</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 18px;
            border-bottom: 1px solid #1d1d1d;
        }

        .brand-box {
            width: 26px;
            height: 26px;
            border-radius: 4px;
            background: #e11d2e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .brand h2 {
            font-size: 18px;
        }

        .brand p {
            color: #bbb;
            font-size: 12px;
            margin-top: 3px;
        }

        .menu {
            margin-top: 8px;
        }

        .menu a {
            display: block;
            padding: 14px 18px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .menu a:hover {
            background: #111;
        }

        .menu a.active {
            background: #1a1a1a;
            border-left: 4px solid #e11d2e;
            padding-left: 14px;
        }

        .sidebar-bottom {
            padding: 18px;
            border-top: 1px solid #1d1d1d;
        }

        .sidebar-bottom p {
            color: #aaa;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .sidebar-bottom h4 {
            margin-bottom: 14px;
        }

        .sidebar-bottom a,
        .sidebar-bottom button {
            display: block;
            color: #bbb;
            background: none;
            border: none;
            text-decoration: none;
            font-size: 15px;
            margin-top: 12px;
            cursor: pointer;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
            padding: 24px 28px;
        }

        .topbar h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;
            font-size: 14px;
        }

        .content {
            padding: 28px;
        }

        .panel {
            background: white;
            border: 1px solid #ddd;
        }

        .panel-header {
            padding: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            border-bottom: 1px solid #ddd;
        }

        .panel-header h2 {
            font-size: 20px;
            margin-bottom: 6px;
        }

        .panel-header p {
            color: #777;
            font-size: 14px;
        }

        .btn-red {
            display: inline-block;
            background: #e11d2e;
            color: white;
            border: none;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .filters {
            display: flex;
            gap: 10px;
            padding: 20px 22px;
            flex-wrap: wrap;
        }

        .filter {
            padding: 10px 18px;
            border: 1px solid #ddd;
            color: #444;
            text-decoration: none;
            font-size: 14px;
        }

        .filter.active {
            background: #111;
            color: white;
            border-color: #111;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f7f7f7;
            color: #666;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            padding: 15px 20px;
        }

        td {
            padding: 18px 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
        }

        .user-name {
            font-weight: bold;
        }

        .role {
            display: inline-block;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            background: #eee;
        }

        .role.admin {
            background: #fee2e2;
            color: #b91c1c;
        }

        .role.mecanico {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .role.cliente {
            background: #e5e7eb;
            color: #374151;
        }

        .status {
            color: #15803d;
            font-weight: bold;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 12px;
        }

        .actions button {
            border: none;
            background: none;
            color: #555;
            font-size: 13px;
            cursor: not-allowed;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 35px;
        }

        @media (max-width: 850px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 16px;
            }

            .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* VENTANA NUEVO USUARIO */

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.visible {
            display: flex;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 28px;
            border-top: 5px solid #e11d2e;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-header h2 {
            font-size: 22px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-cancel {
            padding: 12px 18px;
            background: white;
            border: 1px solid #ccc;
            cursor: pointer;
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-box">A</div>

                <div>
                    <h2>AutoManager</h2>
                    <p>Administrador</p>
                </div>
            </div>

            <nav class="menu">
                <a href="{{ url('/admin') }}">Dashboard</a>

                <a href="{{ route('citas.index') }}">Citas</a>

                <a href="{{ route('usuarios.index') }}" class="active">Usuarios</a>

                <a href="{{ route('vehiculos.index') }}">Vehículos</a>

                <a href="{{ route('ordenes.index') }}">Órdenes</a>

                <a href="{{ route('reportes.index') }}">Reportes</a>

                <a href="{{ route('parametros.index') }}">
                    Parámetros
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <p>Sesión activa</p>
            <h4>{{ auth()->user()->name }}</h4>

            <a href="{{ route('profile.edit') }}">Perfil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">◦ Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="main">
            <div class="topbar">
                <h1>Gestión de usuarios</h1>
                <p>Administra los usuarios registrados en AutoManager.</p>
            </div>

            <div class="content">
                <section class="panel">
                    @if (session('error'))
                <div style="padding: 14px; margin-bottom: 18px; background: #fee2e2; color: #991b1b;">
                    {{ session('error') }}
                </div>
                     @endif
                    @if (session('success'))
            <div style="padding: 14px; margin-bottom: 18px; background: #dcfce7; color: #166534;">
                {{ session('success') }}
            </div>
                    @endif

                @if ($errors->any())
                    <div style="padding: 14px; margin-bottom: 18px; background: #fee2e2; color: #991b1b;">
                        <strong>Revisa los siguientes datos:</strong>

                        <ul style="margin: 10px 0 0 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel-header">
                    <div>
                        <h2>Usuarios registrados</h2>
                        <p>Total de usuarios: {{ $totalUsuarios }}</p>
                    </div>

                    <button class="btn-red" type="button" onclick="abrirModal()">
                        + Nuevo usuario
                    </button>
                </div>

                <div class="filters">
                    <a href="{{ route('usuarios.index') }}"
                       class="filter {{ $rol === 'todos' ? 'active' : '' }}">
                        Todos
                    </a>

                    <a href="{{ route('usuarios.index', ['rol' => 'cliente']) }}"
                       class="filter {{ $rol === 'cliente' ? 'active' : '' }}">
                        Cliente
                    </a>

                    <a href="{{ route('usuarios.index', ['rol' => 'mecanico']) }}"
                       class="filter {{ $rol === 'mecanico' ? 'active' : '' }}">
                        Mecánico
                    </a>

                    <a href="{{ route('usuarios.index', ['rol' => 'administrador']) }}"
                       class="filter {{ $rol === 'administrador' ? 'active' : '' }}">
                        Admin
                    </a>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Ingreso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

<tbody>
    @forelse ($usuarios as $usuario)
        <tr>
            <td class="user-name">
                {{ $usuario->name }}
            </td>

            <td>
                {{ $usuario->email }}
            </td>

            <td>
                <span class="role {{ $usuario->rol }}">
                    {{ ucfirst($usuario->rol) }}
                </span>
            </td>

            <td>
                @if ($usuario->activo)
                    <span class="status" style="color: #15803d;">
                        ● Activo
                    </span>
                @else
                    <span class="status" style="color: #dc2626;">
                        ● Inactivo
                    </span>
                @endif
            </td>

            <td>
                {{ $usuario->created_at?->format('d/m/Y') ?? '—' }}
            </td>

            <td>
                <div class="actions">

                    <button
                        type="button"
                        style="cursor: pointer; color: #2563eb;"
                        onclick="abrirEditar(
                            @js($usuario->id),
                            @js($usuario->name),
                            @js($usuario->email),
                            @js($usuario->phone),
                            @js($usuario->rol)
                        )"
                    >
                        Editar
                    </button>

                    <button
                        type="button"
                        style="cursor: pointer; color: #e11d2e;"
                        onclick="abrirRestablecer(
                            @js($usuario->id),
                            @js($usuario->name)
                        )"
                    >
                        Restablecer
                    </button>

                    @if ($usuario->id !== auth()->id())
                        <form
                            method="POST"
                            action="{{ route('usuarios.cambiarEstado', $usuario->id) }}"
                            onsubmit="return confirm('¿Seguro que deseas cambiar el estado de este usuario?');"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                style="cursor: pointer; color: {{ $usuario->activo ? '#dc2626' : '#15803d' }};"
                            >
                                {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                    @endif

                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="empty">
                No hay usuarios registrados en este filtro.
            </td>
        </tr>
    @endforelse
</tbody>

                    </table>
                </div>

            </section>
        </div>
    </main>

</div>
<!-- MODAL EDITAR USUARIO -->
<div id="modalEditar" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Editar usuario</h2>

            <button type="button" class="modal-close"
                    onclick="cerrarEditar()">
                &times;
            </button>
        </div>

        <form id="formEditar" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" name="name" id="editarNombre"
                       maxlength="255" required>
            </div>

            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" id="editarCorreo"
                       maxlength="255" required>
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" name="phone" id="editarTelefono"
                       maxlength="20">
            </div>

            <div class="form-group">
                <label>Rol</label>
                <select name="rol" id="editarRol" required>
                    <option value="cliente">Cliente</option>
                    <option value="mecanico">Mecánico</option>
                    <option value="administrador">Administrador</option>
                    <input type="hidden" name="rol" id="editarRolOculto" disabled>
                </select>
            </div>

            <div class="form-buttons">
                <button type="button" class="btn-cancel"
                        onclick="cerrarEditar()">
                    Cancelar
                </button>

                <button type="submit" class="btn-red">
                    Guardar cambios
                </button>
            </div>
        </form>

    </div>
</div>
<!-- MODAL RESTABLECER CONTRASEÑA -->
<div id="modalRestablecer" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Restablecer contraseña</h2>

            <button type="button" class="modal-close"
                    onclick="cerrarRestablecer()">
                &times;
            </button>
        </div>

        <p style="margin-bottom: 20px; color: #666;">
            Nueva contraseña para:
            <strong id="nombreRestablecer"></strong>
        </p>

        <form id="formRestablecer" method="POST" action="">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Nueva contraseña</label>
                <input
                    type="password"
                    name="password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input
                    type="password"
                    name="password_confirmation"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-buttons">
                <button type="button" class="btn-cancel"
                        onclick="cerrarRestablecer()">
                    Cancelar
                </button>

                <button type="submit" class="btn-red">
                    Guardar contraseña
                </button>
            </div>
        </form>

    </div>
</div>
<!-- MODAL NUEVO USUARIO -->
<div id="modalUsuario" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Nuevo usuario</h2>

            <button type="button" class="modal-close"
                    onclick="cerrarModal()">
                &times;
            </button>
        </div>

        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf

            <div class="form-group">
                <label>Nombre completo</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Correo electrónico</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                >
            </div>

            <div class="form-group">
                <label>Rol</label>
                <select name="rol" required>
                    <option value="">Seleccionar rol</option>
                    <option value="cliente" {{ old('rol') === 'cliente' ? 'selected' : '' }}>
                        Cliente
                    </option>
                    <option value="mecanico" {{ old('rol') === 'mecanico' ? 'selected' : '' }}>
                        Mecánico
                    </option>
                    <option value="administrador" {{ old('rol') === 'administrador' ? 'selected' : '' }}>
                        Administrador
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input
                    type="password"
                    name="password"
                    minlength="8"
                    required
                >
            </div>

            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input
                    type="password"
                    name="password_confirmation"
                    minlength="8"
                    required
                >
            </div>

            <div class="form-buttons">
                <button type="button" class="btn-cancel"
                        onclick="cerrarModal()">
                    Cancelar
                </button>

                <button type="submit" class="btn-red">
                    Guardar usuario
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function abrirModal() {
        document.getElementById('modalUsuario').classList.add('visible');
    }

    function cerrarModal() {
        document.getElementById('modalUsuario').classList.remove('visible');
    }

    document.getElementById('modalUsuario').addEventListener('click', function(event) {
        if (event.target === this) {
            cerrarModal();
        }
    });
    function abrirEditar(id, nombre, correo, telefono, rol) {
        const form = document.getElementById('formEditar');

        const ruta = @js(route('usuarios.update', ['usuario' => '__ID__']));

        form.action = ruta.replace('__ID__', encodeURIComponent(id));

        document.getElementById('editarNombre').value = nombre;
        document.getElementById('editarCorreo').value = correo;
        document.getElementById('editarTelefono').value = telefono ?? '';
        document.getElementById('editarRol').value = rol;

        const selectorRol = document.getElementById('editarRol');

        // El administrador no puede cambiar su propio rol.
        selectorRol.disabled = Number(id) === @js(auth()->id());
        const rolOculto = document.getElementById('editarRolOculto');

        rolOculto.value = rol;
        rolOculto.disabled = !selectorRol.disabled;

        // Un campo deshabilitado no se envía en el formulario.
        // El controlador conserva el rol del administrador.
        document.getElementById('modalEditar').classList.add('visible');
    }

    function cerrarEditar() {
        document.getElementById('modalEditar').classList.remove('visible');
    }
        function abrirRestablecer(id, nombre) {
        const form = document.getElementById('formRestablecer');

        const ruta = @js(route('usuarios.resetPassword', ['usuario' => '__ID__']));

        form.action = ruta.replace('__ID__', encodeURIComponent(id));

        form.reset();

        document.getElementById('nombreRestablecer').textContent = nombre;

        document.getElementById('modalRestablecer').classList.add('visible');
    }

    function cerrarRestablecer() {
        document.getElementById('modalRestablecer').classList.remove('visible');
    }
</script>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            abrirModal();
        });
    </script>
@endif

@include('partials.campos-obligatorios')
</body>
</html>