<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];
    /**
     * Filter the query by a given username.
     *
     * @param $builder
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter a query according by to most popularity threads
     *
     * @return mixed
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = null;

        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);

    }
}
