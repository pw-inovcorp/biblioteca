<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LivroSimilarityService;

/**
 * @property int $id
 * @property string $isbn
 * @property string $name
 * @property int $editor_id
 * @property string $bibliography
 * @property string|null $image
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Autor> $autores
 * @property-read int|null $autores_count
 * @property-read \App\Models\Editor|null $editor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Requisicao> $requisicoes
 * @property-read int|null $requisicoes_count
 * @method static \Database\Factories\LivroFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereBibliography($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereEditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livro whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        'price',
        'google_books_id',
        'stock'
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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function carrinhoItems()
    {
        return $this->hasMany(CarrinhoItem::class);
    }

    public function alertas()
    {
        return $this->hasMany(LivroAlerta::class);
    }


    public function getLivrosSimilares(int $limit = 8): Collection
    {
        $similarityService = new LivroSimilarityService();
        return $similarityService->getLivrosSimilares($this, $limit);
    }



    //Scopes
    public function estaDisponivel(): bool
    {
        return $this->requisicoes()->ativas()->exists() === false;
    }

    public function requisicaoAtiva(): ?Requisicao
    {
        return $this->requisicoes()->ativas()->first();
    }

    //Métodos para carrinho
    public function hasStock(int $quantidade = 1): bool
    {
        return $this->stock >= $quantidade;
    }

    public function canAdicionarAoCarrinho(int $quantidade = 1): bool
    {
        return $this->hasStock($quantidade);
    }



}
