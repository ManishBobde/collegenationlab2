<?php

namespace App\Events;

use App\CN\CNUsers\User;
use App\CN\CNUsers\UsersRepository;
use App\Events\Event;
use CN\Users\UserInterface;
use Illuminate\Queue\SerializesModels;
//use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRegistered extends Event
{
    use SerializesModels;

    public $user;
    public $plainTextPasswd;

    /**
     * Create a new event instance.
     *
     * @param UserInterface $user
     */
    public function __construct(User $user,$password)
    {

        $this->user = $user;
        $this->plainTextPasswd = $password;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
