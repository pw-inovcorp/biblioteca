<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Encomenda;

class StripeController extends Controller
{
    //
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function checkout(Encomenda $encomenda)
    {
        if (!auth()->user()->isAdmin() && $encomenda->user_id !== auth()->id()) {
            abort(403, 'Não tem permissão para pagar esta encomenda.');
        }

        if ($encomenda->status !== 'pendente') {
            return redirect()->route('encomendas.show', $encomenda)
                ->with('error', 'Esta encomenda já foi paga ou cancelada.');
        }

        try {

            // Verificar stock antes de criar checkout
            foreach ($encomenda->items as $item) {
                if ($item->livro->stock < $item->quantidade) {
                    return redirect()->route('encomendas.show', $encomenda)
                        ->with('error', "Stock insuficiente para o livro: {$item->livro->name}");
                }
            }

            $lineItems = [];

            foreach($encomenda->items as $item){
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $item->livro->name,
                            'description' => 'ISBN: ' . $item->livro->isbn,
                        ],
                        'unit_amount' => $item->preco_unitario * 100
                    ],
                    'quantity' => $item->quantidade
                ];
            }

            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('stripe.success', $encomenda),
                'cancel_url' => route('stripe.cancel', $encomenda),
                'customer_email' => $encomenda->user->email
            ]);

            $encomenda->update([
                'stripe_session_id' => $checkoutSession->id
            ]);

            return redirect($checkoutSession->url);

        } catch(\Exception $e) {
            return redirect()->route('encomendas.show', $encomenda)
                ->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    public function success(Encomenda $encomenda)
    {
        try {
            $session = Session::retrieve($encomenda->stripe_session_id);


            if ($session->payment_status === 'paid') {

                $encomenda->update([
                    'status' => 'paga',
                    'data_pagamento' => now(),
                    'stripe_payment_intent_id' => $session->payment_intent,
                ]);

                // Decrementar stock dos livros
                foreach ($encomenda->items as $item) {
                    $livro = $item->livro;

                    // Verificar se tem stock suficiente
                    if ($livro->stock >= $item->quantidade) {
                        $livro->decrement('stock', $item->quantidade);
                    } else {
                        // Enviar email aos admins a avisar que nao tem stock suficiente

                    }
                }

                // Enviar email

                return redirect()->route('encomendas.show', $encomenda)
                    ->with('success', 'Pagamento realizado com sucesso! Encomenda: ' . $encomenda->numero_encomenda);
            }

            return redirect()->route('encomendas.show', $encomenda)
                ->with('error', 'Pagamento não foi confirmado.');

        } catch (\Exception $e) {

            return redirect()->route('encomendas.show', $encomenda)
                ->with('error', 'Erro ao verificar pagamento: ' . $e->getMessage());
        }
    }

    public function cancel(Encomenda $encomenda)
    {
        return redirect()->route('encomendas.show', $encomenda)
            ->with('error', 'Pagamento cancelado.');
    }
}
