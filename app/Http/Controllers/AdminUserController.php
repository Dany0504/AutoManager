<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $rol = $request->query('rol', 'todos');

        $usuarios = User::query()
            ->when(
                in_array($rol, ['cliente', 'mecanico', 'administrador'], true),
                fn ($query) => $query->where('rol', $rol)
            )
            ->orderBy('name')
            ->get();

        $totalUsuarios = User::count();

        return view('admin.usuarios.index', compact(
            'usuarios',
            'totalUsuarios',
            'rol'
        ));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'rol' => ['required', 'in:cliente,mecanico,administrador'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($datos);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function update(Request $request, User $usuario)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'rol' => ['required', 'in:cliente,mecanico,administrador'],
        ]);

        if ($usuario->id === auth()->id()) {
            $datos['rol'] = $usuario->rol;
        }

        $usuario->update($datos);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function resetPassword(Request $request, User $usuario)
    {
        $datos = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario->update([
            'password' => $datos['password'],
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    public function cambiarEstado(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Estado del usuario actualizado correctamente.');
    }
}