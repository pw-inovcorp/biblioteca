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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
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
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">ISBN</th>
                        <th class="p-2 border text-left">Nome</th>
                        <th class="p-2 border text-left">Autor(es)</th>
                        <th class="p-2 border text-left">Editora</th>
                        {{-- <th class="p-2 border text-left">Bibliografia</th> --}}
                        <th class="p-2 border text-right">Preço</th>
                        <th class="p-2 border text-left">Disponibilidade</th>
                        <th class="p-2 border text-center">Imagem</th>
                        @if(auth()->user()->isAdmin())
                            <th class="p-2 border text-center">Ações</th>
                        @endif
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
                        <td class="p-2 border text-right">€ {{ $livro->price }}</td>
                        <td class="p-2 border text-center">
                            @if($livro->estaDisponivel())
                                <span class="text-green-600 font-semibold">Disponível</span>
                                @if(auth()->user()->podeRequisitarMaisLivros())
                                    <br>
                                    <a href="{{ route('requisicoes.create', $livro->id) }}" class="text-blue-600 hover:text-blue-800 text-sm underline">
                                        Requisitar
                                    </a>
                                @endif
                            @else
                                <span class="text-red-600 font-semibold">Requisitado</span>
                            @endif
                        </td>
                         <td class="p-2 border text-center">
                            <img src="{{ $isUrl ? $livro->image : asset('storage/' . $livro->image) }}" alt="{{ $livro->name }}"
                                class="mx-auto rounded-full mt-2 object-cover shadow-md" style="max-width: 300px; max-height: 300px;" />
                        </td>
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <td> <a href="/livros/{{ $livro->id }}/edit" class="p-2 text-gray-400 font-bold underline" type="button">
                            Editar</a>
                        </td>
                        @endif

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
