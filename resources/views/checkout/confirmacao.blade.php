<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout - Passo 2 de 2
        </h2>
    </x-slot>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-6 px-4 space-y-6">
        {{-- Resumo --}}
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Resumo da Compra</h3>

            @foreach($items as $item)
                <div class="flex justify-between py-2">
                    <span>{{ $item->livro->name }} x{{ $item->quantidade }}</span>
                    <span>€{{ $item->calcSubTotal() }}</span>
                </div>
            @endforeach

            <div class="border-t pt-2 mt-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>Total:</span>
                    <span>€{{ $total }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-bold mb-4">Dados de Entrega</h3>

            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Nome:</strong> {{ $morada['nome_completo'] }}</p>
                <p><strong>Endereço:</strong> {{ $morada['endereco'] }}</p>
                <p><strong>Cidade:</strong> {{ $morada['cidade'] }}</p>
                <p><strong>Código Postal:</strong> {{ $morada['codigo_postal'] }}</p>
                @if($morada['telefone'])
                    <p><strong>Telefone:</strong> {{ $morada['telefone'] }}</p>
                @endif
            </div>

            <div class="mt-2">
                <a href="{{ route('checkout.morada') }}" class="text-blue-600">Alterar dados</a>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 p-4 rounded">
            <p><strong>Informação:</strong> Esta encomenda será criada com status "Pendente". O pagamento será implementado em breve.</p>
        </div>


        <div class="bg-white rounded shadow p-6">
            <div class="flex justify-between">
                <a href="{{ route('checkout.morada') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
