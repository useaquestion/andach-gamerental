<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $table = 'systems';

    public function games()
    {
    	return $this->hasMany('App\Game', 'system_id');
    }
}
