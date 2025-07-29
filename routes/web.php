<?php

use App\Models\Livro;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/livros', function () {
    $livros = Livro::with('editor')->simplePaginate(6);
    return view('livros', ['livros' => $livros]);
});

Route::get('/editoras', function () {
    $editoras = \App\Models\Editor::paginate(6);
    return view('editoras', ['editoras' => $editoras]);
});

Route::get('/autores', function () {
    $autores = \App\Models\Autor::simplePaginate(6);
    return view('autores', ['autores' => $autores]);
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
