<?php

namespace App\Services;

class GoogleBooksService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function test()
    {
        return "Google books test";
    }

    public function testAPI()
    {
        $apiKey = env('GOOGLE_BOOKS_API_KEY');

        if (empty($apiKey)) {
            return "ERRO: API Key não configurada";
        }

        try {
            $response = \Http::get('https://www.googleapis.com/books/v1/volumes', [
                'q' => 'Harry Poter',
                'maxResults' => 1,
                'key' => $apiKey
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
}
