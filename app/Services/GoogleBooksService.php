<?php

namespace App\Services;

class GoogleBooksService
{
    private string $baseUrl = 'https://www.googleapis.com/books/v1/volumes';
    private string $apiKey;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
        $this->apiKey = env('GOOGLE_BOOKS_API_KEY');
    }

    public function test()
    {
        return "Google books test";
    }

    public function testAPI()
    {

        if (empty($this->apiKey)) {
            return "ERRO: API Key não configurada";
        }

        try {
            $response = \Http::get($this->baseUrl, [
                'q' => 'Harry Poter',
                'maxResults' => 1,
                'key' => $this->apiKey,
            ]);

            if($response->successful()) {
                $data = $response->json();
                $firstBook = $data['items'][0]['volumeInfo'] ?? null;
                return $firstBook? $firstBook['title']: "Nenhum livro encontrado";
            }
            return "ERRO: " . $response->status();

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function searchBooks(string $query, int $maxResults = 6) : array
    {
//        Campos relevantes do googlebooks:
//        -title,
//        -authors,
//        -publisher,
//        -description,
//        -imagelinks['thumbnails']


        if(empty($this->apiKey)) {
            throw new \Exception('Google Books API Key não configurada');
        }

        try {
            $response = \Http::get($this->baseUrl, [
                'q' => $query,
                'maxResults' => $maxResults,
                'key' => $this->apiKey,
            ]);

            if($response->successful()) {
                $data = $response->json();

                if(!isset($data['items'])) {
                    return [];
                }

                //Formatar os resultados
                $books = [];

                foreach ($data['items'] as $book) {
                    $volumeInfo = $book['volumeInfo'] ?? [];

                    $books[] = [
                        'title' => $volumeInfo['title'] ?? 'Titulo não disponível',
                        'authors' => $volumeInfo['authors'] ?? [],
                        'publisher' => $volumeInfo['publisher'] ?? null,
                        'description' => $volumeInfo['description'] ?? null,
                        'thumbnail' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                    ];
                }
                return $books;
            }

            throw new \Exception('Erro na API: ' . $response->status());

        } catch (\Exception $e) {

            throw new \Exception('Erro na pesquisa' . $e->getMessage());
        }
    }
}
