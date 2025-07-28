<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/livros', function () {
    return view('livros');
});

Route::get('/editoras', function () {
    return view('editoras');
});

Route::get('/autores', function () {
    return view('autores');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
