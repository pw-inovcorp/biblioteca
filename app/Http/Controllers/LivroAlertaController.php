<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LivroAlerta;

class LivroAlertaController extends Controller
{
    //
    public function store()
    {
       request()->validate(['livro_id' => 'required|exists:livros,id']);

        // Verificar se já tem alerta para este livro
        $existe = LivroAlerta::where('user_id', auth()->id())
            ->where('livro_id', request('livro_id'))
            ->exists();

        if ($existe) {
            return back()->with('error', 'Já tem um alerta para este livro');
        }

        LivroAlerta::create([
            'livro_id' => request('livro_id'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Alerta criado! Será notificado quando o livro ficar disponível.');
    }
}
