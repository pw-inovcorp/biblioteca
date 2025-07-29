<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    /** @use HasFactory<\Database\Factories\LivroFactory> */
    use HasFactory;

    protected $fillable = [
        'isbn',
        'name',
        'editor_id',
        'bibliography',
        'image',
        'price'
    ];

    public function editor()
    {
        return $this->belongsTo(Editor::class);
    }
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro');
    }

}
