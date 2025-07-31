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

//Index
Route::get('/editoras', function () {
    $editoras = \App\Models\Editor::paginate(6);
    return view('editoras/index', ['editoras' => $editoras]);
});

//Create
Route::get('/editoras/create', function () {
    return view('editoras/create');
});

//Store
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

//Edit
Route::get('/editoras/{id}/edit', function ($id) {

     $editora = \App\Models\Editor::findOrFail($id);

    return view('editoras/edit', ['editora' => $editora]);
});

//Update
Route::patch('/editoras/{id}', function ($id) {
    // Validation
    $data = request()->validate([
        'name' => 'required|string|max:255|min:3',
        'logotipo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Serch
    $editora = \App\Models\Editor::findOrFail($id);

    // Handle the logo upload
    if (request()->hasFile('logotipo')) {
        $data['logotipo'] = request()->file('logotipo')->store('editoras', 'public');
    } else {
        // Retain the existing logo if no new file is uploaded
        unset($data['logotipo']);
    }

    // Update
    $editora->update($data);

    // Redirect
    return redirect('/editoras');
});

//Delete
Route::delete('/editoras/{id}', function ($id) {

    // Find the editor by ID
    $editora = \App\Models\Editor::findOrFail($id);

    // Check if the editor has associated books

    // Delete the editor
    $editora->delete();

    // Redirect back to the editoras
    return redirect('/editoras');
});


//Index
Route::get('/autores', function () {
    $autores = \App\Models\Autor::simplePaginate(6);
    return view('autores/index', ['autores' => $autores]);
});

//Create
Route::get('/autores/create', function () {
    return view('autores/create');
});

//Store
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

// Edit
Route::get('/autores/{id}/edit', function ($id) {
    $autor = \App\Models\Autor::findOrFail($id);
    return view('autores/edit', ['autor' => $autor]);
});

// Update
Route::patch('/autores/{id}', function ($id) {
    // Validation
    $data = request()->validate([
        'name' => 'required|string|max:255|min:3',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    // Search
    $autor = \App\Models\Autor::findOrFail($id);

    // Handle the photo upload
    if (request()->hasFile('foto')) {
        $data['foto'] = request()->file('foto')->store('autores', 'public');
    } else {
        // Retain the existing photo if no new file is uploaded
        unset($data['foto']);
    }

    // Update
    $autor->update($data);

    // Redirect
    return redirect('/autores');
});

// Delete
Route::delete('/autores/{id}', function ($id) {
    // Find the author by ID
    $autor = \App\Models\Autor::findOrFail($id);
    
    // Check if the author has associated books

    // Delete the author
    $autor->delete();
    // Redirect back to the authors
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
