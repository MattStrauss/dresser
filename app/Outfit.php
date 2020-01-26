<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season', 'style', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Articles');
    }
}
