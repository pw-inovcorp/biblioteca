<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encomenda;
use App\Models\EncomendaItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    //Morada de Entrega
    public function morada()
    {
        $user = auth()->user();

        if (!$user->hasItensNoCarrinho()) {
            return redirect()->route('carrinho.index')
                ->with('error', 'Seu carrinho está vazio!');
        }

        return view('/checkout/morada');
    }

    public function storeMorada()
    {
        request()->validate([
            'nome_completo' => 'required|string|max:50',
            'endereco' => 'required|string|max:100',
            'cidade' => 'required|string|max:50',
            'codigo_postal' => 'required|regex:/^[0-9]{4}-[0-9]{3}$/',
            'telefone' => 'required|regex:/^[0-9]{9}$/'
        ]);

        //dd(request()->all());

        session(['checkout_morada' => [
            'nome_completo' => request()->nome_completo,
            'endereco' => request()->endereco,
            'cidade' => request()->cidade,
            'codigo_postal' => request()->codigo_postal,
            'telefone' => request()->telefone,
        ]]);

        return redirect()->route('checkout.confirmacao');
    }

    public function confirmacao()
    {
        $user = auth()->user();

        $redirect = $this->validarCheckout();
        if ($redirect !== null) {
            return $redirect;
        }


        $items = $user->carrinhoItems()->with('livro')->get();
        $total = $user->calcTotalCarrinho();
        $morada = session('checkout_morada');

        return view('checkout/confirmacao', ['items' => $items, 'total' => $total, 'morada' => $morada]);
    }



    private function validarCheckout()
    {
        $user = auth()->user();

        if (!$user->hasItensNoCarrinho()) {
            return redirect()->route('carrinho.index')
                ->with('error', 'Seu carrinho está vazio!');
        }

        if (!session('checkout_morada')) {
            return redirect()->route('checkout.morada')
                ->with('error', 'Por favor, preencha a morada de entrega.');
        }

        return null;
    }


}
