<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Livros') }}
        </h2>
    </x-slot>
    
    <h1 class="text-2xl font-semibold text-center mt-6">Lista de Livros</h1>

    <div class="w-full max-w-7xl mx-auto px-4 mt-6">
        <div class="overflow-x-auto border rounded bg-white">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">ISBN</th>
                        <th class="p-2 border text-left">Nome</th>
                        <th class="p-2 border text-left">Editora</th>
                        <th class="p-2 border text-left">Bibliografia</th>
                        <th class="p-2 border text-center">Imagem</th>
                        <th class="p-2 border text-right">Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($livros as $livro)
                        <tr>
                            <td class="p-2 border">{{ $livro->isbn }}</td>
                            <td class="p-2 border">{{ $livro->name }}</td>
                            {{-- <!--<td class="p-2 border">{{ $livro->author->name }}</td>--> --}}
                            <td class="p-2 border">{{ $livro->editor->name }}</td>
                            <td class="p-2 border">{{ $livro->bibliography }}</td>
                            <td class="p-2 border text-center">
                                <img src="{{ $livro->image }}" alt="{{ $livro->name }}" class="w-12 h-12 object-cover rounded-full mx-auto">
                            </td>
                            <td class="p-2 border text-right">€ {{ $livro->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $livros->links() }}
        </div>
    </div>
</x-app-layout>