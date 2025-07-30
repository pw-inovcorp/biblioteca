<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autores') }}
        </h2>
    </x-slot>

    <div class="space-y-6 flex flex-col items-center mt-6">
        @foreach ($autores as $autor)
            <div class="rounded-lg p-4 w-64 text-center">
                <h2 class="text-xl font-bold">{{ $autor->name }}</h2>
                <img src="{{ $autor->foto }}" alt="{{ $autor->name }}" class="mx-auto rounded-full mt-2 object-cover shadow-md" style="max-width: 300px; max-height: 300px;">
            </div>
        @endforeach
        <div class="mt-4">
            {{ $autores->links() }}
        </div>
    </div>

     
</x-app-layout>