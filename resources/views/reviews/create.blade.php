<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fazer Review') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded p-6">

            {{-- Informações do livro e requisição --}}
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">Dados da Requisição:</h3>
                <p><strong>Livro:</strong> {{ $requisicao->livro->name }}</p>
                <p><strong>ISBN:</strong> {{ $requisicao->livro->isbn }}</p>
                <p><strong>Nº Requisição:</strong> {{ $requisicao->numero_requisicao }}</p>
                <p><strong>Data Devolução:</strong> {{ $requisicao->data_real_entrega->format('d/m/Y') }}</p>
            </div>

            {{-- Formulário de review --}}
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <input type="hidden" name="requisicao_id" value="{{ $requisicao->id }}">

                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium mb-2">
                        Seu Review sobre o livro:
                    </label>
                    <textarea
                        id="comment"
                        name="comment"
                        rows="6"
                        class="w-full border rounded px-3 py-2"
                        placeholder="Partilhe a sua opinião sobre este livro... (mínimo 10 caracteres)"
                        required>{{ old('comment') }}</textarea>

                    @error('comment')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-sm text-gray-600">
                        Mínimo 10 caracteres, máximo 1000 caracteres.
                    </p>
                </div>

                {{-- Aviso --}}
                <div class="mb-6 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <strong>Importante:</strong> O seu review será analisado pelos administradores antes de ficar visível para outros utilizadores.
                    </p>
                </div>

                {{-- Botões --}}
                <div class="flex gap-4">
                    <a href="{{ route('requisicoes.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Enviar Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
