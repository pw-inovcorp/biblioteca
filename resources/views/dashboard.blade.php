<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif


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
                    <div class="grid grid-cols-1 md:grid-cols-{{ auth()->user()->isAdmin() ? '5' : '4' }} gap-4">
                        <a href="{{ route('livros.index') }}" class="text-white bg-blue-500 text-center p-3 rounded hover:bg-blue-600">
                            Ver Catálogo
                        </a>
                        <a href="{{ route('requisicoes.index') }}" class="text-white bg-green-500 text-center p-3 rounded hover:bg-green-600">
                            Minhas Requisições
                        </a>
                        <a href="{{ route('profile.show') }}" class="text-white bg-gray-500 text-center p-3 rounded hover:bg-gray-600">
                            Meu Perfil
                        </a>

                        <a href="{{ route('encomendas.index') }}" class="text-white bg-yellow-500 text-center p-3 rounded hover:bg-yellow-600">
                            Encomendas
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('google-books.index') }}" class="text-white bg-indigo-500 text-center p-3 rounded hover:bg-indigo-600">
                                Importar Livros
                            </a>

                            <a href="{{ route('reviews.index') }}" class="text-white bg-yellow-500 text-center p-3 rounded hover:bg-yellow-600">
                                Reviews
                            </a>
                        @endif
                    </div>
                </div>

        </div>
    </div>
</x-app-layout>
