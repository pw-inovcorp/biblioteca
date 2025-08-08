<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requisições') }}
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

    @if(auth()->user()->isAdmin())
        <form action="{{ route('requisicoes.search') }}" method="GET">
            <div class="text-center">
                <input type="search" name="search" class="mr-sm-2" value="{{ $search ?? '' }}" placeholder="Nome cidadão">
                <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Pesquisar</button>
            </div>
        </form>
    @endif

    <div class="w-full max-w-7xl mx-auto px-4 mt-6">
        <div class="overflow-x-auto border rounded bg-white">
            <table class="w-full border-collapse text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-center">Nº Requisição</th>
                        <th class="p-2 border text-center">Livro</th>
                        @if(auth()->user()->isAdmin())
                            <th class="p-2 border text-center">Cidadão</th>
                        @endif
                        <th class="p-2 border text-center">Data Requisição</th>
                        <th class="p-2 border text-center">Devolução Prevista</th>
                        <th class="p-2 border text-center">Status</th>
                        @if(auth()->user()->isAdmin())
                            <th class="p-2 border text-center">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisicoes as $requisicao)
                    <tr>
                        <td class="p-2 border">{{ $requisicao->numero_requisicao }}</td>
                        <td class="p-2 border">{{ $requisicao->livro->name }}</td>
                        @if(auth()->user()->isAdmin())
                            <td class="p-2 border">{{ $requisicao->user->name }}</td>
                        @endif
                        <td class="p-2 border">{{ $requisicao->data_requisicao->format('d/m/Y') }}</td>
                        <td class="p-2 border">
                            {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}
                            @if($requisicao->isAtrasada())
                                <span class="text-red-600 text-sm">(Atrasada)</span>
                            @endif
                        </td>
                        <td class="p-2 border">
                            @if($requisicao->status === 'ativa')
                                <span class="text-yellow-600 font-semibold">Ativa</span>
                            @elseif($requisicao->status === 'devolvida')
                                <span class="text-green-600 font-semibold">Devolvida</span>
                                @if($requisicao->data_real_entrega)
                                    <br><span class="text-sm text-gray-600">{{ $requisicao->data_real_entrega->format('d/m/Y') }}</span>
                                @endif
                            @endif
                        </td>

                            @if(auth()->user()->isAdmin() && $requisicao->status === "ativa")
                                <td>
                                    <form method="POST" action="{{ route('requisicoes.devolver', $requisicao->id) }}">
                                    @csrf
                                    @method('PATCH')
                                        <button type="submit" class="text-gray underline"
                                                onclick="return confirm('Confirmar devolução?')">
                                            Confirmar Devolução
                                        </button>
                                    </form>
                                </td>
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $requisicoes->links() }}
    </div>

</x-app-layout>
