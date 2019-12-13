<?php

namespace App\Events;

use App\Reply;
use Illuminate\Queue\SerializesModels;


class ThreadHasNewReply
{
    use SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @param Reply $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

}
