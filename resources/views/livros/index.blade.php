<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Livros') }}
        </h2>
    </x-slot>

    @if(auth()->check() && auth()->user()->isAdmin())
        <x-slot:action>
            <x-button-crud href="/livros/create">Criar Livro</x-button-crud>
        </x-slot:action>
    @endif

    <x-button-crud href="/download">Exportar</x-button-crud>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 mt-6">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif


    <form action="{{ route('livros.search') }}" method="GET">
        <div class="text-center">
            <input type="search" name="search" class="mr-sm-2" value="{{ $search ?? '' }}" placeholder="Nome">
            <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Pesquisar</button>
        </div>
    </form>


    <div class="w-full max-w-7xl mx-auto px-4 mt-6">
        <div class="overflow-x-auto border rounded bg-white">
            <table class="w-full border-collapse text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">ISBN</th>
                        <th class="p-2 border">Nome</th>
                        <th class="p-2 border">Autor(es)</th>
                        <th class="p-2 border">Editora</th>
                        {{-- <th class="p-2 border">Bibliografia</th> --}}
                        <th class="p-2 border">Preço</th>
                        <th class="p-2 border">Disponibilidade</th>
                        <th class="p-2 border">Imagem</th>
                            <th class="p-2 border">Ações</th>
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
                            @if($livro->autores->isNotEmpty())
                                {{ $livro->autores->pluck('name')->join(', ') }}
                            @else
                                <span class="italic text-gray-500">Sem autores</span>
                            @endif
                        </td>
                        <td class="p-2 border">
                            {{ $livro->editor?->name ?? 'Sem editora' }}
                        </td>
                        {{-- <td class="p-2 border">{{ $livro->bibliography }}</td> --}}
                        <td class="p-2 border text-center">{{ $livro->price }} €</td>
                        <td class="p-2 border text-center">
                            @if($livro->estaDisponivel())
                                <span class="text-green-600 font-semibold">Disponível</span>
                                    <br>
                                    <a href="{{ route('requisicoes.create', $livro->id) }}" class="text-sm underline">
                                        Requisitar
                                    </a>
                            @else
                                <span class="text-red-600 font-semibold">Requisitado</span>
                            @endif
                        </td>

                         <td class="p-2 border text-center">
                            <img src="{{ $isUrl ? $livro->image : asset('storage/' . $livro->image) }}" alt="{{ $livro->name }}"
                                class="mx-auto rounded-lg mt-2 object-cover shadow-md" style="max-width: 250px; max-height: 250px;" />
                        </td>


                            <td>
                                <div class="flex flex-col gap-2 items-center">
                                    <a href="{{ route('livros.show', $livro->id) }}"
                                       class="text-blue-600 hover:text-blue-800 underline text-sm">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </td>
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
