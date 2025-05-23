<?php

use App\Livewire\Admin\Room;
use App\Livewire\User\History;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\StudentList;
use App\Livewire\Admin\ComputerList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\StudentDetails;
use App\Livewire\Admin\ComputerDetails;
use App\Livewire\User\ComputerSelection;
use App\Http\Controllers\RegisterStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Aluno
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'student',
])->group(function () {
    Route::get('/user/select-computer', ComputerSelection::class)
        ->name('user.computer');
    Route::get('/user/history', History::class)
        ->name('user.history');    
});

// Admin
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::get('/admin', Dashboard::class)
        ->name('admin.dashboard');
    Route::get('/admin/stundent/{userId}', StudentDetails::class)->name('admin.student.details');
    Route::get('/admin/computer/{computerId}', ComputerDetails::class)->name('admin.computer.details');
    Route::get('/admin/students', StudentList::class)->name('admin.students');
    Route::get('/admin/computers', ComputerList::class)->name('admin.computers');
    Route::get('/admin/rooms', Room::class)->name('admin.rooms');

    Route::get('/admin/register-student', [RegisterStudentController::class, 'create'])->name('admin.register.student');
    Route::post('/admin/register-student', [RegisterStudentController::class, 'store']);

    Route::get('/admin/export-today-usage', [Dashboard::class, 'exportTodayUsageRaw'])
        ->name('admin.export.today-usage');
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