<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    //
    protected $fillable = [
        'data_hora',
        'user_id',
        'modulo',
        'objeto_id',
        'alteracao',
        'ip_address',
        'browser'
    ];

    protected $casts = [
        'data_hora' => 'datetime'
    ];

    // Relação
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function criarLog(string $modulo, string $alteracao, $objetoId = null)
    {
        return self::create([
            'data_hora' => now(),
            'user_id' => auth()->id(),
            'modulo' => $modulo,
            'objeto_id' => $objetoId,
            'alteracao' => $alteracao,
            'ip_address' => request()->ip(),
            'browser' => request()->header('User-Agent')
        ]);
    }
}
