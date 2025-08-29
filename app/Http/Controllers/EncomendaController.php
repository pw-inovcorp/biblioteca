<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use Illuminate\Http\Request;

class EncomendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();

        if ($user->isAdmin()) {
            $encomendas = Encomenda::with(['user', 'items.livro'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {

            $encomendas = auth()->user()->encomendas()
                ->with('items.livro')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('encomendas/index', ['encomendas' => $encomendas]);
    }

    public function search()
    {
        $search = request()->query('search', '');

        $encomendas = Encomenda::with('user')
            ->where('numero_encomenda', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('encomendas.index', ['encomendas' => $encomendas]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $encomenda = Encomenda::with(['items.livro', 'user'])->findOrFail($id);

        if (!auth()->user()->isAdmin() && $encomenda->user_id !== auth()->id()) {
            abort(403, 'Não tem permissão para ver esta encomenda.');
        }

        return view('encomendas.show', ['encomenda' => $encomenda]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Encomenda $encomenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Encomenda $encomenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Encomenda $encomenda)
    {
        //
    }
}
