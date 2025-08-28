<?php

use App\Http\Controllers\EditorController;
use App\Http\Controllers\GoogleBooksController;
use App\Models\Editor;
use App\Models\Livro;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use Illuminate\Validation\Rule;
use App\Http\Controllers\RequisicaoController;
use App\Models\Requisicao;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LivroAlertaController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::middleware(['auth'])->group(function () {

    //Apenas visualização --para cidadao e admin
    Route::get('/livros', [LivroController::class, 'index'])->name('livros.index');
    Route::get('/livros/search', [LivroController::class, 'search'])->name('livros.search');
    Route::get('livros/show/{id}', [LivroController::class, 'show'])->name('livros.show');
    Route::get('/download', [LivroController::class, 'export']);

    Route::get('/editoras', [EditorController::class, 'index']);
    Route::get('/editoras/search', [EditorController::class, 'search'])->name('editoras.search');

    Route::get('/autores', [AutorController::class, 'index']);
    Route::get('/autores/search', [AutorController::class, 'search'])->name('autores.search');

    Route::get('/requisicoes', [RequisicaoController::class, 'index'])->name('requisicoes.index');
    Route::get('/requisicoes/create/{livro}', [RequisicaoController::class, 'create'])->name('requisicoes.create');
    Route::post('/requisicoes', [RequisicaoController::class, 'store'])->name('requisicoes.store');

    Route::get('/reviews/create/{requisicaoId}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/alertas', [LivroAlertaController::class, 'store'])->name('alertas.store');


    Route::get('/carrinho', [App\Http\Controllers\CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/carrinho', [App\Http\Controllers\CarrinhoController::class, 'store'])->name('carrinho.store');
    Route::delete('/carrinho/{id}', [App\Http\Controllers\CarrinhoController::class, 'destroy'])->name('carrinho.destroy');

    Route::get('/encomendas', [\App\Http\Controllers\EncomendaController::class, 'index'])->name('encomendas.index');
    Route::get('/encomendas/{id}', [App\Http\Controllers\EncomendaController::class, 'show'])->name('encomendas.show');

    Route::get('/checkout/morada', [\App\Http\Controllers\CheckoutController::class, 'morada'])->name('checkout.morada');
    Route::post('/checkout/morada', [App\Http\Controllers\CheckoutController::class, 'storeMorada'])->name('checkout.morada');
    Route::get('/checkout/confirmacao', [App\Http\Controllers\CheckoutController::class, 'confirmacao'])->name('checkout.confirmacao');
    Route::post('/checkout/confirmacao', [App\Http\Controllers\CheckoutController::class, 'finalizar'])->name('checkout.finalizar');

    Route::post('/encomendas/{encomenda}/checkout', [App\Http\Controllers\StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/encomendas/{encomenda}/payment-success', [App\Http\Controllers\StripeController::class, 'success'])->name('stripe.success');
    Route::get('/encomendas/{encomenda}/payment-cancel', [App\Http\Controllers\StripeController::class, 'cancel'])->name('stripe.cancel');
});

Route::middleware(['auth', 'admin'])->group(function() {

    // Admin CRUD

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/show/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::patch('/reviews/{id}/aprovar', [ReviewController::class, 'aprovar'])->name('reviews.aprovar');
    Route::patch('/reviews/{id}/recusar', [ReviewController::class, 'recusar'])->name('reviews.recusar');
    Route::get('/reviews/search', [ReviewController::class, 'search'])->name('reviews.search');



    Route::get('/google-books', [GoogleBooksController::class, 'index'])->name('google-books.index');
//  Route::get('/google-books/test', [GoogleBooksController::class, 'test'])->name('google-books.test');
    Route::get('/google-books/search', [GoogleBooksController::class, 'search'])->name('google-books.search');
    Route::post('/google-books/show', [GoogleBooksController::class, 'show'])->name('google-books.show');
    Route::post('/google-books', [GoogleBooksController::class, 'store'])->name('google-books.store');


    Route::patch('/requisicoes/{id}/devolver', [RequisicaoController::class, 'devolver'])->name('requisicoes.devolver');
    Route::get('/requisicoes/search', [RequisicaoController::class, 'search'])->name('requisicoes.search');


    Route::get('/livros/create', [LivroController::class, 'create']);
    Route::post('/livros', [LivroController::class, 'store']);
    Route::get('/livros/{id}/edit', [LivroController::class, 'edit'])->name('livros.edit');
    Route::patch('/livros/{id}', [LivroController::class, 'update']);
    Route::delete('/livros/{id}', [LivroController::class, 'destroy']);

    Route::get('/editoras/create', [EditorController::class, 'create']);
    Route::post('/editoras', [EditorController::class, 'store']);
    Route::get('/editoras/{id}/edit', [EditorController::class, 'edit']);
    Route::patch('/editoras/{id}', [EditorController::class, 'update']);
    Route::delete('/editoras/{id}', [EditorController::class, 'destroy']);

    Route::get('/autores/create', [AutorController::class, 'create']);
    Route::post('/autores', [AutorController::class, 'store']);
    Route::get('/autores/{id}/edit', [AutorController::class, 'edit']);
    Route::patch('/autores/{id}', [AutorController::class, 'update']);
    Route::delete('/autores/{id}', [AutorController::class, 'destroy']);

});












//     Route::controller(LivroController::class)->group(function() {
//         //Index
//         Route::get('/livros', 'index');
//         //Create
//         Route::get('/livros/create', 'create');
//         //Store
//          Route::post('/livros', 'store');
// //     //Edit
//     Route::get('/livros/{id}/edit', 'edit');
//     //Update
//     Route::patch('/livros/{id}', 'update');
//     //Destroy
//     Route::delete('/livros/{id}', 'destroy');
//     //Search
//     Route::get('/livros', 'search')->name('livros.search');
//     //Export
//     Route::get('/download','export');

// });


// Route::controller(EditorController::class)->group(function () {
//     //Index
//     Route::get('/editoras', 'index');
//     //Create
//     Route::get('/editoras/create', 'create');
//     //Store
//     Route::post('/editoras', 'store');
//     //Edit
//     Route::get('/editoras/{id}/edit', 'edit');
//     //Update
//     Route::patch('/editoras/{id}', 'update');
//     //Destroy
//     Route::delete('/editoras/{id}', 'destroy');
//     //Search
//     Route::get('/editoras', 'search')->name('editoras.search');

// });


// Route::controller(AutorController::class)->group(function () {
//     //Index
//     Route::get('/autores', 'index');
//     //Create
//     Route::get('/autores/create', 'create');
//     //Store
//     Route::post('/autores', 'store');
//     //Edit
//     Route::get('/autores/{id}/edit', 'edit');
//     //Update
//     Route::patch('/autores/{id}', 'update');
//     //Destroy
//     Route::delete('/autores/{id}', 'destroy');
//     //Search
//     Route::get('/autores', 'search')->name('autores.search');
// });

//test
Route::get('/admin-only', function () {
    return 'És admin!';
})->middleware('admin');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
