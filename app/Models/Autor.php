<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    /** @use HasFactory<\Database\Factories\AutorFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'foto'
    ];
    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}
