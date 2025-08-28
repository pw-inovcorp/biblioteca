<?php

namespace App\Http\Controllers;

use App\Services\GoogleBooksService;
use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editor;


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

//    public function test()
//    {
//        try {
//            $service = new GoogleBooksService();
//
//            $apiTest = $service->testAPI();
//
//            return view('google-books/index', [
//                'result' => "API: $apiTest"
//            ]);
//
//        } catch (\Exception $e) {
//            return view('google-books/index', [
//                'result' => 'ERRO: ' . $e->getMessage()
//            ]);
//        }
//    }

    public function search()
    {
        request()->validate([
            'query' => 'required|string|min:2|max:50'
        ]);

        try {
            $service = new GoogleBooksService();
            $query = request('query');

            // Página atual (se não vier, é 1)
            $page = (int) request('page', 1);
            $maxResults = 6;
            $startIndex = ($page - 1) * $maxResults;

            // Buscar livros da API com paginação
            $books = $service->searchBooks($query, $maxResults, $startIndex);


            if (empty($books)) {
                return view('google-books/index', [
                    'result' => 'ERRO: Nenhum resultado encontrado',
                    'books' => [],
                    'query' => $query,
                    'page' => 1,
                    'maxResults' => $maxResults
                ]);
            }

            //Exibir
            return view('google-books/index', [
                'result' => "Pesquisaste por: <strong>$query</strong> - Mostrando " . count($books) . " resultados por página.",
                'books' => $books,
                'query' => $query,
                'page' => $page,
                'maxResults' => $maxResults
            ]);


        } catch (\Exception $e) {
            return view('google-books/index', [
                'result' => 'ERRO na pesquisa: ' . $e->getMessage(),
                'books' => [],
                'query' => request('query', ''),
                'page' => 1,
                'maxResults' => $maxResults
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        //livros antigos podem nao ter campos em editor, bibliografia e isbn
        request()->validate([
            'google_id' => 'required|string',
            'title' => 'required|string',
            'authors' => 'required|string', //JSON string: '["Autor1", "Autor2"]'
            'publisher' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'isbn' => 'nullable|string'
        ]);

        try {
            //Verificar duplicacao
            if(request('isbn')) {
                $exists = Livro::where('isbn', request('isbn'))->first();
                if($exists) {
                    return back()->with('error','Livro já existe na biblioteca!');
                }
            }

            // Criar/encontrar editora
            $editor = null;
            if (request('publisher')) {
                $editor = Editor::firstOrCreate([
                    'name' => request('publisher')
                ]);
            } else {
                $editor = Editor::firstOrCreate([
                    'name' => 'Editora Desconhecida'
                ]);
            }

            $livro = Livro::create([
                'google_books_id' => request('google_id'),
                'name' => request('title'),
                'isbn' => request('isbn') ?? 'google-' . request('google_id'), // ISBN falso se null
                'editor_id' => $editor->id,
                'bibliography' => request('description') ?? 'Descrição não disponível.',
                'image' => request('thumbnail'),
                'price' => 0,
                'stock' => 0
            ]);

            //Criar/Associar autores
            $autores = json_decode(request('authors'), true); // Converter Json para array
            foreach ($autores as $autorNome) {
                $autor = Autor::firstOrCreate([
                    'name' => trim($autorNome)
                ]);
                //Ligar o livro com autores na tabela pivot
                $livro->autores()->attach($autor->id);
            }

            return redirect()->route('google-books.search', [
                'query' => request('original_query'),
                'page' => request('original_page')
            ])->with('success', "Livro '{$livro->name}' importado com sucesso!");

        }catch (\Exception $e) {
            return redirect()->route('google-books.search', [
                'query' => request('original_query'),
                'page' => request('original_page')
            ])->with('error', 'Erro ao importar: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $book = [
            'google_id' => request('google_id'),
            'title' => request('title'),
            'authors' => json_decode(request('authors'), true),
            'publisher' => request('publisher'),
            'description' => request('description'),
            'thumbnail' => request('thumbnail'),
            'isbn' => request('isbn')
        ];

        return view('google-books/show', ['book' => $book]);

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
