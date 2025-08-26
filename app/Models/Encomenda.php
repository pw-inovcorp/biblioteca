<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    //
    protected $fillable = [
        'user_id',
        'numero_encomenda',
        'status',
        'total',
        'morada_entrega',
        'data_pagamento'
    ];

    protected $casts = [
        'morada_entrega' => 'array', // JSON automático
        'data_pagamento' => 'datetime'
    ];

    // Relações
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(EncomendaItem::class);
    }

    // Métodos
    public static function gerarNumeroEncomenda(): string
    {
        $ultimoId = self::query()->max('id') ?? 0;
        $numero = $ultimoId + 1;
        return 'ENC-' . str_pad($ultimoId + 1, 4, '0', STR_PAD_LEFT);
    }

    public function isPaga(): bool
    {
        return $this->status === 'paga';
    }

    public function isPendente(): bool
    {
        return $this->status === 'pendente';
    }
}
