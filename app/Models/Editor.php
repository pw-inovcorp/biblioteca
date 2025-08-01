<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    /** @use HasFactory<\Database\Factories\EditorFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'logotipo'
    ];
    public function livros()
    {
        return $this->hasMany(Livro::class);
    }
}
