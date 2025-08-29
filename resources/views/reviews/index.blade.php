<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestão de Reviews') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <form action="{{ route('reviews.search') }}" method="GET">
        <div class="text-center">
            <input type="search" name="search" class="mr-sm-2" value="{{ $search ?? '' }}">
            <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                Pesquisar
            </button>
        </div>
    </form>

    <div class="w-full max-w-7xl mx-auto px-4 mt-6">
        <div class="overflow-x-auto border rounded bg-white">
            <table class="w-full border-collapse text-center">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Livro</th>
                    <th class="p-2 border">Cidadão</th>
                    <th class="p-2 border">Data</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Comentário</th>
                    <th class="p-2 border">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td class="p-2 border">
                            <a href="{{ route('livros.show', $review->livro->id) }}"
                               class="text-blue-600 hover:underline">
                                {{ $review->livro->name }}
                            </a>
                        </td>
                        <td class="p-2 border">{{ $review->user->name }}</td>
                        <td class="p-2 border">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-2 border">
                            @if($review->status === 'suspenso')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Pendente</span>
                            @elseif($review->status === 'ativo')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Aprovado</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Recusado</span>
                            @endif
                        </td>
                        <td class="p-2 border">
                            <div class="max-w-xs">
                                {{ Str::limit($review->comment, 100) }}
                            </div>
                        </td>

                        <td class="p-2 border">
                            <a href="{{ route('reviews.show', $review->id) }}"
                               class="px-3 py-1 rounded text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Ver Detalhes
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>
</x-app-layout>
