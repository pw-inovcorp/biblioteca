<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autores') }}
        </h2>
    </x-slot>

   @if(auth()->check() && auth()->user()->isAdmin())
        <x-slot:action>
            <x-button-crud href="/autores/create">Criar Autor</x-button-crud>
        </x-slot:action>
    @endif

    <form action="{{ route('autores.search') }}" method="GET">
        <input type="search" name="search" class="mr-sm-2" value="{{ $search }}" placeholder="Nome">
        <button type="submit"class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Pesquisar</button>
    </form>

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
                    @if (auth()->check() && auth()->user()->isAdmin())
                        <x-button-crud href="/autores/{{ $autor->id }}/edit">Editar</x-button-crud>
                    @endif
                </div>
            </div>

        @endforeach
        <div class="mt-4">
            {{ $autores->links() }}
        </div>
    </div>

     
</x-app-layout>