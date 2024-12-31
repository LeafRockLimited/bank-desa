<?php

namespace App\Listeners;

use App\BukuBesarTrait;
use App\Events\JurnalCreatedEvent;
use App\LabaRugiTrait;
use App\NeracaTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class JurnalCreatedListener implements ShouldQueue
{
    use BukuBesarTrait, NeracaTrait, LabaRugiTrait;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JurnalCreatedEvent $event): void
    {
        $this->createBukuBesar($event->jurnal);
        $this->createNeracaPeriodic($event->jurnal);
        $this->createLabaRugi($event->jurnal);
        Log::info('Jurnal Created with ID: ');
    }
}
