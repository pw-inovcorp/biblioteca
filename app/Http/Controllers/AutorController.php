<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    //
    public function index()
    {
        $autores = Autor::orderBy('created_at', 'desc')->simplePaginate(6);
        return view('autores/index', ['autores' => $autores]);
    }

    public function create() {
        return view('autores/create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255|min:3',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the photo upload
        if (request()->hasFile('foto')) {
            $data['foto'] = request()->file('foto')->store('autores', 'public');
        }

        \App\Models\Autor::create($data);

        \App\Models\SystemLog::criarLog(
            'autores',
            "Autor criado: {$data['name']}",
            $data->id
        );

        return redirect('/autores');
    }

    public function edit($id)
    {
        $autor = \App\Models\Autor::findOrFail($id);
        return view('autores/edit', ['autor' => $autor]);
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255|min:3',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Search
        $autor = \App\Models\Autor::findOrFail($id);

        // Handle the photo upload
        if (request()->hasFile('foto')) {
            $data['foto'] = request()->file('foto')->store('autores', 'public');
        } else {
            // Retain the existing photo if no new file is uploaded
            unset($data['foto']);
        }

        $autor->update($data);

        \App\Models\SystemLog::criarLog(
            'autores',
            "Autor atualizado: {$autor->name}",
            $autor->id
        );

        return redirect('/autores');
    }

    public function destroy($id)
    {
        $autor = \App\Models\Autor::findOrFail($id);
        $autor->delete();

        \App\Models\SystemLog::criarLog(
            'autores',
            "Autor eliminado: {$autor->name}",
            $id
        );

        return redirect('/autores');
    }

    //Search
    public function search() {
        $search = request()->query('search','');
        $autores = Autor::where('name', 'LIKE', "%{$search}%")
        ->orderBy('name')
        ->simplePaginate(6)
        ->withQueryString();

        return view('autores/index', compact('autores', 'search'));
    }
}
