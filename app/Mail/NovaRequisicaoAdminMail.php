<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Requisicao;

class NovaRequisicaoAdminMail extends Mailable
{
    use Queueable, SerializesModels;
    public $requisicao;
    /**
     * Create a new message instance.
     */
    public function __construct(Requisicao $requisicao)
    {
        //
        $this->requisicao = $requisicao;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
             subject: 'Nova Requisição Registada - ' . $this->requisicao->numero_requisicao,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: '/emails/nova-requisicao-admin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
