<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Requisicao;
use App\Models\User;
use Mail;

class EnviarReminderDevolucao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-reminder-devolucao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $amanha = Carbon::tomorrow()->toDateString();

        $requisicoes = Requisicao::where('status', 'ativa')
            ->whereDate('data_prevista_entrega', $amanha)
            ->with(['user', 'livro'])
            ->get();

        $this->info("Encontradas {$requisicoes->count()} requisições que vencem amanhã.");

        foreach ($requisicoes as $requisicao) {
            try {
                Mail::to($requisicao->user->email)->send(new LembreteDevolucaoMail($requisicao));
                $this->info("Lembrete enviado para: {$requisicao->user->email} - Requisição: {$requisicao->numero_requisicao}");
            } catch (\Exception $e) {
                $this->error("Erro ao enviar para {$requisicao->user->email}: " . $e->getMessage());
            }
        }

        $this->info('Processo de envio de lembretes concluído!');
    }
}
