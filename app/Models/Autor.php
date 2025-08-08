<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livro> $livros
 * @property-read int|null $livros_count
 * @method static \Database\Factories\AutorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Autor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Autor extends Model
{
    /** @use HasFactory<\Database\Factories\AutorFactory> */
    use HasFactory;
    protected $table = 'autores';
    protected $fillable = [
        'name',
        'foto'
    ];
    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}
