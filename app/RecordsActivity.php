<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 11/27/2019
 * Time: 3:26 PM
 */

namespace App;


trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getRecordEvents() as $event) {
            static::$event(function ($model) use ($event){ // listen the record and associate activity
                $model->recordActivity($event);
            });
        }
//        static::created(function ($thread) {
//            $thread->recordActivity('created');
//        });

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getRecordEvents () {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id()
        ]);
    }

    protected function activity () {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}
