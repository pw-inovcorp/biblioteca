<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout - Passo 1 de 3
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Revise sua compra</h3>

            @foreach($items as $item)
                <div class="border-b py-4">
                    <div class="flex justify-between">
                        <div>
                            <h4 class="font-medium">{{ $item->livro->name }}</h4>
                            <p class="text-gray-600">Quantidade: {{ $item->quantidade }} | Preço: €{{ $item->livro->price }}</p>
                        </div>
                        <div>
                            <strong>€{{ $item->calcSubTotal() }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="pt-4 text-right">
                <span class="text-xl font-bold">Total: €{{ $total }}</span>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('carrinho.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Carrinho
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
