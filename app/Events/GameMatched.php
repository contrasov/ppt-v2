<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameMatched implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player1;
    public $player2;
    public $token;

    public function __construct($player1, $player2, $token)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->token = $token;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->player1),
            new PrivateChannel('user.' . $this->player2),
        ];
    }

    public function broadcastAs(): string
    {
        return 'GameMatched';
    }
}
