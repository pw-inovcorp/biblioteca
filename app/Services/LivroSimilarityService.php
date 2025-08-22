<?php

namespace App\Services;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class LivroSimilarityService
{
    public function getLivrosSimilares(Livro $livro, int $limit = 8): Collection
    {
        $keywords = $this->extrairKeyWords($livro->bibliography);

        if (count($keywords) < 1) {
            return new Collection();
        }

        // Buscar todos os outros livros
        $livros = Livro::where('id', '!=', $livro->id)
            ->with(['autores', 'editor'])
            ->get();

        // Mapear com score
        $livrosComScore = $livros->map(fn($book) => [
            'livro' => $book,
            'score' => count(array_intersect($keywords, $this->extrairKeyWords($book->bibliography)))
        ])
            ->where('score', '>', 0)
            ->sortByDesc('score')
            ->take($limit);

        return new Collection($livrosComScore->pluck('livro')->all());
    }


    public function extrairKeyWords(string $text): array
    {
        $text = mb_strtolower($text, 'UTF-8');

        //Se o carácter não for letra nem espaço, ele é substituído por espaço
        $text = preg_replace('/[^\p{L}\s]/u', ' ', $text);

        // Remover espaços múltiplos
        $text = preg_replace('/\s+/', ' ', trim($text));

        $words = explode(' ', $text);

        $stopWords = $this->getStopWords();

        $filteredWords = [];

        foreach ($words as $word) {
            $word = trim($word);

            if (strlen($word) >= 4 &&
                strlen($word) <= 20 &&
                !in_array($word, $stopWords) &&
                !is_numeric($word))
            {
                $filteredWords[] = $word;
            }
        }

        $uniqueWords = [];

        foreach ($filteredWords as $word) {
            if (!in_array($word, $uniqueWords)) {
                $uniqueWords[] = $word;
            }
        }

        return $uniqueWords;

    }
    public function getStopWords(): array
    {
        static $stopwords = null;

        if ($stopwords === null) {
            try {

                // Caminho absoluto para o ficheiro
                $path = storage_path('app/private/stop-words-portugese.txt');

                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    $lines = explode("\n", $content);

                    $stopwords = array_filter(
                        array_map(fn($s) => trim($s), $lines),
                        fn($word) => !empty($word)
                    );
                } else {
                    $stopwords = ['o', 'a', 'de', 'em', 'para', 'com', 'não', 'uma', 'os', 'no', 'se'];
                }
            } catch (\Exception $e) {
                $stopwords = ['o', 'a', 'de', 'em', 'para', 'com', 'não', 'uma', 'os', 'no', 'se'];
            }
        }

        return $stopwords;
    }
}
