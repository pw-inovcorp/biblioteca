<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logs do Sistema') }}
        </h2>
    </x-slot>

    <form action="{{ route('logs.search') }}" method="GET" class="mb-6">
        <div class="text-center">
            <input type="search" name="search" class="mr-sm-2" value="{{ $search ?? '' }}" placeholder="Nome">
            <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Pesquisar</button>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full ">
            <thead class="bg-gray-50">
            <tr class="text-center">
                <th class="px-4 py-3 border-r">Data/Hora</th>
                <th class="px-4 py-3 border-r">Utilizador</th>
                <th class="px-4 py-3 border-r">Módulo</th>
                <th class="px-4 py-3 border-r">ID Objeto</th>
                <th class="px-4 py-3 border-r">Alteração</th>
                <th class="px-4 py-3 border-r">Browser</th>
                <th class="px-4 py-3 border-r">IP</th>
                <th class="px-4 py-3 border-r">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($logs as $log)
                <tr class="text-center border-b">
                    <td class="px-4 py-3 border-r">{{ $log->data_hora->format('d/m/Y H:i:s') }}</td>
                    <td class="px-4 py-3 border-r">{{ $log->user->name ?? 'Sistema' }}</td>
                    <td class="px-4 py-3 border-r">{{ $log->modulo }}</td>
                    <td class="px-4 py-3 border-r">{{ $log->objeto_id ?? '-' }}</td>
                    <td class="px-4 py-3 border-r">{{ $log->alteracao }}</td>
                    <td class="px-4 py-3 border-r">{{ Str::limit($log->browser, 30) }}</td>
                    <td class="px-4 py-3 border-r">{{ $log->ip_address }}</td>
                    <td class="px-4 py-3 border-r">
                        <a href="{{ route('logs.show', $log->id) }}"
                           class="text-blue-600 hover:text-blue-800 underline text-sm">
                            Ver Detalhes
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        Nenhum log encontrado.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div>
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
