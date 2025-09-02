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

    public function finalizar()
    {
        $user = auth()->user();

        $redirect = $this->validarCheckout();
        if ($redirect !== null) {
            return $redirect;
        }

        try {
            DB::beginTransaction();

            $items = $user->carrinhoItems()->with('livro')->get();
            $total = $user->calcTotalCarrinho();
            $morada = session('checkout_morada');

            $encomenda = Encomenda::create([
                'user_id' => $user->id,
                'numero_encomenda' => Encomenda::gerarNumeroEncomenda(),
                'status' => 'pendente',
                'total' => $total,
                'morada_entrega' => $morada,
            ]);

            foreach ($items as $item) {
                EncomendaItem::create([
                    'encomenda_id' => $encomenda->id,
                    'livro_id' => $item->livro_id,
                    'quantidade' => $item->quantidade,
                    'preco_unitario' => $item->livro->price,
                    'subtotal' => $item->calcSubTotal(),
                ]);

                \App\Models\SystemLog::criarLog(
                    'encomendas',
                    "Encomenda criada: {$encomenda->numero_encomenda} - Total: €{$total}",
                    $encomenda->id
                );
            }

            $user->carrinhoItems()->delete();

            session()->forget('checkout_morada');

            DB::commit();
            return redirect()->route('encomendas.show', $encomenda)
                ->with('success', 'Encomenda criada com sucesso! Número: ' . $encomenda->numero_encomenda);

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->route('checkout.confirmacao')
                ->with('error', 'Erro ao criar encomenda. Tente novamente.');
        }

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
