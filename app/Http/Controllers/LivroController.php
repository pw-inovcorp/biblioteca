<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use App\Models\Livro;
use Illuminate\Validation\Rule;
use App\Exports\LivrosExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class LivroController extends Controller
{
    //
    public function index()
    {
        $livros = Livro::with('editor', 'autores')->simplePaginate(6);
        return view('livros.index', ['livros' => $livros]);
    }

    public function create()
    {
        $editoras = \App\Models\Editor::orderBy('name')->get();
        $autores = \App\Models\Autor::orderBy('name')->get();
        return view('livros/create', ['editoras' => $editoras, 'autores' => $autores]);
    }

    public function store() {
        $data = request()->validate([
            'isbn' => 'required|string|max:255|unique:livros,isbn',
            'name' => 'required|string|max:255|min:3',
            'editor_id' => 'required|exists:editors,id',
            'autores' => 'required|array',
            'autores.*' => 'exists:autores,id',
            'bibliography' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0'
        ]);

        if (request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('livros', 'public');
        }

        // Guarda o livro
        $livro = Livro::create($data);

        // Associa autores (many-to-many)
        $livro->autores()->attach($data['autores']);

        return redirect('/livros');
    }

    public function edit($id) {
        $livro = Livro::with(['editor', 'autores'])->findOrFail($id);
        return view('livros.edit', [
            'livro' => $livro,
            'editoras' => \App\Models\Editor::orderBy('name')->get(),
            'autores' => \App\Models\Autor::orderBy('name')->get()
        ]);
    }

    public function update($id) {

        $livro = Livro::findOrFail($id);

        $data = request()->validate([
           'isbn' => 'required|string|max:255', Rule::unique('livros', 'isbn')->ignore($livro->id),
            'name' => 'required|string|max:255|min:3',
            'editor_id' => 'required|exists:editors,id',
            'autores' => 'required|array',
            'autores.*' => 'exists:autores,id',
            'bibliography' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0'
        ]);

        if(request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('livros', 'public');
        } else {
            unset($data['image']);
        }


        // Associa autores (many-to-many)
        $livro->autores()->sync($data['autores']);
        $livro->update($data);

        return redirect('/livros');
    }

    public function destroy($id) {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return redirect('/livros');
    }

    public function search() {
        $search = request()->query('search','');
        $livros = Livro::where('name', 'LIKE', "%{$search}%")
        ->orderBy('name')
        ->simplePaginate(6)
        ->withQueryString();
        
        return view('livros/index', compact('livros', 'search'));
    }

    public function export() {
        return Excel::download(new LivrosExport, 'livros.xlsx', ExcelExcel::XLSX);
    }
}
