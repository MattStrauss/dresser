<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'color', 'size', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function outfits()
    {
        return $this->belongsToMany('App\Outfit');
    }

    public static function getColors()
    {
        return collect([
            'Red', 'Blue', 'Green', 'Black', 'Orange', 'Pink', 'White', 'Purple', 'Yellow', 'Grey',
        ])->sort();
    }

    public static function getSizes()
    {
        return collect([
            'X-Small', 'Small', 'Medium', 'Large', 'X-Large'
        ]);
    }

    public static function getTypes()
    {
        return collect([
            'Shorts', 'Pants', 'Jeans', 'Sweatpants',
            'T-Shirt', 'Sweatshirt', 'Sweater', 'Collared Shirt'
        ]);
    }
}
