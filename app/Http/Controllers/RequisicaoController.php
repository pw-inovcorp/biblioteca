<?php

namespace App\Http\Controllers;

use App\Models\Requisicao;
use App\Models\Livro;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class RequisicaoController extends Controller
{
    // Index
    public function Index() 
    {
        // dd(auth()->user());
        $user = auth()->user();

        if($user->isAdmin()) {
            //Admin vê todos
            $requisicoes = Requisicao::with(['user', 'livro'])
                ->orderBy('created_at','desc')
                ->paginate(6);
        } else {
            //Cidadao vê apenas as suas
            $requisicoes = Requisicao::with(['livro'])
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        }

        return view('/requisicoes/index', ['requisicoes' => $requisicoes]);

    }
}
