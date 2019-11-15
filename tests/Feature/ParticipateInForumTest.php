<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post( '/threads/1/replies' , []);
     }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->be($user = factory('App\User')->create());

        // And an existing thread
        $thread = factory('App\Thread')->create();

        // When the user adds a reply the thread
        $reply = factory('App\Reply')->make();
        $this->post( $thread->path() . '/replies' , $reply->toArray());

        // Then their reply should be vsible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
