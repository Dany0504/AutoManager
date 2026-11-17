<x-guest-layout>
    <x-slot:title>Verificar correo</x-slot:title>

    <h3>Verifica tu correo</h3>
    <p class="subtitulo">
        ¡Gracias por registrarte! Antes de comenzar, verifica tu correo con el enlace que te enviamos.
        Si no lo recibiste, podemos enviarte otro.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alerta exito">
            Te enviamos un nuevo enlace de verificación al correo que registraste.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-principal">Reenviar correo de verificación</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="pie-card">
        @csrf
        <button type="submit" class="enlace">Cerrar sesión</button>
    </form>
</x-guest-layout>
