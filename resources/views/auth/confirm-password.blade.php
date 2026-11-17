<x-guest-layout>
    <x-slot:title>Confirmar contraseña</x-slot:title>

    <h3>Confirmar contraseña</h3>
    <p class="subtitulo">Esta es un área segura. Confirma tu contraseña para continuar.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="campo @error('password') con-error @enderror">
            <label for="password">Contraseña</label>
            <div class="password-wrap">
                <input id="password" type="password" name="password"
                       placeholder="••••••••" required autocomplete="current-password">
                <button type="button" class="ver-password" data-target="password" aria-label="Mostrar contraseña">Mostrar</button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="error" />
        </div>

        <button type="submit" class="btn-principal">Confirmar</button>
    </form>
</x-guest-layout>
