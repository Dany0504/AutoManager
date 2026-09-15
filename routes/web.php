<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if($user->rol === 'cliente') {
        return redirect('/cliente');
    }
    if($user->rol === 'mecanico') {
        return redirect('/mecanico');
    }
    if($user->rol === 'administrador') {
        return redirect('/admin');
    }

    abort(403, 'Rol de usuario no válido.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cliente', function () {
    return view('cliente.dashboard');
})->middleware(['auth', 'role:cliente']);

Route::get('/mecanico', function () {
    return view('mecanico.dashboard');
})->middleware(['auth', 'role:mecanico']);

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:administrador']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
