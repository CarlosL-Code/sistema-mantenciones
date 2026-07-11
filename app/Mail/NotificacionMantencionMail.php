<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Mantencion;

class NotificacionMantencionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mantencion;
    public $titulo;
    public $mensaje;

    /**
     * Create a new message instance.
     */
    public function __construct(Mantencion $mantencion, string $titulo, string $mensaje)
    {
        $this->mantencion = $mantencion;
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aviso del Sistema: ' . $this->mantencion->maquinaria->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notificacion_mantencion',
            with: [
                'mantencion' => $this->mantencion,
                'titulo' => $this->titulo,
                'mensaje' => $this->mensaje,
            ]
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
