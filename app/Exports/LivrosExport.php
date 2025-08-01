<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LivrosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array {
        return [
            'Nome',
            'ISBN',
            'Preço',
            'Bibliografia',
            'Editor',
            'Autores'
        ];
    }

    public function collection()
    {
        return Livro::with(['autores', 'editor'])->get()->map(function ($livro) {
            $autores = $livro->autores->pluck('name')->join(', ');
            $editor  = $livro->editor->name ?? 'Sem editor';

            return [
                'Nome'         => $livro->name,
                'ISBN'         => $livro->isbn,
                'Preço'        => $livro->price,
                'Bibliografia' => $livro->bibliography,
                'Editor'       => $editor,
                'Autores'      => $autores,
            ];
        });
    }
}
