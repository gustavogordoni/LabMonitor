<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\ComputerSelection;
use App\Livewire\Admin\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user/select-computer', ComputerSelection::class)
        ->name('user.computer');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    // add minha delitmitação de admin
])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)
        ->name('admin.dashboard');
});
