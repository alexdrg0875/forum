<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user, $times = 50)
    {
        return $user->activity()
            ->latest()
            ->with('subject')
            ->take($times)
            ->get()
            ->groupBy(function ($activity) {
                    return $activity->created_at->format('Y-m-d');
                }
            );
    }
}

