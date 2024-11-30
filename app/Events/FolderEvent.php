<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FolderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $fileNames;
    public $groupId;
    public $groupName; 

    public function __construct($message, array $fileNames, $groupId, $groupName)
    {
        $this->message = $message;
        $this->fileNames = $fileNames;
        $this->groupId = $groupId;
        $this->groupName = $groupName;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("group-{$this->groupId}");
    }

    public function broadcastAs()
    {
        return 'folder-event';
    }
}



