<?php

namespace App\Jobs;

use App\Managers\ApiBrasil\ApiBrasil;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $number, private $message = null) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app(ApiBrasil::class)->send($this->number, $this->message);
    }
}
