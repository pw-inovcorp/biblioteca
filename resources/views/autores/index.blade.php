<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autores') }}
        </h2>
    </x-slot>

    <x-slot:action>
        <x-button-crud href="/autores/create">Criar Autor</x-button-crud>
    </x-slot:action>

    <div class="space-y-6 flex flex-col items-center mt-6">
        @foreach ($autores as $autor)
            @php
                $isUrl = str_starts_with($autor->foto, 'http');
            @endphp
            
            <div class="rounded-lg p-4 w-64 text-center">
                <h2 class="text-xl font-bold">{{ $autor->name }}</h2>
                <img src="{{ $isUrl ? $autor->foto : asset('storage/' . $autor->foto) }}" alt="{{ $autor->name }}"
                    class="mx-auto rounded-full mt-2 object-cover shadow-md" style="max-width: 300px; max-height: 300px;"
                />
                <div class="mt-4 flex justify-center items-center gap-4">
                    <x-button-crud href="/autores/{{ $autor->id }}/edit">Editar</x-button-crud>
                </div>
            </div>

        @endforeach
        <div class="mt-4">
            {{ $autores->links() }}
        </div>
    </div>

     
</x-app-layout>