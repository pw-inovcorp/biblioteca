<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\CarrinhoAbandonadoJob;

class EnviarCarrinhoAbandonado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-carrinho-abandonado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia emails para utilizadores com carrinho abandonado há mais de 1 hora';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $users = User::whereHas('carrinhoItems', fn($q) =>
        $q->where('created_at', '<=', now()->subMinutes(1)))
        ->with('carrinhoItems')
        ->get();

        $this->info("Encontrados {$users->count()} utilizadores com carrinho abandonado.");

        foreach ($users as $user) {

            CarrinhoAbandonadoJob::dispatch($user);

            $this->info("Job agendado para: {$user->email} ({$user->countItensCarrinho()} items)");
        }

        $this->info('Processo concluído!');

    }
}
