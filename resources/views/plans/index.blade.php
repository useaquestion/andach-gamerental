@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'All Game Rental Plans') }}
@endsection

@section('h1')
Video Game Rental Plans from Andach Game Rental
@endsection

@section('title')
Value and Unlimited Video Game Rental Plans | Andach Games
@endsection

@section('meta-description')
Rent video games from Andach Games with plans available from &pound;3.99 per month, with unlimited video game rental at just &pound;9.99 per month. Free postage both ways, no contracts. 
@endsection

@section('content')
<h2>Game Rental Plans</h2>
<p>We have a variety of game rental plans available. They're differentiated by the number of games you can play in a month, and the number of games you can have at one time. </p>
<p>Our priority service is for customers who want to play the latest games, or want to pay a little extra to ensure they have their top choices much more of the time. It's simple. The game allocation script runs once for priority customers, fills up all their choices, then runs for non-priority customers. There's no other difference. </p>
<p>This means that the latest games will likely go to priority customers until they've all had the opportunity to play them and sent them back - at which point everybody can have them. But we don't believe in restricting our games artificially so they're available for everybody if nobody else wants them. </p>

@if (!Auth::check())
<p class="alert alert-warning"><b>You aren't logged in:</b> - You can only subscribe to a plan with an account. Either <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>, then come back here to get subscribed and play your new games within days!</p>
@else
	@if(Auth::user()->isSubscribed())
		<p class="alert alert-warning"><b>You are already subscribed to a plan.</b> Please only pay for a new plan here if you want to switch.</p>
	@else
		<p class="alert alert-success">You are currently logged in as <b>{{ Auth::user()->name }}</b> and are not subscribed to a plan. So don't hesitate!</p>
	@endif
@endif

<h2>Pick a Rental Plan</h2>
<div class="row">
	<div class="col-2">Name</div>
	<div class="col-2"># of Games at a Time</div>
	<div class="col-2"># of Games per Month</div>
	<div class="col-2">Priority?</div>
	<div class="col-2">Price per Month</div>
	<div class="col-2">Buy</div>
</div>


<div class="divzebra">
@foreach ($plans as $plan)
<div class="row">
	<div class="col-2">{{ $plan->name }}</div>
	<div class="col-2">{{ $plan->max_games_simultaneously }}</div>
	<div class="col-2">{{ $plan->max_games_per_month_formatted }}</div>
	<div class="col-2">
		@if ($plan->is_priority)
			<img src="/images/template/tick.svg" height="32px">
		@else
			<img src="/images/template/cross.svg" height="32px">
		@endif
	</div>
	<div class="col-2">&pound;{{ number_format($plan->cost, 2) }}</div>
	<div class="col-2">
		<a href="{{ route('plan.show', $plan->slug) }}">
			<button class="btn btn-success">Choose Plan</button>
		</a>
	</div>
</div>
@endforeach
</div>
@endsection