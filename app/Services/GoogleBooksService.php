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

    public function searchBooks(string $query, int $maxResults = 6, int $startIndex = 0) : array
    {
//        Campos relevantes do googlebooks:
//        -industryIdentifiers['identifier']
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
                'startIndex' => $startIndex,
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

                    //Encontrar ISBN
                    $isbn = null;
                    if(isset($volumeInfo['industryIdentifiers'])) {
                        foreach ($volumeInfo['industryIdentifiers'] as $identifier) {
                            if (in_array($identifier['type'], ['ISBN_13', 'ISBN_10'] )) {
                                $isbn = $identifier['identifier'];
                                break;
                            }
                        }
                    }

                    $books[] = [
                        'google_id' => $book['id'] ?? null,
                        'title' => $volumeInfo['title'] ?? 'Titulo não disponível',
                        'authors' => $volumeInfo['authors'] ?? [],
                        'publisher' => $volumeInfo['publisher'] ?? null,
                        'description' => $volumeInfo['description'] ?? null,
                        'thumbnail' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                        'isbn' => $isbn
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
