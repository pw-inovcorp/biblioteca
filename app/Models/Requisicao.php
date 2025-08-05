<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisicao extends Model
{
    //
    use HasFactory;

    protected $table = 'requisicoes';

    protected $fillable = [
        'numero_requisicao',
        'user_id',
        'livro_id',
        'data_requisicao',
        'data_prevista_entrega',
        'data_real_entrega',
        'status',
        'dias_decorridos',
        'foto_cidadao',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
