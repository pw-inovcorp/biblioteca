<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ('Google Books') }}
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


    {{-- Formulário de pesquisa --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Pesquisar Livros</h3>

        <form method="GET" action="{{ route('google-books.search') }}" class="flex gap-4">

            <input type="text"
                   name="query"
                   placeholder="Ex: Harry Potter, Stephen King, isbn:123456"
                   class="flex-1 border rounded px-3 py-2"
                   value="{{$query ?? ""}}"
                   required>
            <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                Pesquisar
            </button>
        </form>

        @error('query')
        <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if(isset($books) && count($books) > 0)
        <div class="space-y-4">
            @foreach($books as $book)
                <div class="bg-white p-4 rounded shadow flex gap-4">
                    {{-- Imagem do livro --}}
                    @if($book['thumbnail'])
                        <img src="{{ $book['thumbnail'] }}"
                             alt="{{ $book['title'] }}"
                             class="w-16 h-24 object-cover rounded">
                    @endif

                    {{-- Informações do livro --}}
                    <div class="flex-1">
                        <h4 class="font-bold text-lg">{{ $book['title'] }}</h4>

                        @if(!empty($book['authors']))
                            <p class="text-gray-600">
                                <strong>Autor(es):</strong> {{ implode(', ', $book['authors']) }}
                            </p>
                        @endif

                        @if($book['publisher'])
                            <p class="text-gray-600">
                                <strong>Editora:</strong> {{ $book['publisher'] }}
                            </p>
                        @endif

                        @if($book['isbn'])
                            <p class="text-gray-600">
                                <strong>ISBN:</strong> {{ $book['isbn'] }}
                            </p>
                        @endif

                        @if($book['description'])
                            <p class="text-gray-700 text-sm mt-2">
                                {{ Str::limit($book['description'], 150) }}
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center">
                        <form method="POST" action="{{ route('google-books.store') }}">
                            @csrf
                            <input type="hidden" name="google_id" value="{{ $book['google_id'] }}">
                            <input type="hidden" name="title" value="{{ $book['title'] }}">
                            <input type="hidden" name="authors" value="{{ json_encode($book['authors']) }}">
                            <input type="hidden" name="publisher" value="{{ $book['publisher'] }}">
                            <input type="hidden" name="description" value="{{ $book['description'] }}">
                            <input type="hidden" name="thumbnail" value="{{ $book['thumbnail'] }}">
                            <input type="hidden" name="isbn" value="{{ $book['isbn'] }}">

                            <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                    onclick="return confirm('Importar este livro para a biblioteca?')">
                                Importar
                            </button>
                        </form>
                    </div>

                    {{-- Botão (por agora só visual) --}}
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('google-books.show') }}">
                            @csrf
                            <input type="hidden" name="google_id" value="{{ $book['google_id'] }}">
                            <input type="hidden" name="title" value="{{ $book['title'] }}">
                            <input type="hidden" name="authors" value="{{ json_encode($book['authors']) }}">
                            <input type="hidden" name="publisher" value="{{ $book['publisher'] }}">
                            <input type="hidden" name="description" value="{{ $book['description'] }}">
                            <input type="hidden" name="thumbnail" value="{{ $book['thumbnail'] }}">
                            <input type="hidden" name="isbn" value="{{ $book['isbn'] }}">

                            <input type="hidden" name="original_query" value="{{ $query ?? '' }}">
                            <input type="hidden" name="original_page" value="{{ $page ?? 1 }}">

                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Ver Detalhes
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

{{--        Paginação--}}
        <div class="flex justify-center gap-4 mt-6 mb-6">
            @if($page > 1)
                <a href="{{ route('google-books.search', ['query' => $query, 'page' => $page - 1]) }}"
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    <- Anterior
                </a>
            @endif

            {{-- Paginação --}}
            @if(count($books) == $maxResults)
                <a href="{{ route('google-books.search', ['query' => $query, 'page' => $page + 1]) }}"
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Próximo ->
                </a>
            @endif
        </div>
    @endif


{{--    --}}{{-- Botão de teste --}}
{{--    <div class="bg-gray-50 p-6 rounded shadow">--}}
{{--        <h4 class="font-semibold mb-3">Teste da API</h4>--}}
{{--        <a href="{{ route('google-books.test') }}"--}}
{{--           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">--}}
{{--            Testar API--}}
{{--        </a>--}}
{{--    </div>--}}

        @if(isset($result))
            <div class="bg-green-400 p-4 rounded mb-6">
                <strong>Resultado:</strong> {!! $result !!}
            </div>
        @endif



</x-app-layout>
