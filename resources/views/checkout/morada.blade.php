<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout - Passo 1 de 2
        </h2>
    </x-slot>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Dados de Entrega</h3>

            <form method="POST" action="{{ route('checkout.morada') }}">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium mb-2">Nome Completo *</label>
                    <input type="text" name="nome_completo" value="{{ old('nome_completo', auth()->user()->name) }}"
                           class="w-full border rounded px-3 py-2" required>
                    @error('nome_completo')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Endereço *</label>
                    <input type="text" name="endereco" value="{{ old('endereco') }}"
                           class="w-full border rounded px-3 py-2" required>
                    @error('endereco')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="flex-1">
                        <label class="block font-medium mb-2">Cidade *</label>
                        <input type="text" name="cidade" value="{{ old('cidade') }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('cidade')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <label class="block font-medium mb-2">Código Postal *</label>
                        <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}"
                               class="w-full border rounded px-3 py-2" required>
                        @error('codigo_postal')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-medium mb-2">Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone') }}"
                           class="w-full border rounded px-3 py-2">
                    @error('telefone')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('carrinho.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Voltar ao Carrinho
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Continuar Confirmação
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
