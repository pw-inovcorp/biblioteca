<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logs do Sistema') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full ">
            <thead class="bg-gray-50">
            <tr class="text-center">
                <th class="px-4 py-3 border-r">Data/Hora</th>
                <th class="px-4 py-3 border-r">Utilizador</th>
                <th class="px-4 py-3 border-r">Módulo</th>
                <th class="px-4 py-3 border-r">ID Objeto</th>
                <th class="px-4 py-3 border-r">Alteração</th>
                <th class="px-4 py-3 border-r">IP</th>
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
                    <td class="px-4 py-3 border-r">{{ $log->ip_address }}</td>
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
