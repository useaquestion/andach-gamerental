<?php

namespace App;

use App\Category;
use App\Rating;
use App\System;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
	protected $guarded = array();
    protected $table   = 'games';

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function rating()
    {
    	return $this->belongsTo('App\Rating', 'rating_id');
    }

    public function system()
    {
    	return $this->belongsTo('App\System', 'system_id');
    }
}
