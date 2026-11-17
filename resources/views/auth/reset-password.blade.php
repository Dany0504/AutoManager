<x-guest-layout>
    <x-slot:title>Nueva contraseña</x-slot:title>

    <h3>Nueva contraseña</h3>
    <p class="subtitulo">Elige una contraseña nueva para tu cuenta.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="campo @error('email') con-error @enderror">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                   required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <div class="campo @error('password') con-error @enderror">
            <label for="password">Nueva contraseña</label>
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

        <button type="submit" class="btn-principal">Guardar contraseña</button>
    </form>
</x-guest-layout>
