<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ('Google Books') }}
        </h2>
    </x-slot>


    {{-- Formulário de pesquisa --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Pesquisar Livros</h3>

        <form method="POST" action="{{ route('google-books.search') }}" class="flex gap-4">
            @csrf
            <input type="text"
                   name="query"
                   placeholder="Ex: Harry Potter, Stephen King, isbn:123456"
                   class="flex-1 border rounded px-3 py-2"
                   required>
            <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                Pesquisar
            </button>
        </form>

        @error('query')
        <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botão de teste --}}
    <div class="bg-gray-50 p-6 rounded shadow">
        <h4 class="font-semibold mb-3">Teste da API</h4>
        <a href="{{ route('google-books.test') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Testar API
        </a>
    </div>

        @if(isset($result))
            <div class="bg-green-400 p-4 rounded mb-6">
                <strong>Resultado:</strong> {{ $result }}
            </div>
        @endif

</x-app-layout>
