<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function stock()
    {
    	return $this->belongsTo('App\Stock', 'stock_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
