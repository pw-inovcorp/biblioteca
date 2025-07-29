<x-app-layout>
    <x-slot:heading>
        Livro Page
    </x-slot:heading>
    


    <div class="space-y-6 flex flex-col items-center mt-6">
        @foreach ($editoras as $editora)
            <div class="rounded-lg p-4 w-64 text-center">
                <h2 class="text-xl font-bold">{{ $editora->name }}</h2>
                <img src="{{ $editora->logotipo }}" alt="{{ $editora->name }}" class="mx-auto rounded-full mt-2 object-cover shadow-md" style="max-width: 300px; max-height: 300px;">
            </div>
        @endforeach
    </div>

    <div class="my-6 max-w-3xl mx-auto px-4">
        {{ $editoras->links() }}
    </div>
</x-app-layout>