<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Log') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-lg mb-4">Informações Básicas</h3>
                    <div class="space-y-3">
                        <div>
                            <strong>Data/Hora:</strong>
                            <span>{{ $log->data_hora->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div>
                            <strong>Utilizador:</strong>
                            <span>{{ $log->user->name ?? 'Sistema' }}</span>
                        </div>
                        <div>
                            <strong>Módulo:</strong>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $log->modulo }}</span>
                        </div>
                        <div>
                            <strong>ID Objeto:</strong>
                            <span>{{ $log->objeto_id ?? '-' }}</span>
                        </div>
                        <div>
                            <strong>IP:</strong>
                            <span class="font-mono text-sm">{{ $log->ip_address }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-4">Informações do Navegador</h3>
                        <div>
                            <strong>Browser:</strong>
                            <div class="mt-1 p-2 bg-gray-50 rounded border text-sm font-mono">
                                {{ $log->browser ?? 'N/A' }}
                            </div>
                        </div>
                </div>

            </div>

            <div class="mt-6 pt-6 border-t">
                <h3 class="font-semibold text-lg mb-4">Alteração Realizada</h3>
                <div class="bg-gray-50 p-4 rounded border">
                    <p class="text-gray-800">{{ $log->alteracao }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('logs.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
