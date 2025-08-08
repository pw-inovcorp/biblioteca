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

    //Relações
    public function editor()
    {
        return $this->belongsTo(Editor::class);
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro');
    }

    public function requisicoes() {
        return $this->hasMany(Requisicao::class);
    }


    //Verificar se está disponivl
    public function estaDisponivel(): bool
    {
        return $this->requisicoes()->ativas()->exists() === false;
    }

    //Pegar no primeiro livro (se existir disponivel)
    public function requisicaoAtiva(): ?Requisicao
    {
        return $this->requisicoes()->exists()->first();
    }



}
