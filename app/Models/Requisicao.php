<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

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

     protected $casts = [
        'data_requisicao' => 'date',
        'data_prevista_entrega' => 'date',
        'data_real_entrega' => 'date',
    ];

    //Relações
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livro(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }

    //Geracao automatico de numero de requisicao
    public static function generateNumeroRequisicao(): string
    {
        $ultimoId = self::max('id') ?? 0;
        $numero = $ultimoId + 1;
        return 'REQ-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Verificar se está atrasada
    public function isAtrasada(): bool
    {
        return $this->status === 'ativa' &&
               $this->data_prevista_entrega < Carbon::today();
    }

    // Calcula quantos dias passaram desde a requisição
    public function calcularDiasDecorridos(): int
    {
        if ($this->data_real_entrega) {
            return $this->data_requisicao->diffInDays($this->data_real_entrega);
        }
        return $this->data_requisicao->diffInDays(Carbon::today());
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('status', 'ativa');
    }

    public function scopeDoUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }


}
