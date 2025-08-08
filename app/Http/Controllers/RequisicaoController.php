<?php

namespace App\Http\Controllers;

use App\Models\Requisicao;
use App\Models\Livro;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\NovaRequisicaoMail;
use App\Mail\NovaRequisicaoAdminMail;
use Illuminate\Support\Facades\Mail;

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
                ->paginate(10);
        } else {
            //Cidadao vê apenas as suas
            $requisicoes = Requisicao::with(['livro'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        //indicadores
        $estatisticas = [
            "ativas" => Requisicao::ativas()->count(),
            "ultimos_30_dias" => Requisicao::ultimos30Dias()->count(),
            "entregues_hoje" => Requisicao::entreguesHoje()->count()
        ];

        return view('/requisicoes/index', ['requisicoes' => $requisicoes, 'estatisticas' => $estatisticas]);
    }

    //Create
    public function create($livroId)
    {

        $livro = Livro::findOrFail($livroId);

        if($livro->estaDisponivel() === false) {
            return redirect()->back()->with('error', 'Este livro já está requisitado!');
        }

        if (auth()->user()->podeRequisitarMaisLivros() === false) {
            return redirect()->back()->with('error', 'Já tem 3 livros requisitados');
        }

        return view('/requisicoes/create', ['livro' => $livro]);
    }

    //Store
    public function store()
    {

        //Validação
        request()->validate([
            'livro_id' => ['required','exists:livros,id'],
            'foto_cidadao' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048']
        ]);

        $livro = Livro::findOrFail(request()->livro_id);

        if ($livro->estaDisponivel() === false) {
            return redirect('/livros/index')->with('error', 'Este livro já está requisitado!');
        }

        if (!auth()->user()->podeRequisitarMaisLivros()) {
            return redirect()->route('requisicoes.index')->with('error', 'Já tem 3 livros requisitados!');
        }

         // Upload da foto se fornecida
        $fotoPath = null;
        if (request()->hasFile('foto_cidadao')) {
            $fotoPath = request()->file('foto_cidadao')->store('fotos_requisicoes', 'public');
        }

        // Criar requisição
        $requisicao = Requisicao::create([
            'numero_requisicao' => Requisicao::generateNumeroRequisicao(),
            'user_id' => auth()->user()->id,
            'livro_id' => $livro->id,
            'data_requisicao' => Carbon::today(),
            'data_prevista_entrega' => Carbon::today()->addDays(5),
            'foto_cidadao' => $fotoPath,
            'status' => 'ativa'
        ]);

        // TODO: Enviar email para admin e cidadão
        // Enviar email para o cidadão
        Mail::to($requisicao->user->email)->send(new NovaRequisicaoMail($requisicao));

        // Enviar email para todos os admins
        $admins = User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })->get();


        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NovaRequisicaoAdminMail($requisicao));
        }

        //Direcionar
        return redirect()->route('requisicoes.index')
            ->with('success', 'Livro requisitado com sucesso! Devolução até: ' .
                   $requisicao->data_prevista_entrega->format('d/m/Y'));
    }

    //Devolver o livro (apenas admin)
    public function devolver($id)
    {
        $requisicao = Requisicao::findOrFail($id);

        if($requisicao->status !== "ativa") {
            return redirect()->back()->with('error', 'Esta requisição já foi devolvida');
        }

        $requisicao->status = "devolvida";
        $requisicao->data_real_entrega = Carbon::today();
        $requisicao->dias_decorridos = $requisicao->calcularDiasDecorridos();
        $requisicao->save();

        return redirect()->route('requisicoes.index')->with('success', 'Livro devolvido com sucesso!');

    }
    public function search() {
        $search = request()->query('search','');
        $requisicoes = Requisicao::with(['user', 'livro'])
            ->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhereHas('livro', fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->Paginate(10)
            ->withQueryString();

        //indicadores
        $estatisticas = [
            "ativas" => Requisicao::ativas()->count(),
            "ultimos_30_dias" => Requisicao::ultimos30Dias()->count(),
            "entregues_hoje" => Requisicao::entreguesHoje()->count()
        ];

        return view('requisicoes/index', compact('requisicoes', 'search', 'estatisticas'));
    }
}
