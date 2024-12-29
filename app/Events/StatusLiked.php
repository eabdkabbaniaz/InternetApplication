<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusLiked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    // تحديد القناة التي سيتم بث الحدث عليها
    public function broadcastOn()
    {
       echo 1111;
   return   new Channel('notifications'); // قناة عامة
        // أو new PrivateChannel('user.' . $userId); لقنوات خاصة
    }

    // (اختياري) تخصيص البيانات المرسلة مع الحدث
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}