<?php

use App\Http\Controllers\EditorController;
use App\Models\Editor;
use App\Models\Livro;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use Illuminate\Validation\Rule;

Route::get('/', function () {
    return redirect()->route('dashboard');
});



// //Index
// Route::get('/livros', function () {
//     $livros = Livro::with('editor','autores')->simplePaginate(6);
//     return view('livros/index', ['livros' => $livros]);
// });

// //Create
// Route::get('/livros/create', function () {
//     $editoras = \App\Models\Editor::orderBy('name')->get();
//     $autores = \App\Models\Autor::orderBy('name')->get();
//     return view('livros/create', ['editoras' => $editoras, 'autores' => $autores]);
// });

// //Store
// Route::post('/livros', function () {
   
// });

// //Edit 
// Route::get('/livros/{id}/edit', function ($id) {
//     $livro = Livro::with('editor', 'autores')->findOrFail($id);
//     $editoras = Editor::orderBy('name')->get();
//     $autores = \App\Models\Autor::orderBy('name')->get();
//     return view('livros/edit', ['livro' => $livro, 'editoras' => $editoras, 'autores' => $autores]);
// });

// //Update
// Route::patch('/livros/{id}', function ($id) {

//     // Search
//     $livro = Livro::findOrFail($id);

//     //Validate
//     $data = request()->validate([
//         'isbn' => 'required|string|max:255',Rule::unique('livros', 'isbn')->ignore($livro->id),
//         'name' => 'required|string|max:255|min:3',
//         'editor_id' => 'required|exists:editors,id',
//         'autores' => 'required|array',
//         'autores.*' => 'exists:autores,id',
//         'bibliography' => 'required|string|max:1000',
//         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'price' => 'required|integer|min:0',
//     ]);

//     // Handle the image upload
//     if (request()->hasFile('image')) {
//         $data['image'] = request()->file('image')->store('livros', 'public');
//     } else {
//         // Retain the existing image if no new file is uploaded
//         unset($data['image']);
//     }

//     $livro->update($data);

//     return redirect('/livros');
// });

// //Destroy
// Route::delete('/livros/{id}', function ($id) {
//     $livro = \App\Models\Livro::findOrFail($id);
//     $livro->delete();

//     return redirect('/livros');
// });

Route::controller(LivroController::class)->group(function() {
     //Index
    Route::get('/livros', 'index');
    //Create
    Route::get('/livros/create', 'create');
    //Store
    Route::post('/livros', 'store');
    //Edit
    Route::get('/livros/{id}/edit', 'edit');
    //Update
    Route::patch('/livros/{id}', 'update');
    //Destroy
    Route::delete('/livros/{id}', 'destroy');

});


Route::controller(EditorController::class)->group(function () {
    //Index
    Route::get('/editoras', 'index');
    //Create
    Route::get('/editoras/create', 'create');
    //Store
    Route::post('/editoras', 'store');
    //Edit
    Route::get('/editoras/{id}/edit', 'edit');
    //Update
    Route::patch('/editoras/{id}', 'update');
    //Destroy
    Route::delete('/editoras/{id}', 'destroy');

});


Route::controller(AutorController::class)->group(function () {
    //Index
    Route::get('/autores', 'index');
    //Create
    Route::get('/autores/create', 'create');
    //Store
    Route::post('/autores', 'store');
    //Edit
    Route::get('/autores/{id}/edit', 'edit');
    //Update
    Route::patch('/autores/{id}', 'update');
    //Destroy
    Route::delete('/autores/{id}', 'destroy');
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
