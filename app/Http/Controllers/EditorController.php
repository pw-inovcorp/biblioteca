<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editor;

class EditorController extends Controller
{
    //
    public function index()
    {
        $editoras = \App\Models\Editor::paginate(6);
        return view('editoras/index', ['editoras' => $editoras]);
    }

    public function create() {
        return view('editoras/create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255|min:3',
            'logotipo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the logo upload
        if (request()->hasFile('logotipo')) {
            $data['logotipo'] = request()->file('logotipo')->store('editoras', 'public');
        }

        \App\Models\Editor::create($data);

        return redirect('/editoras');
    }

    public function edit($id)
    {
        $editora = \App\Models\Editor::findOrFail($id);

        return view('editoras/edit', ['editora' => $editora]);
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255|min:3',
            'logotipo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Serch
        $editora = \App\Models\Editor::findOrFail($id);

        // Handle the logo upload
        if (request()->hasFile('logotipo')) {
            $data['logotipo'] = request()->file('logotipo')->store('editoras', 'public');
        } else {
            // Retain the existing logo if no new file is uploaded
            unset($data['logotipo']);
        }

        // Update
        $editora->update($data);

        // Redirect
        return redirect('/editoras');
    }

    public function destroy($id)
    {

        // Find the editor by ID
        $editora = \App\Models\Editor::findOrFail($id);

        // Check if the editor has associated books

        // Delete the editor
        $editora->delete();

        // Redirect back to the editoras
        return redirect('/editoras');
    }

    public function search() {
        $search = request()->query('search','');
        $editoras = Editor::where('name', 'LIKE', "%{$search}%")
        ->orderBy('name')
        ->paginate(6)
        ->withQueryString();

        return view('editoras/index', compact('editoras', 'search'));
    }
}
