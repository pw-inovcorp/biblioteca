<x-app-layout>
    <x-slot:heading>
        Autor Page
    </x-slot:heading>

    {{-- <div class = "space-y-6>
        @foreach ($autores as $autor)
            <div class="border border-gray-200 rounded-lg p-4">
                <h2 class="text-xl font-bold">{{ $autor->name }}</h2>
                <img src="{{ $autor->foto }}" alt="{{ $autor->name }}" class="w-12 h-12 object-cover rounded-full">
            </div>
        @endforeach
    </div> --}}

    <div class="space-y-6 flex flex-col items-center">
    @foreach ($autores as $autor)
        <div class="rounded-lg p-4 w-64 text-center">
            <h2 class="text-xl font-bold">{{ $autor->name }}</h2>
            <img src="{{ $autor->foto }}" alt="{{ $autor->name }}" class="w-22 h-22 object-cover rounded-full mx-auto mt-2">
        </div>
    @endforeach
</div>
</x-app-layout>