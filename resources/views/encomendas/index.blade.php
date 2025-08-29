<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->isAdmin())
                {{ __('Todas as Encomendas') }}
            @else
                {{ __('Minhas Encomendas') }}
            @endif
        </h2>
    </x-slot>

    @if(auth()->user()->isAdmin())
        <form action="{{ route('encomendas.search') }}" method="GET">
            <div class="text-center">
                <input type="search" name="search" class="mr-sm-2" value="{{ $search ?? '' }}">
                <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                    Pesquisar
                </button>
            </div>
        </form>
    @endif

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if($encomendas->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden border">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left border-r">Nº Encomenda</th>
                            @if(auth()->user()->isAdmin())
                                <th class="px-6 py-4 text-left border-r">Cliente</th>
                            @endif
                            <th class="px-6 py-4 text-left border-r">Data</th>
                            <th class="px-6 py-4 text-left border-r">Status</th>
                            <th class="px-6 py-4 text-left border-r">Total</th>
                            <th class="px-6 py-4 text-left">Itens</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($encomendas as $encomenda)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="border-r p-0">
                                    <a href="{{route('encomendas.show', $encomenda->id)}}"
                                       class="block px-6 py-4 text-blue-600 underline">
                                        {{ $encomenda->numero_encomenda }}
                                    </a>
                                </td>

                                @if(auth()->user()->isAdmin())
                                    <td class="px-6 py-4 border-r">
                                        <div>{{ $encomenda->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $encomenda->user->email }}</div>
                                    </td>
                                @endif

                                <td class="px-6 py-4 border-r">{{ $encomenda->created_at->format('d/m/Y H:i') }}</td>

                                <td class="px-6 py-4 border-r">
                                    @if($encomenda->status === 'pendente')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Pendente</span>
                                    @elseif($encomenda->status === 'paga')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Paga</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">{{ $encomenda->status }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 font-semibold border-r">€{{ $encomenda->total }}</td>

                                <td class="px-6 py-4">{{ $encomenda->items->sum('quantidade') }} livros</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                @if(auth()->user()->isAdmin())
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Nenhuma encomenda no sistema</h3>
                    <p class="text-gray-600">Ainda não foram feitas encomendas.</p>
                @else
                    <h3 class="text-xl font-medium text-gray-900 mb-4">Não tem encomendas ainda</h3>
                    <p class="text-gray-600 mb-6">Quando fizer encomendas, elas aparecerão aqui.</p>
                    <a href="{{ route('livros.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Ver Livros
                    </a>
                @endif
            </div>
        @endif
    </div>
    <div class="mt-6">
        {{ $encomendas->links() }}
    </div>
</x-app-layout>
