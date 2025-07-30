<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Autor;
use App\Models\Livro;

class AutorLivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $autores = Autor::factory(10)->create();

        Livro::factory(20)->create()->each(function ($livro) use ($autores) {
            $livro->autores()->attach(
                $autores->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
