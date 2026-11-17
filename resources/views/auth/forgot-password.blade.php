<x-guest-layout>
    <x-slot:title>Recuperar contraseña</x-slot:title>

    <h3>Recuperar contraseña</h3>
    <p class="subtitulo">Escribe tu correo y te enviaremos un enlace para crear una nueva contraseña.</p>

    @if (session('status'))
        <div class="alerta exito">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="campo @error('email') con-error @enderror">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   placeholder="correo@ejemplo.com" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <button type="submit" class="btn-principal">Enviar enlace</button>
    </form>

    <p class="pie-card">
        <a class="enlace" href="{{ route('login') }}">Volver a iniciar sesión</a>
    </p>
</x-guest-layout>
