<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Livro') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded shadow p-6">
            <div class="md:flex gap-6">
{{--                 Imagem --}}
                <div class="md:w-1/3 mb-4 md:mb-0">
                    @if($book['thumbnail'])
                        <img src="{{ $book['thumbnail'] }}" alt="{{ $book['title'] }}" class="w-full rounded">
                    @endif
                </div>

{{--                 Informações --}}
                <div class="md:w-2/3">
                    <h1 class="text-2xl font-bold mb-4">{{ $book['title'] }}</h1>

                    <div class="space-y-3">
                        <div>
                            <strong>Autor(es):</strong>
                            {{ !empty($book['authors']) ? implode(', ', $book['authors']) : 'Não informado' }}
                        </div>

                        <div>
                            <strong>Editora:</strong>
                            {{ $book['publisher'] ?? 'Não informado' }}
                        </div>

                        <div>
                            <strong>ISBN:</strong>
                            {{ $book['isbn'] ?? 'Não informado' }}
                        </div>

                        @if($book['description'])
                            <div>
                                <strong>Descrição:</strong>
                                <p class="mt-2">{{ $book['description'] }}</p>
                            </div>
                        @endif
                    </div>

{{--                     Botões --}}
                    <div class="flex gap-4 mt-6">
                        <button onclick="history.back()" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Voltar
                        </button>

                        <form method="POST" action="{{ route('google-books.store') }}" class="inline">
                            @csrf
                            <input type="hidden" name="google_id" value="{{ $book['google_id'] }}">
                            <input type="hidden" name="title" value="{{ $book['title'] }}">
                            <input type="hidden" name="authors" value="{{ json_encode($book['authors']) }}">
                            <input type="hidden" name="publisher" value="{{ $book['publisher'] }}">
                            <input type="hidden" name="description" value="{{ $book['description'] }}">
                            <input type="hidden" name="thumbnail" value="{{ $book['thumbnail'] }}">
                            <input type="hidden" name="isbn" value="{{ $book['isbn'] }}">

                            <input type="hidden" name="original_query" value="{{ request('original_query') }}">
                            <input type="hidden" name="original_page" value="{{ request('original_page') }}">

                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded"
                                    onclick="return confirm('Importar este livro?')">
                                Importar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
