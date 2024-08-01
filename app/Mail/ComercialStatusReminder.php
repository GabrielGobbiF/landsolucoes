<?php

namespace App\Mail;

use App\Models\Obra;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComercialStatusReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected Obra $obra, protected $responsavel)
    {
        $this->obra = $obra;
        $this->responsavel = $responsavel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $routeObra = route('comercial.show', $this->obra->id);

        return $this->markdown('vendor.emails.obras.obra_status_reminder')
            ->subject('Lembrete: Serviço em Elaboração')
            ->with([
                'obra' => $this->obra,
                'responsavel' => $this->responsavel->name,
                'routeObra' => $routeObra,
            ]);
    }
}
