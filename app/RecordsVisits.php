<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 12/26/2019
 * Time: 12:47 PM
 */

namespace App;


use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;

    }

    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    protected function visitsCacheKey() {
        return "threads.{$this->id}.visits";
    }
}
