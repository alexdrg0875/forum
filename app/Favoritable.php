<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 11/23/2019
 * Time: 9:16 PM
 */

namespace App;


trait Favoritable
{
    public function favorites()
    {
//        var_dump('querieng');
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->delete();
    }

    public function isFavorited()
    {

//        dd($this->user_id);
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute() // $reply->isFavorited();
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
