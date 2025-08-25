<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Carrinho') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if($items->count() > 0)
            <div class="bg-white rounded-lg shadow">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left border-r">Livro</th>
                            <th class="px-6 py-4 text-left border-r">Preço</th>
                            <th class="px-6 py-4 text-left border-r">Qtd</th>
                            <th class="px-6 py-4 text-left border-r">Subtotal</th>
                            <th class="px-6 py-4 text-left">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 border-r">
                                    <div class="flex items-center space-x-4">
                                        @if($item->livro->image)
                                            @php
                                                $isUrl = str_starts_with($item->livro->image, 'http');
                                            @endphp
                                            <img class="w-16 h-20 object-cover rounded shadow-sm"
                                                 src="{{ $isUrl ? $item->livro->image : asset('storage/' . $item->livro->image) }}"
                                                 alt="{{ $item->livro->name }}">
                                        @endif
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $item->livro->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $item->livro->autores->pluck('name')->join(', ') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-r">
                                    €{{$item->livro->price }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-r">
                                    {{ $item->quantidade }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 border-r">
                                    €{{ $item->calcSubtotal() }}
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('carrinho.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium"
                                                onclick="return confirm('Remover este item?')">
                                            Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-900">Total: €{{ $total }}</span>
                        <div class="flex space-x-3">
                            <a href="{{ route('livros.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium">
                                Continuar Comprando
                            </a>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                                Finalizar Compra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <h3 class="text-xl font-medium text-gray-900 mb-4">Seu carrinho está vazio</h3>
                <p class="text-gray-600 mb-6">Adicione alguns livros para começar!</p>
                <a href="{{ route('livros.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    Ver Livros
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
