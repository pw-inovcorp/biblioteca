<x-app-layout>
    <x-slot:heading>
        Livro Page
    </x-slot:heading>
    <h1 class="text-2xl font-semibold text-center mt-6">Lista de Livros</h1>

    <div class="mt-6 px-4">
        <table class="w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">ISBN</th>
                    <th class="p-2 border">Nome</th>
                    <th class="p-2 border">Editora</th>
                    <th class="p-2 border">Bibliografia</th>
                    <th class="p-2 border">Imagem</th>
                    <th class="p-2 border">Preço</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($livros as $livro)
                    <tr>
                        <td class="p-2 border">{{ $livro->isbn }}</td>
                        <td class="p-2 border">{{ $livro->name }}</td>
                        <td class="p-2 border">{{ $livro->editor->name }}</td>
                        <td class="p-2 border">{{ $livro->bibliography }}</td>
                        <td class="p-2 border text-center">
                            <img src="{{ $livro->image }}" alt="{{ $livro->name }}" class="w-12 h-12 object-cover mx-auto rounded-full">
                        </td>
                        <td class="p-2 border text-right">€ {{ $livro->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>