@extends('template')

@section('content')
	
	<h2>Cart - Payment Information (Step 3 of 4)</h2>

	{!! Form::model(Auth::user(), ['route' => 'product.cart4', 'method', 'POST', 'id' => 'andach-payment-form']) !!}

	@foreach ($fields as $field)
		{{ Form::hidden($field, $request[$field]) }}
	@endforeach
	{{ Form::hidden('nonce', 'nonce', ['id' => 'nonce']) }}
	{{ Form::hidden('total', $prices['total']) }}

	@if (!Auth::check())
		<div class="alert alert-warning">
			You aren't logged in. If you log in, then all your orders will be saved in the same place and it'll be easier if there is any need to return any goods. 
		</div>
	@endif

	<div class="row">
		<div class="col-9">
			<div class="card">
				<div class="card-header">Billing Address</div>
				<div class="card-body">
					<div class="row">
						{!! Form::label('billing_address1', 'Address 1:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('billing_address1', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('billing_address2', 'Address 2:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('billing_address2', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('billing_address3', 'Address 3:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('billing_address3', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('billing_town', 'Town:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('billing_town', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						{!! Form::label('billing_county', 'County:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('billing_county', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<!--
					<div class="row">
						{!! Form::label('billing_postcode', 'Postcode:', ['class' => 'col-lg-2 control-label']) !!}
						<div class="col-lg-10">
					    	{!! Form::text('billing_postcode', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					-->
					<div class="col-2">Postcode:</div>
					<div class="col-10"><div id="postalCode"></div></div>
				</div>
			</div>
		</div>

		<div class="col-3">
			<div class="card">
				<div class="card-header">Order Summary</div>
				<div class="card-body">
					@foreach ($cartLines as $line)
						{!! $line->box_mini !!}
					@endforeach
				</div>
				<div class="card-footer">Price: &pound;{{ $prices['total'] }}</div>
			</div>
		</div>

	</div>
	<div class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-header">Card Details and Information</div>
				<div class="card-body">
					Price: &pound;{{ $prices['total'] }}
					<div class="row">
						<div class="col-2">Card Number:</div>
						<div class="col-10"><div id="card-number"></div></div>
						<div class="col-2">Expiration Date:</div>
						<div class="col-10"><div id="expiration-date"></div></div>
						<div class="col-2">CVV:</div>
						<div class="col-10"><div id="cvv"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">{{ Form::submit('>> Payment Details', ['class' => 'form-control btn btn-success', 'disabled' => 'disabled']) }}</div>	
	</div>

	{!! Form::close() !!}

@endsection

@section('javascript')
	<script src="https://js.braintreegateway.com/web/3.26.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.26.0/js/hosted-fields.min.js"></script>
    <script>
      var form = document.querySelector('#andach-payment-form');
      var submit = document.querySelector('input[type="submit"]');

      braintree.client.create({
        authorization: '{{ Braintree_ClientToken::generate() }}'
      }, function (clientErr, clientInstance) {
        if (clientErr) {
          console.error(clientErr);
          return;
        }

        // This example shows Hosted Fields, but you can also use this
        // client instance to create additional components here, such as
        // PayPal or Data Collector.

        braintree.hostedFields.create({
          client: clientInstance,
          styles: {
            'input': {
              'display': 'block',
              'width': '100%',
              'padding': '.5rem .75rem',
              'font-size': '1rem',
              'line-height': '1.25',
              'color': '#495057',
              'display': 'block',
              'display': 'block',
            },
            'input.invalid': {
              'color': 'red'
            },
            'input.valid': {
              'color': 'green'
            }
          },
          fields: {
            number: {
              selector: '#card-number',
              placeholder: '4111 1111 1111 1111'
            },
            cvv: {
              selector: '#cvv',
              placeholder: '123'
            },
            expirationDate: {
              selector: '#expiration-date',
              placeholder: '10/2019'
            },
            postalCode: {
              selector: '#postalCode',
              placeholder: '{{ Auth::user()->billing_postcode }}'
            }
          }
        }, function (hostedFieldsErr, hostedFieldsInstance) {
          if (hostedFieldsErr) {
            console.error(hostedFieldsErr);
            return;
          }

          submit.removeAttribute('disabled');

          form.addEventListener('submit', function (event) {
            event.preventDefault();

            hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
              if (tokenizeErr) {
                alert('BRAINTREE ERROR: ' + tokenizeErr);
                return;
              }

              // If this was a real integration, this is where you would
              // send the nonce to your server.
              //alert('Got a nonce: ' + payload.nonce);

              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          }, false);
        });
      });
    </script>

@endsection