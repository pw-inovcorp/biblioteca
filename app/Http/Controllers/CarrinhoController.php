<?php

namespace App\Http\Controllers;

use App\Models\CarrinhoItem;
use Illuminate\Http\Request;
use App\Models\Livro;

class CarrinhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = auth()->user()->carrinhoItems()->with('livro')->get();
        $total = auth()->user()->calcTotalCarrinho();

        return view('carrinho/index', ['items' => $items, 'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
        request()->validate([
            'livro_id' => 'required|exists:livros,id',
            'quantidade' => 'integer|min:1|max:10'
        ]);

        $livro = Livro::findOrFail(request()->livro_id);
        $quantidade = request()->quantidade ?? 1;

        // Verificar stock
        if (!$livro->canAdicionarAoCarrinho($quantidade)) {
            return back()->with('error', 'Stock insuficiente!');
        }

        // Verificar se já existe no carrinho
        $itemExistente = CarrinhoItem::where('user_id', auth()->id())
            ->where('livro_id', $livro->id)
            ->first();

        if ($itemExistente) {
            $novaQuantidade = $itemExistente->quantidade + $quantidade;

            if (!$livro->canAdicionarAoCarrinho($novaQuantidade)) {
                return back()->with('error', 'Stock insuficiente para essa quantidade!');
            }

            $itemExistente->update(['quantidade' => $novaQuantidade]);
        } else {
            CarrinhoItem::create([
                'user_id' => auth()->id(),
                'livro_id' => $livro->id,
                'quantidade' => $quantidade
            ]);

            \App\Models\SystemLog::criarLog(
                'carrinho',
                "Livro adicionado ao carrinho: '{$livro->name}' (Qtd: {$quantidade})",
                $livro->id
            );
        }

        return back()->with('success', 'Livro adicionado ao carrinho!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarrinhoItem $carrinhoItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarrinhoItem $carrinhoItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarrinhoItem $carrinhoItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $item = CarrinhoItem::where('user_id', auth()->id())
            ->findOrFail($id);

        $item->delete();

        \App\Models\SystemLog::criarLog(
            'carrinho',
            "Livro removido do carrinho: '{$item->livro->name}'",
            $item->livro_id
        );

        return back()->with('success', 'Item removido do carrinho!');
    }
}
