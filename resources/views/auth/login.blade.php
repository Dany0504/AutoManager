<x-guest-layout>
    <x-slot:title>Iniciar sesión</x-slot:title>

    <h3>Iniciar sesión</h3>
    <p class="subtitulo">Accede a tu cuenta de AutoManager.</p>

    @if (session('status'))
        <div class="alerta exito">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="campo @error('email') con-error @enderror">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   placeholder="correo@ejemplo.com" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <div class="campo @error('password') con-error @enderror">
            <label for="password">Contraseña</label>
            <div class="password-wrap">
                <input id="password" type="password" name="password"
                       placeholder="••••••••" required autocomplete="current-password">
                <button type="button" class="ver-password" data-target="password" aria-label="Mostrar contraseña">Mostrar</button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="error" />
        </div>

        <div class="fila">
            <label for="remember_me" class="recordar">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="enlace" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <button type="submit" class="btn-principal">Ingresar</button>
    </form>

    <p class="pie-card">
        ¿No tienes cuenta?
        <a class="enlace" href="{{ route('register') }}">Regístrate</a>
    </p>
</x-guest-layout>
