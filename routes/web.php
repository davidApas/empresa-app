<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Adelantos;
use App\Livewire\Personas;
use App\Livewire\Pagos;
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
    Route::get('/adelanto', Adelantos::class)->name('adelanto');
    Route::get('/persona', Personas::class)->name('persona');
    Route::get('/pagos', Pagos::class)->name('pago');
});
