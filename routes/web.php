<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\ComputerSelection;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\UserDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Apenas logado no sistema
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'user',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user/select-computer', ComputerSelection::class)
        ->name('user.computer');
});


// Logado e é admin (falta implementar)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)
        ->name('admin.dashboard');
    Route::get('/admin/users/{userId}', UserDetails::class)->name('admin.user.details');
});


// Route::middleware(['admin'])->group(function () {
//     // Somente admins
// });

// Route::middleware(['user'])->group(function () {
//     // Somente usuários comuns
// });

// Route::middleware(['guestOrUser'])->group(function () {
//     // Acesso público ou user logado
// });