<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 @if(Auth::user()->isAdmin())
                    <span class="text-green-500"> - Sou ADMIN </span>
                 @else
                    <span class="text-blue-500"> - Sou Cidadão </span>
                 @endif

                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
