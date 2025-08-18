<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Livro') }}
        </h2>
    </x-slot>

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

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded shadow p-6">
            <div class="md:flex gap-6">
                {{-- Imagem do livro --}}
                <div class="md:w-1/3 mb-4 md:mb-0">
                    @if($livro->image)
                        @php
                            $isUrl = str_starts_with($livro->image, 'http');
                        @endphp
                        <img src="{{ $isUrl ? $livro->image : asset('storage/' . $livro->image) }}"
                             alt="{{ $livro->name }}"
                             class="w-full rounded shadow-lg">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center">
                            <span class="text-gray-500">Sem imagem</span>
                        </div>
                    @endif
                </div>

                {{-- Informações do livro --}}
                <div class="md:w-2/3">
                    <h1 class="text-3xl font-bold mb-4">{{ $livro->name }}</h1>

                    <div class="space-y-3">
                        <div>
                            <strong class="text-gray-700">ISBN:</strong>
                            <span class="text-gray-900">{{ $livro->isbn }}</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">Autor(es):</strong>
                            <span class="text-gray-900">
                                @if($livro->autores->isNotEmpty())
                                    {{ $livro->autores->pluck('name')->join(', ') }}
                                @else
                                    <span class="italic text-gray-500">Sem autores</span>
                                @endif
                            </span>
                        </div>

                        <div>
                            <strong class="text-gray-700">Editora:</strong>
                            <span class="text-gray-900">{{ $livro->editor?->name ?? 'Sem editora' }}</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">Preço:</strong>
                            <span class="text-gray-900">{{ $livro->price }} €</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">Disponibilidade:</strong>
                            @if($livro->estaDisponivel())
                                <span class="text-green-600 font-semibold">Disponível</span>
                            @else
                                <span class="text-red-600 font-semibold">Requisitado</span>
                            @endif
                        </div>

                        @if(!empty($livro->google_books_id))
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Importado do Google Books
                                </span>
                            </div>
                        @endif

                        <div class="mt-4">
                            <strong class="text-gray-700">Descrição:</strong>
                            <p class="mt-2 text-gray-900 leading-relaxed">{{ $livro->bibliography }}</p>
                        </div>

                    </div>

                    {{--Botões de ação--}}
                    <div class="flex gap-4 mt-6">
                        <button onclick="history.back()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Voltar
                        </button>

                        @if(auth()->check())
                            @if($podeRequisitar)
                                <a href="{{ route('requisicoes.create', $livro->id) }}"
                                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Requisitar Livro
                                </a>
                            @elseif(!$livro->estaDisponivel())
                                <span class="bg-red-500 text-white px-4 py-2 rounded opacity-75 cursor-not-allowed">
                                    Livro Indisponível
                                </span>
                            @elseif(!auth()->user()->podeRequisitarMaisLivros())
                                <span class="bg-yellow-500 text-white px-4 py-2 rounded opacity-75 cursor-not-allowed"
                                      title="Já tem 3 livros requisitados">
                                    Limite Atingido
                                </span>
                            @endif

                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('livros.edit', $livro->id) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Editar Livro
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Secção de Reviews (placeholder para o futuro) --}}
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Reviews dos Leitores</h3>
                <div class="bg-gray-50 p-4 rounded-lg text-center">
                    <p class="text-gray-600">Sistema de reviews será implementado em breve.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
