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

                        <div>
                            <strong class="text-gray-700">Stock:</strong>
                            <span class="text-gray-900">{{ $livro->stock }} </span>
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


                                @php
                                    $temAlerta = auth()->check() && auth()->user()->alertas()->where('livro_id', $livro->id)->exists();
                                @endphp

                                @if(!$temAlerta)
                                    <form method="POST" action="{{ route('alertas.store') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                            Receber Alerta
                                        </button>
                                    </form>
                                @else
                                    <span class="bg-yellow-500 text-white px-4 py-2 rounded">Alerta Ativo</span>
                                @endif

                            @elseif(!auth()->user()->podeRequisitarMaisLivros())
                                <span class="bg-yellow-500 text-white px-4 py-2 rounded opacity-75 cursor-not-allowed"
                                      title="Já tem 3 livros requisitados">
                                    Limite Atingido
                                </span>
                            @endif

                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('livros.edit', $livro->id) }}"
                                   class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                                    Editar Livro
                                </a>
                            @endif
                        @endif
                    </div>
                    <div class="mt-6">
                        {{-- Botão Adicionar ao Carrinho --}}
                        @if($livro->canAdicionarAoCarrinho())
                            <form method="POST" action="{{ route('carrinho.store') }}" class="inline">
                                @csrf
                                <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                                <input type="number" name="quantidade" value="1" min="1" max="{{ $livro->stock }}"
                                       class="border rounded px-2 py-1 w-16 text-center">
                                <button type="submit"
                                        class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                                    Adicionar ao Carrinho
                                </button>
                            </form>
                        @elseif($livro->stock <= 0)
                            <span class="bg-gray-500 text-white px-4 py-2 rounded opacity-75 cursor-not-allowed">
                                        Sem Stock
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            {{--Livros Relacionados--}}
            @php
                $livrosSimilares = $livro->getLivrosSimilares(4);
            @endphp

            @if($livrosSimilares->count() > 0)
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-xl font-semibold mb-4">Livros Relacionados</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($livrosSimilares as $livroSimilar)
                            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md">
                                {{-- Imagem do livro --}}
                                <div class="mb-3">
                                    @if($livroSimilar->image)
                                        @php
                                            $isUrl = str_starts_with($livroSimilar->image, 'http');
                                        @endphp
                                        <img src="{{ $isUrl ? $livroSimilar->image : asset('storage/' . $livroSimilar->image) }}"
                                             alt="{{ $livroSimilar->name }}"
                                             class="w-full h-48 object-cover rounded shadow-sm">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 rounded flex items-center">
                                            <span class="text-gray-400 text-xs">Sem imagem</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Informações do livro --}}
                                <div>
                                    <h4 class="font-semibold text-sm mb-2">
                                        {{ Str::limit($livroSimilar->name, 20) }}
                                    </h4>

                                    <p class="text-xs text-gray-600 mb-2">
                                        @if($livroSimilar->autores->isNotEmpty())
                                            {{ Str::limit($livroSimilar->autores->pluck('name')->join(', '), 30) }}
                                        @else
                                            Sem autor
                                        @endif
                                    </p>

                                    <p class="text-xs text-gray-500 mb-3">
                                        {{ Str::limit($livroSimilar->bibliography, 100) }}
                                    </p>

                                    <div class="mb-3">
                                        @if($livroSimilar->estaDisponivel())
                                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                                Disponível
                                            </span>
                                        @else
                                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                                                Requisitado
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Botão para ver detalhes --}}
                                    <a href="{{ route('livros.show', $livroSimilar->id) }}"
                                       class="inline-block w-full text-center bg-blue-600 text-white text-xs px-3 py-2 rounded hover:bg-blue-700">
                                        Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Nota explicativa --}}
                    <div class="mt-4 bg-blue-50 border-blue-200 rounded p-3">
                        <p class="text-xs text-blue-800">
                            <strong>Como funciona:</strong> Os livros relacionados são sugeridos automaticamente com base na análise
                            das descrições, encontrando livros com temáticas e palavras-chave similares.
                        </p>
                    </div>
                </div>
            @else
                {{-- Mensagem quando não há livros similares --}}
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-xl font-semibold mb-4">Livros Relacionados</h3>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600">
                            Ainda não encontramos livros relacionados com este.
                            Explore o nosso <a href="{{ route('livros.index') }}" class="text-blue-600 underline">catálogo completo</a>!
                        </p>
                    </div>
                </div>
            @endif

            {{-- Secção de Reviews--}}
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Reviews dos Leitores</h3>

                @php
                    $reviewsAtivos = $livro->reviews()->where('status', 'ativo')->with('user')->latest()->get();
                @endphp

                @if($reviewsAtivos->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviewsAtivos as $review)
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <div class="mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $review->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <p class="text-gray-600">Ainda não há reviews para este livro.</p>
                        <p class="text-sm text-gray-500 mt-1">Seja o primeiro a fazer review depois de requisitar!</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
