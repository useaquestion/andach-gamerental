@extends('template')

@section('content')
	@include('user.menu')
	@if (isset($user))
		{!! Form::model($user, ['route' => ['user.register'], 'method' => 'POST']) !!}
	@else
		{!! Form::open(['route' => 'user.store', 'files' => true]) !!}
	@endif

	<h2>User Registration (Step 2 of 3 - Address)</h2>
	<div class="row">
		{!! Form::label('shipping_address1', 'Address 1:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_address1', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('shipping_address2', 'Address 2:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_address2', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('shipping_address3', 'Address 3:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_address3', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('shipping_town', 'Town/City:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_town', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('shipping_county', 'County:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_county', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="row">
		{!! Form::label('shipping_postcode', 'Postcode:', ['class' => 'col-lg-2 control-label']) !!}
		<div class="col-lg-10">
	    	{!! Form::text('shipping_postcode', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<h2>Marketing Emails</h2>
	<p>{!! Form::checkbox('marketing_subscribe') !!} Please tick the box if you wish to be included in marketing emails (no more than two per week). We will keep you up to date on new games we have in, and/or new services we offer. You can unsubscribe via a one-click link in the footer to any email we send out, or via your members area. </p> 

	<div class="row">
		<div class="col-lg-12">
			{{ Form::submit('Update User Details', ['class' => 'form-control btn btn-primary']) }}
		</div>
	</div>

	{!! Form::close() !!}

@endsection