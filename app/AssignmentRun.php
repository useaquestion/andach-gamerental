<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentRun extends Model
{
    protected $table = 'assignment_runs';

    public function assign($stock, $user)
    {
        if (!$stock) return false;

    	$create['run_id'] = $this->id;
    	$create['user_id'] = $user->id;
    	$create['stock_id'] = $stock->id;
    	$create['game_id'] = $stock->game->id;

        $user->deleteFromWishlist($stock->game->id, false);
        $user->recordGameAssigned();
        $stock->recordAssigned();

    	return Assignment::create($create);
    }

    public function assignments()
    {
    	return $this->hasMany('App\Assignment', 'run_id');
    }

    //Returns the list of users who need a game assigning to them, whether we're doing the priority search or not. 
    //Priority should be 1 or 0. 
    public function getUsersNeedingAssignment($priority)
    {
        $plans = Plan::where('is_priority', $priority)->pluck('id');
        $subscriptions = Subscription::whereIn('plan_id', $plans)->pluck('user_id');
        $users = User::whereIn('id', $subscriptions)->with(['wishlistGames.stock' => function ($query) {
                $query->where('currently_in_stock', 1);
            }])->get();

        return $users;
    }

    public function makeAssignments()
    {
        $numAssignments = 0;
        $count = 1;
        $return = '';

        foreach (array(1, 0) as $priority)
        {
            do {
                $numAssignmentsThisRound = 0;
                $users = $this->getUsersNeedingAssignment($priority);

                $return .= 'On assignment round #'.$count++.' we were on priority level '.$priority.' and assigned to '.print_r($users->pluck('id'), 1);

                foreach ($users as $user)
                {
                    //Double-check never hurts.
                    if ($user->canReceiveGames())
                    {
                        $stockToAssign = $user->firstAvailableStockItem();

                        if ($this->assign($stockToAssign, $user))
                        {
                            $numAssignments++;
                            $numAssignmentsThisRound++;
                        }
                    }
                }
            } while ($numAssignmentsThisRound > 0);
        }

        //Helpful for debug information. Unnecessary when Unit/Functional Tests work. 
        //session()->flash('info', $return);

    	return $numAssignments;
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
