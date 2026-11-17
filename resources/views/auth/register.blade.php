<x-guest-layout>
    <x-slot:title>Crear cuenta</x-slot:title>

    <h3>Crear cuenta</h3>
    <p class="subtitulo">Regístrate para agendar citas y dar seguimiento a tu vehículo.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="campo @error('name') con-error @enderror">
            <label for="name">Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   placeholder="Juan Pérez" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="error" />
        </div>

        <div class="campo @error('email') con-error @enderror">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   placeholder="correo@ejemplo.com" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <div class="campo @error('password') con-error @enderror">
            <label for="password">Contraseña</label>
            <div class="password-wrap">
                <input id="password" type="password" name="password"
                       placeholder="Mínimo 8 caracteres" required autocomplete="new-password">
                <button type="button" class="ver-password" data-target="password" aria-label="Mostrar contraseña">Mostrar</button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="error" />
        </div>

        <div class="campo @error('password_confirmation') con-error @enderror">
            <label for="password_confirmation">Confirmar contraseña</label>
            <div class="password-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation"
                       placeholder="Repite tu contraseña" required autocomplete="new-password">
                <button type="button" class="ver-password" data-target="password_confirmation" aria-label="Mostrar contraseña">Mostrar</button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="error" />
        </div>

        <button type="submit" class="btn-principal">Crear cuenta</button>
    </form>

    <p class="pie-card">
        ¿Ya tienes cuenta?
        <a class="enlace" href="{{ route('login') }}">Inicia sesión</a>
    </p>
</x-guest-layout>
