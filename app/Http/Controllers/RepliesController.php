<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * @param $channel_id
     * @param Thread $thread
     * @param Spam $spam
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function store($channel_id, Thread $thread)
    {
        try {
            $this->validateReply();

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

        return $reply->load('owner');
    }

    /**
     * @param Reply $reply
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validateReply();

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);

        resolve(Spam::class)->detect(request('body'));
    }
}
