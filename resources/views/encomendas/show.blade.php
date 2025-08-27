<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ __('Encomenda: ') . $encomenda->numero_encomenda }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-4xl mx-auto mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-4">
        <div class="bg-white shadow rounded p-4 mb-4">
            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold">Encomenda {{ $encomenda->numero_encomenda }}</h3>
                    <p class="text-gray-600 text-sm">Criada em {{ $encomenda->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="text-sm px-2 py-1 rounded-full {{ $encomenda->status === 'pendente' ? 'bg-yellow-100 text-yellow-800' : ($encomenda->status === 'paga' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $encomenda->status }}
                    </span>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="mt-6 border-t pt-2 text-sm">
                    <p><strong>Nome:</strong> {{ $encomenda->user->name }}</p>
                    <p><strong>Email:</strong> {{ $encomenda->user->email }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white shadow rounded p-4 mb-4">
            <h3 class="font-semibold mb-2">Dados de Entrega</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <div>
                    <p><strong>Nome:</strong> {{ $encomenda->morada_entrega['nome_completo'] }}</p>
                    <p><strong>Endereço:</strong> {{ $encomenda->morada_entrega['endereco'] }}</p>
                </div>
                <div>
                    <p><strong>Cidade:</strong> {{ $encomenda->morada_entrega['cidade'] }}</p>
                    <p><strong>Código Postal:</strong> {{ $encomenda->morada_entrega['codigo_postal'] }}</p>
                    @if(!empty($encomenda->morada_entrega['telefone']))
                        <p><strong>Telefone:</strong> {{ $encomenda->morada_entrega['telefone'] }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded p-4 mb-4">
            <h3 class="font-semibold mb-2">Itens da Encomenda</h3>
            <div class="space-y-2 text-sm">
                @foreach($encomenda->items as $item)
                    <div class="flex items-center border-b pb-2">
                        <div class="w-16 h-20 mr-2">
                            @if($item->livro->image)
                                @php
                                    $isUrl = str_starts_with($item->livro->image, 'http');
                                @endphp
                                <img src="{{ $isUrl ? $item->livro->image : asset('storage/' . $item->livro->image) }}"
                                     alt="{{ $item->livro->name }}" class="w-full h-full object-cover rounded">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded text-xs text-gray-400">
                                    Sem imagem
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">{{ $item->livro->name }}</p>
                            <p>{{ $item->livro->autores->pluck('name')->join(', ') }}</p>
                            <p>ISBN: {{ $item->livro->isbn }}</p>
                        </div>
                        <div class="text-right text-sm">
                            <p>Qtd: {{ $item->quantidade }}</p>
                            <p>Preço: €{{ $item->preco_unitario }}</p>
                            <p class="font-semibold">Subtotal: €{{ $item->subtotal }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 flex justify-between font-semibold">
                <span>Total da Encomenda:</span>
                <span>€{{ $encomenda->total }}</span>
            </div>
        </div>

        <div class="bg-white shadow rounded p-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('encomendas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Voltar</a>
                @if($encomenda->status === 'pendente')
                    <span class="text-sm text-gray-600">Aguardando pagamento...</span>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
