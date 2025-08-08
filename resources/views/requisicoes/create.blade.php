<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requisitar Livro') }}
        </h2>
    </x-slot>






    <form method="POST" action="{{ route('requisicoes.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="livro_id" value="{{ $livro->id }}">

        <div class="space-y-12 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Confirmar Requisição</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Confirme os dados da requisição do livro.</p>

                {{-- Dados do Livro --}}
                <div class="mt-10 bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">Bibliografia:</h3>
                    <p><strong>Título:</strong> {{ $livro->name }}</p>
                    <p><strong>ISBN:</strong> {{ $livro->isbn }}</p>
                    <p><strong>Editora:</strong> {{ $livro->editor->name ?? 'Sem editora' }}</p>
                    <p><strong>Autores:</strong> {{ $livro->autores->pluck('name')->join(', ') }}</p>
                </div>

                {{-- Informações da Requisição --}}
                <div class="mt-6 bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold mb-2">Informações da Requisição:</h3>
                    <p><strong>Data de Hoje:</strong> {{ now()->format('d/m/Y') }}</p>
                    <p><strong>Data de Devolução:</strong> {{ now()->addDays(5)->format('d/m/Y') }} (5 dias)</p>
                    <p><strong>Requisitante:</strong> {{ auth()->user()->name }}</p>
                </div>

                {{-- Upload de Foto (Opcional) --}}
                <div class="col-span-full mt-6">
                    <label for="foto_cidadao" class="block text-sm/6 font-medium text-gray-900">Sua Foto (Opcional)</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                        <div class="text-center">
                            <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="mx-auto size-12 text-gray-300">
                                <path d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm/6 text-gray-600">
                                <label for="foto_cidadao" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                                    <span>Upload uma foto</span>
                                    <input id="foto_cidadao" type="file" name="foto_cidadao" accept="image/*" class="sr-only" />
                                </label>
                                <p class="pl-1">ou arraste aqui</p>
                            </div>
                            <p class="text-xs/5 text-gray-600">PNG, JPG, GIF até 2MB</p>
                            @error('foto_cidadao')
                            <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Aviso --}}
                <div class="mt-6 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <strong>Atenção:</strong> Cada usuário só pode requisitar 3 livros. Tem 5 dias para devolver o livro.
                        Receberá um lembrete por email um dia antes da data de devolução.
                    </p>
                </div>

            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('livros.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Cancelar</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Confirmar Requisição
            </button>
        </div>
    </form>

</x-app-layout>
