<?php

namespace FederalSt\Listeners;

use FederalSt\Events\VehicleLog;
use FederalSt\Notifications\CustomerNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVehicleLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VehicleLog  $event
     * @return void
     */
    public function handle(VehicleLog $event)
    {
        try {
            $event->customer->notify(new CustomerNotification($event->adminName,$event->adminEmail, $event->getSubject(), $event->getMessage()));
        }catch (\Exception $exception) {
            Log::error("Listeners SendEmailVehicleLog" . $exception->getMessage());
        }
    }
}
