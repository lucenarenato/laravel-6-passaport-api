<?php

namespace FederalSt\Events;

use FederalSt\User;
use FederalSt\Vehicle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VehicleLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action;
    public $adminName;
    public $adminEmail;
    public $customer;
    public $vehicle;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action, User $amdin, User $customer, Vehicle $vehicle)
    {
        $this->action       = $action;
        $this->adminName    = $amdin->name;
        $this->adminEmail   = $amdin->email;
        $this->customer     = $customer;
        $this->vehicle      = "{$vehicle->brand} - {$vehicle->model} | Placa {$vehicle->plate}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getSubject()
    {
        return "{$this->action} {$this->vehicle}";
    }

    public function getMessage()
    {
        return "Olá {$this->customer->name}, o admin ({$this->adminName}) {$this->action} seu veículo {$this->vehicle}";
    }
}
