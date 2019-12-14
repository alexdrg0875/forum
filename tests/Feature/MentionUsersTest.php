<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */

    public function mentioned_users_in_a_reply_are_notified()
    {
        // Given, we have a user,  JohnDou, how is signed in
        $john = create('App\User', ['name' => 'JohnDoe']);

        $this->signIn($john);

        // And another user JaneDou
        $jane = create('App\User', ['name' => 'JaneDoe']);

        // If we have a thread
        $thread = create('App\Thread');

        // And JohnDou replies and mention @JaneDoe
        $reply = make('App\Reply', [
            'body' => 'Hey @JaneDoe check this out.'
        ]);

        $this->json('post', $thread->path() . '/replies' , $reply->toArray());

        // Then, JaneDou should be notified
        $this->assertCount(1, $jane->notifications);
    }
}

