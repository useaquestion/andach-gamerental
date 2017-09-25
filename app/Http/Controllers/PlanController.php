<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index')->with(['plans' => Plan::get()]);
    }

    public function show($id)
    {
    	$plan = Plan::find($id);
      return view('plans.show')->with(['plan' => $plan]);
    }

    public function store(Request $request)
    {
          // get the plan after submitting the form
          $plan = Plan::findOrFail($request->plan);

          // subscribe the user
          if (!$request->user()->subscribed('main')) {
            $request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);

            $request->session()->flash('success', 'You have successfully subscribed to the plan <strong>"'.$plan->name.'"</strong>');
          } else {

            $request->session()->flash('success', 'You have changed to the plan <strong>"'.$plan->name.'"</strong>');
            $request->user()->subscription('main')->swap($plan->braintree_plan);
          }

          // redirect to home after a successful subscription
          return redirect('user/subscription');
    }
}
