<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Livros') }}
        </h2>
    </x-slot>

    <x-slot:action>
        <x-button-crud href="/livros/create">Criar Livro</x-button-crud> 
    </x-slot:action>

    
    <h1 class="text-2xl font-semibold text-center mt-6">Lista de Livros</h1>
    <x-button-crud href="/livros/create">Exportar</x-button-crud> 

    <div class="w-full max-w-7xl mx-auto px-4 mt-6">
        <div class="overflow-x-auto border rounded bg-white">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">ISBN</th>
                        <th class="p-2 border text-left">Nome</th>
                        <th class="p-2 border text-left">Editora</th>
                        <th class="p-2 border text-left">Autor(es)</th>
                        <th class="p-2 border text-left">Bibliografia</th>
                        <th class="p-2 border text-center">Imagem</th>
                        <th class="p-2 border text-right">Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($livros as $livro)
                        @php
                            $isUrl = str_starts_with($livro->image, 'http');
                        @endphp
                       <tr>
                            <td class="p-2 border">{{ $livro->isbn }}</td>
                            <td class="p-2 border">{{ $livro->name }}</td>
                            <td class="p-2 border">
                                @foreach ($livro->autores as $autor)
                                <span class="block">{{ $autor->name }}</span>
                                @endforeach
                            </td>
                            <td class="p-2 border">
                                {{ $livro->editor?->name ?? 'Sem editora' }}
                            </td>
                            <td class="p-2 border">{{ $livro->bibliography }}</td>
                            <td class="p-2 border text-center">
                                <img src="{{ $isUrl ? $livro->image : asset('storage/' . $livro->image) }}" alt="{{ $livro->name }}"
                                    class="mx-auto rounded-full mt-2 object-cover shadow-md" style="max-width: 300px; max-height: 300px;" />
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