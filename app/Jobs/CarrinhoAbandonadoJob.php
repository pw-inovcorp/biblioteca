<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Mail\CarrinhoAbandonadoMail;
use Illuminate\Support\Facades\Mail;

class CarrinhoAbandonadoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user;
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        if($this->user->hasItensNoCarrinho()) {
            Mail::to($this->user->email)->send(new CarrinhoAbandonadoMail($this->user));

            \Log::info('Email carrinho abandonado enviado', [
                'user_id' => $this->user->id,
                'items_count' => $this->user->countItensCarrinho()
            ]);
        }

    }
}
