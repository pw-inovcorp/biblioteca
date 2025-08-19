<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Models\Requisicao;

class ReviewController extends Controller
{
    //
    public function index() {

        if(!auth()->user()->isAdmin()) {
            abort(403);
        }

        $reviews = Review::with('requisicao', 'livro', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews/index', ['reviews' => $reviews]);
    }

    public function show($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $review = Review::with(['user', 'livro', 'requisicao'])
            ->findOrFail($id);

        return view('reviews/show', ['review' => $review]);
    }

    public function aprovar($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $review = Review::findOrFail($id);
        $review->update([
            'status' => 'ativo',
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review aprovado com sucesso!');
    }

    public function recusar($id)
    {

        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        request()->validate([
            'justificacao_recusa' => 'required|string|max:200|min:5'
        ]);

        $review = Review::findOrFail($id);
        $review->update([
            'status' => 'recusado',
            'justificacao_recusa' => request()->justificacao_recusa
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review recusado com justificação.');
    }

    public function create($requisicaoId)
    {
        $requisicao = Requisicao::with(['livro', 'user'])
            ->where('id', $requisicaoId)
            ->where('user_id', auth()->id())
            ->where('status', 'devolvida')
            ->firstOrFail();

        // Verificar se já fez review desta requisição
        if ($requisicao->temReview()) {
            return redirect()->route('requisicoes.index')
                ->with('error', 'Já fez review desta requisição!');
        }

        return view('reviews/create', ['requisicao' => $requisicao]);
    }

    public function store() {
        request()->validate([
            'requisicao_id' => 'required',
            'comment' => 'required|string|max:1000|min:10'
        ]);

        $requisicao = Requisicao::with('livro')
            ->where('id', request()->requisicao_id)
            ->where('user_id', auth()->id())
            ->where('status', 'devolvida')
            ->firstOrFail();


        if ($requisicao->temReview()) {
            return redirect()->route('requisicoes.index')
                ->with('error', 'Já fez review desta requisição!');
        }

        // Criar review com status 'suspenso'
        Review::create([
            'user_id' => auth()->id(),
            'livro_id' => $requisicao->livro_id,
            'requisicao_id' => $requisicao->id,
            'comment' => request()->comment,
            'status' => 'suspenso'
        ]);

        return redirect()->route('requisicoes.index')
            ->with('success', 'Review enviado! Será analisado pelos administradores.');
    }

}
