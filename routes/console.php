<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Requisicao;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Agendar envio de lembretes
Schedule::command('requisicoes:enviar-lembretes')
    ->dailyAt('09:00')
    ->appendOutputTo(storage_path('logs/lembretes.log'));

// Atualizar status para "atrasada" à meia-noite
Schedule::call(function () {
    Requisicao::where('status', 'ativa')
        ->where('data_prevista_entrega', '<', now())
        ->update(['status' => 'atrasada']);
})->dailyAt('00:01')->name('atualizar-requisicoes-atrasadas');

// Executar de hora em hora
Schedule::command('app:enviar-carrinho-abandonado')
    ->everyMinute()
    ->appendOutputTo(storage_path('logs/carrinho-abandonado.log'));
