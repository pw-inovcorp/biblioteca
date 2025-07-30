<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editoras') }}
        </h2>
    </x-slot>

    <x-slot:action>
        <x-button-crud href="/editoras/create">Crear Editora</x-button-crud>
    </x-slot:action>

    
    <div class="space-y-6 flex flex-col items-center mt-6">
        @foreach ($editoras as $editora)

            @php
                $isUrl = str_starts_with($editora->logotipo, 'http');
            @endphp

            <div class="rounded-lg p-4 w-64 text-center">
                <h2 class="text-xl font-bold">{{ $editora->name }}</h2>
                <img src="{{ $isUrl ? $editora->logotipo : asset('storage/' . $editora->logotipo) }}" alt="{{ $editora->name }}"
                    class="mx-auto rounded-full mt-2 object-cover shadow-md" style="max-width: 300px; max-height: 300px;"
                />
            </div>
        @endforeach
    </div>

    <div class="my-6 max-w-3xl mx-auto px-4">
        {{ $editoras->links() }}
    </div>
</x-app-layout>