@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('homeroute', 'Register') }}
@endsection

@section('meta-description')
Register for Andach Video Game rentals - rent video games for a fixed price per month and buy accessories and games.  
@endsection

@section('title')
Register for Game Rentals | Plans from &pound3.99 per month | Andach Games
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Register with Email</h4>

                    {{ Form::open(['route' => 'register', 'method' => 'POST']) }}

                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm Password:') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>

                        <p><i>In registering, you confirm you agree with the <a href="{{ route('page.show', 'terms-and-conditions') }}">terms and conditions</a> and <a href="{{ route('page.show', 'privacy-policy') }}">privacy policy</a>.</i></p>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                {{ Form::submit('Register', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">...or Register with Social Media</h4>

                    <a class="btn btn-block btn-social btn-facebook" href="/login/facebook/"">
                        <span class="fab fa-facebook"></span> Register with Facebook
                    </a>

                    <a class="btn btn-block btn-social btn-google" href="/login/google/"">
                        <span class="fab fa-google"></span> Register with Google+
                    </a>

                    <p><i>In registering, you confirm you agree with the <a href="{{ route('page.show', 'terms-and-conditions') }}">terms and conditions</a> and <a href="{{ route('page.show', 'privacy-policy') }}">privacy policy</a>.</i></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection