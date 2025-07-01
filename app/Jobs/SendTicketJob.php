<?php

namespace App\Jobs;

use App\Mail\SendTicket;
use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaksi;

    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function handle()
    {
        Mail::to($this->transaksi->pelanggan->email)
            ->send(new SendTicket($this->transaksi));
    }
}
