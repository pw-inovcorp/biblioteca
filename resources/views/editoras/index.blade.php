<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editoras') }}
        </h2>
    </x-slot>

    <x-slot:action>
        <x-button-crud href="/editoras/create">Criar Editora</x-button-crud>
    </x-slot:action>

     <form action="{{ route('editoras.search') }}" method="GET">
        <input type="search" name="search" class="mr-sm-2" placeholder="Nome">
        <button type="submit"class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Pesquisar</button>
     </form>
    
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
                <div class="mt-4 flex justify-center items-center gap-4">
                    <x-button-crud href="/editoras/{{ $editora->id }}/edit">Editar</x-button-crud>
                </div>
            </div>

            {{-- //Actions
            <div class="my-6 max-w-3xl mx-auto px-4 flex gap-4 items-center">
                <x-button-crud href="/editoras/{{ $editora->id }}/edit">Editar</x-button-crud>
                <a href="/editoras/{{ $editora->id }}/delete" class="text-red-500 text-sm">Eliminar</a>
            </div> --}}
        @endforeach
    </div>


    <div class="my-6 max-w-3xl mx-auto px-4">
        {{ $editoras->links() }}
    </div>

    {{-- <form action="/editoras/{{ $editora->id }}" method="POST" id="delete-editor-form" class="hidden">
        @csrf
        @method('DELETE')
    </form> --}}
</x-app-layout>