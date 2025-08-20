<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LivroAlerta extends Model
{
    //
    protected $fillable = ['livro_id', 'user_id'];


    //relações
    public function livro() {
        return $this->belongsTo(Livro::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
