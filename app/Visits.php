<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 12/26/2019
 * Time: 1:56 PM
 */

namespace App;


use Illuminate\Support\Facades\Redis;

/*
 * This class uses when we use Redis for count visits of the thread. Another way use
 *  database field 'visits' in threads table
 */
class Visits
{
    protected $thread;

    /**
     * Visits constructor.
     * @param $id
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    protected function cacheKey() {
        return "threads.{$this->thread->id}.visits";
    }
}
