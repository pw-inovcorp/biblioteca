<?php

use App\Models\Livro;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/livros', function () {
    $livros = Livro::with('editor','autores')->simplePaginate(6);
    return view('livros/index', ['livros' => $livros]);
});

Route::get('/livros/create', function () {
    $editoras = \App\Models\Editor::orderBy('name')->get();
    $autores = \App\Models\Autor::orderBy('name')->get();
    return view('livros/create', ['editoras' => $editoras, 'autores' => $autores]);
});

Route::post('/livros', function () {
    $data = request()->validate([
        'isbn' => 'required|string|max:255|unique:livros',
        'name' => 'required|string|max:255|min:3',
        'editor_id' => 'required|exists:editors,id',
        'autores' => 'required|array',
        'autores.*' => 'exists:autores,id',
        'bibliography' => 'required|string|max:1000',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'price' => 'required|integer|min:0',
    ]);

    // Handle the image upload
    if (request()->hasFile('image')) {
        $data['image'] = request()->file('image')->store('livros', 'public');
    }

    \App\Models\Livro::create($data);

    return redirect('/livros');
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
    return view('autores/index', ['autores' => $autores]);
});

Route::get('/autores/create', function () {
    return view('autores/create');
});

Route::post('/autores', function () {
    $data = request()->validate([
        'name' => 'required|string|max:255|min:3',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle the photo upload
    if (request()->hasFile('foto')) {
        $data['foto'] = request()->file('foto')->store('autores', 'public');
    }

    \App\Models\Autor::create($data);

    return redirect('/autores');
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
