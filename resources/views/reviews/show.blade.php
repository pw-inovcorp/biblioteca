<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moderar Review') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded shadow p-6">

            {{-- Informações do Review --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Informações do Review</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p><strong>Livro:</strong> {{ $review->livro->name }}</p>
                        <p><strong>ISBN:</strong> {{ $review->livro->isbn }}</p>
                    </div>
                    <div>
                        <p><strong>Cidadão:</strong> {{ $review->user->name }}</p>
                        <p><strong>Email:</strong> {{ $review->user->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>Data do Review:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Requisição:</strong> {{ $review->requisicao->numero_requisicao }}</p>
                    </div>
                    <div>
                        <p><strong>Status Atual:</strong>
                            @if($review->status === 'suspenso')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Pendente</span>
                            @elseif($review->status === 'ativo')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Aprovado</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Recusado</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Comentário do Review --}}
            <div class="mb-6">
                <h4 class="font-semibold mb-2">Comentário do Cidadão:</h4>
                <div class="bg-gray-50 p-4 rounded border">
                    <p class="text-gray-800">{{ $review->comment }}</p>
                </div>
            </div>

            {{-- Justificação de Recusa (se existe) --}}
            @if($review->justificacao_recusa)
                <div class="mb-6">
                    <h4 class="font-semibold mb-2">Justificação da Recusa:</h4>
                    <div class="bg-red-50 p-4 rounded border border-red-200">
                        <p class="text-red-800">{{ $review->justificacao_recusa }}</p>
                    </div>
                </div>
            @endif

            {{-- Ações Admin --}}
            @if($review->status === 'suspenso')
                <div class="border-t pt-6">

                    <div class="gap-4 mb-6">
                        {{-- Aprovar --}}
                        <form method="POST" action="{{ route('reviews.aprovar', $review->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                    onclick="return confirm('Aprovar este review?')">
                                Aprovar Review
                            </button>
                        </form>
                    </div>

                    {{-- Recusar --}}
                    <form method="POST" action="{{ route('reviews.recusar', $review->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="justificacao_recusa" class="block text-sm font-medium text-gray-700 mb-2">
                                Justificação para Recusa:
                            </label>
                            <textarea
                                id="justificacao_recusa"
                                name="justificacao_recusa"
                                rows="4"
                                class="w-full border rounded px-3 py-2"
                                placeholder="Explique por que está a recusar este review..."
                                required>{{ old('justificacao_recusa') }}</textarea>

                            @error('justificacao_recusa')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                                onclick="return confirm('Recusar este review?')">
                            Recusar Review
                        </button>
                    </form>
                </div>
            @endif

            {{-- Botão Voltar --}}
            <div class="border-t pt-6 mt-6">
                <a href="{{ route('reviews.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Voltar à Lista
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
