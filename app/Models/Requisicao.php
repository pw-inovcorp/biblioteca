<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $numero_requisicao
 * @property int $user_id
 * @property int $livro_id
 * @property \Illuminate\Support\Carbon $data_requisicao
 * @property \Illuminate\Support\Carbon $data_prevista_entrega
 * @property \Illuminate\Support\Carbon|null $data_real_entrega
 * @property string $status
 * @property int|null $dias_decorridos
 * @property string|null $foto_cidadao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Livro|null $livro
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao ativas()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao doUsuario($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao entreguesHoje()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao ultimos30Dias()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDataPrevistaEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDataRealEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDataRequisicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereDiasDecorridos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereFotoCidadao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereLivroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereNumeroRequisicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Requisicao whereUserId($value)
 * @mixin \Eloquent
 */
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

    public function review()
    {
        return $this->hasOne(Review::class);
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

    // Verificar se esta requisição já tem review
    public function temReview(): bool
    {
        return $this->review()->exists();
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

    public function scopeUltimos30Dias($query)
    {
        return $query->where('data_requisicao', '>=', Carbon::today()->subDays(30));
    }

    public function scopeEntreguesHoje($query)
    {
        return $query->whereDate('data_real_entrega', '=', Carbon::today());
    }


}
