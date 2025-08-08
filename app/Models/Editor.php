<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $logotipo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livro> $livros
 * @property-read int|null $livros_count
 * @method static \Database\Factories\EditorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereLogotipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Editor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
