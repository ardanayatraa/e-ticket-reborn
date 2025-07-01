<?php

namespace App\Mail;

use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class SendTicket extends Mailable
{
    use Queueable, SerializesModels;

    public Transaksi $transaksi;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket Bali OM - Terimakasih',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
            with: [
                'transaksi' => $this->transaksi,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.ticket', ['transaksi' => $this->transaksi]);

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdf->output(), 'e-ticket.pdf')
                ->withMime('application/pdf')
        ];
    }
}
