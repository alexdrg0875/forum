<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    public function store ($threadId, Thread $thread)
    {
        $thread->subscribe();
    }

    public function destroy($threadId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
