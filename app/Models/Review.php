<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'user_id',
        'livro_id',
        'requisicao_id',
        'comment',
        'status',
        'justificacao_recusa'
    ];

    //Relações
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function requisicao()
    {
        return $this->belongsTo(Requisicao::class);
    }


    //Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeSuspensos($query)
    {
        return $query->where('status', 'suspenso');
    }
}
