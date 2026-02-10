<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CallSignal implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;


    public $bookingId;
    public $data;

    public function __construct(int $bookingId, array $data)
    {
        $this->bookingId = $bookingId;
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new Channel("call.{$this->bookingId}");
    }

    public function broadcastWith()
    {
        return $this->data;
    }
}





