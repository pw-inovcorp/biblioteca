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
    return view('editoras/index', ['editoras' => $editoras]);
});

Route::get('/editoras/create', function () {
    return view('editoras/create');
});

Route::post('/editoras', function () {
    $data = request()->validate([
        'name' => 'required|string|max:255|min:3',
        'logotipo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle the logo upload
    if (request()->hasFile('logotipo')) {
        $data['logotipo'] = request()->file('logotipo')->store('editoras', 'public');
    }

    \App\Models\Editor::create($data);

    return redirect('/editoras');
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
