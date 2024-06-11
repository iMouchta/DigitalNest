<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $correo;
    protected $mensaje;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($correo, $mensaje)
    {
        $this->correo = $correo;
        $this->mensaje = $mensaje;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw($this->mensaje, function ($message) {
            $message->to($this->correo)
                    ->subject('Sistema de Reserva de Ambientes');
        });
    }
}
