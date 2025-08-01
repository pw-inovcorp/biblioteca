<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Livros') }}
        </h2>
    </x-slot>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <form method="POST" action="/livros" enctype="multipart/form-data">
        @csrf

        <div class="space-y-12 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Criar um Novo Livro</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Precisamos apenas de alguns detalhes seus.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="isbn" class="block text-sm font-medium leading-6 text-gray-900">ISBN</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" name="isbn" id="isbn" class="block flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="978-3-16-148410-0" required>
                            </div>
                            @error('isbn')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nome</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Shift Leader" required>
                            </div>
                            @error('name')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- EDITORA - SELECT ÚNICO -->
                 <div class="sm:col-span-4">
                        <label for="editor_id" class="block text-sm/6 font-medium text-gray-900">Editora</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="editor_id" name="editor_id" autocomplete="editor-name"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required>
                                <option>Selecione uma editora</option>
                                @foreach ($editoras as $editora)
                                    <option value="{{ $editora->id }}">{{ $editora->name }}</option>
                                @endforeach
                            </select>

                            @error('editor_id')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                                <path
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- AUTOR - MULTISELECT -->
                    <div class="sm:col-span-4">
                        <label for="autores" class="block text-sm/6 font-medium text-gray-900">Autores</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="autores" name="autor_ids[]" multiple size="10" autocomplete="off"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required>
                                @foreach ($autores as $autor)
                                    <option value="{{ $autor->id }}">{{ $autor->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Ctrl/Cmd + clique para escolher múltiplos autores</p>
                            @error('autores')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
                                class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                                <path
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Bibliografia -->
                   <div class="col-span-full">
                        <label for="bibliography" class="block text-sm/6 font-medium text-gray-900">Bibliografia</label>
                        <div class="mt-2">
                            <textarea id="bibliography" name="bibliography" rows="3"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Introdução à Programação, 2023" required></textarea>
                            @error('bibliography')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-600">Escreve uma breve introdução do livro.</p>
                    </div>

                    <div class="col-span-full">
                        <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Foto de Capa</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true"
                                    class="mx-auto size-12 text-gray-300">
                                    <path
                                        d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                        clip-rule="evenodd" fill-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm/6 text-gray-600">
                                    <label for="image"
                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="image" type="file" name="image" accept="image/jpg, image/png, image/jpeg, image/gif" class="sr-only" />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                @error('image')
                                    <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Preço</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="number" name="price" id="price" step="0.01" min="0"
                                    class="block flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" required
                                    placeholder="19.99" required>
                            </div>
                            @error('price')
                                <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                </div>  
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="/livros" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancelar</a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
        </div>
    </form>
</x-app-layout>