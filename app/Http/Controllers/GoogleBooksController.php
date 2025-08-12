<?php

namespace App\Http\Controllers;

use App\Services\GoogleBooksService;
use Illuminate\Http\Request;

class GoogleBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        return view('google-books/index');
    }

    public function test()
    {
        try {
            $service = new GoogleBooksService();

            $apiTest = $service->testAPI();

            return view('google-books/index', [
                'result' => "API: $apiTest"
            ]);

        } catch (\Exception $e) {
            return view('google-books/index', [
                'result' => 'ERRO: ' . $e->getMessage()
            ]);
        }
    }

    public function search()
    {
        request()->validate([
            'query' => 'required|string|min:2|max:50'
        ]);

        try {
            $service = new GoogleBooksService();
            $query = request('query');

            // Buscar livros da API
            $books = $service->searchBooks($query);

            if (empty($books)) {
                return view('google-books/index', [
                    'result' => 'ERRO: Nenhum resultado encontrado',
                    'books' => []
                ]);
            }

            //Exibir
            return view('google-books.index', [
                'result' => "Pesquisaste por: <strong>$query</strong> - Encontrados " . count($books) . " livros:",
                'books' => $books,
                'query' => $query
            ]);


        } catch (\Exception $e) {
            return view('google-books/index', [
                'result' => 'ERRO na pesquisa: ' . $e->getMessage(),
                'books' => []
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
