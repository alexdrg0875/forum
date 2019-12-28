<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites']; // add to a global scope to reduce number of sql query

    protected $appends = ['favoritesCount', 'isFavorited', 'isBest'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::created(function ($reply) {
           $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
//            if ($reply->isBest()) {           // replace by database level
//                $reply->thread->update(['best_reply_id' => null]);
//            }
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread ()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/\@([\w\-]+)/', $this->body,$matches);

        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body); // Hey @JaneDoeasfadsfads www.regexr.com
    }


    /**
     * @return string
     */
    public function path() {
        return $this->thread->path(). "#reply-{$this->id}";
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
}
