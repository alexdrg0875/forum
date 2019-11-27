<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites']; // add to a global scope to reduce number of sql query

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
