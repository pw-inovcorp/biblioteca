<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">

            @if(auth()->user()->isAdmin())
                {{-- Dashboard Admin --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="box">
                        <div class="text-small">Total Livros</div>
                        <div class="text-big">
                            {{ \App\Models\Livro::count() }}
                        </div>
                    </div>
                    <div class="box">
                        <div class="text-small">Requisições Ativas</div>
                        <div class="text-big" style="color: green">
                            {{ \App\Models\Requisicao::ativas()->count() }}
                        </div>
                    </div>
                    <div class="box">
                        <div class="text-small">Requisições Atrasadas</div>
                        <div class="text-big" style="color: red">
                            {{ \App\Models\Requisicao::where('status', 'ativa')->where('data_prevista_entrega', '<', now())->count() }}
                        </div>
                    </div>
                    <div class="box">
                        <div class="text-small">Total Usuários</div>
                        <div class="text-big">
                            {{ \App\Models\User::whereHas('role', fn($q) => $q->whereIn('name', ['cidadao', 'admin']))->count() }}
                        </div>
                    </div>
                </div>


            @else
                {{-- Dashboard Cidadão --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="box">
                        <div class="text-small">Minhas Requisições Ativas</div>
                        <div class="text-big" style="color: royalblue">
                            {{ auth()->user()->requisicoes()->ativas()->count() }}
                        </div>
                        <p class="text-small">Máximo: 3 livros</p>
                    </div>
                    <div class="box">
                        <div class="text-small">Total de Livros Requisitados</div>
                        <div class="text-big" style="color: green">
                            {{ auth()->user()->requisicoes()->count() }}
                        </div>
                    </div>
                    <div class="box">
                        <div class="text-small">Livros Disponíveis</div>
                        <div class="text-big">
                            {{ \App\Models\Livro::whereDoesntHave('requisicoes', fn($q) => $q->where('status', 'ativa'))->count() }}
                        </div>
                    </div>
                </div>
            @endif

                {{-- Ações rápidas --}}
                <div class="box">
                    <div class="title">Ações Rápidas</div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('livros.index') }}" class="text-white text-center p-3 rounded" style="background: royalblue;">
                            Ver Catálogo
                        </a>
                        <a href="{{ route('requisicoes.index') }}" class="text-white text-center p-3 rounded" style="background: forestgreen;">
                            Minhas Requisições
                        </a>
                        <a href="{{ route('profile.show') }}" class="text-white text-center p-3 rounded" style="background: grey;">
                            Meu Perfil
                        </a>
                    </div>
                </div>

        </div>
    </div>
</x-app-layout>
