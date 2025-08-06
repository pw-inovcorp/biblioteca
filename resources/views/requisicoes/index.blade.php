<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requisições') }}
        </h2>
    </x-slot>

    

    {{-- Mensagens de sucesso/erro --}}
    {{-- @if(session('success'))
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
    @endif --}}

    <div class="w-full max-w-7xl mx-auto px-4 mt-6">
        <div class="overflow-x-auto border rounded bg-white">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">Nº Requisição</th>
                        <th class="p-2 border text-left">Livro</th>
                        @if(auth()->user()->isAdmin())
                            <th class="p-2 border text-left">Cidadão</th>
                        @endif
                        <th class="p-2 border text-left">Data Requisição</th>
                        <th class="p-2 border text-left">Devolução Prevista</th>
                        <th class="p-2 border text-left">Status</th>
                        <th class="p-2 border text-center">Ações</th>
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
                        <td class="p-2 border text-center">

                            //ToDo
                            
                        </td>
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