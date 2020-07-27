<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PagoRealizadoOXXO extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El pedido como objeto de eloquent
     *
     * @var Pedido
     */
    public $pedido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pago por OXXO de la tienda GBRoute')->view('correos.correoConfirmPagoOXXO');
    }
}
