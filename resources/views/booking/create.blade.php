@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('My booking') }}</h1>

            @if (!empty($booking))
            <div class="alert alert-success">
                <h2>{{ __($titleText) }}</h2>
                <p>{{ __('You will receive a confirmation email with details and a link to modify/cancel your booking.') }}</p>
                <p>{{ __('Booking reference') }}: {{ $booking->public_id }}</p>
            </div>
            @else
            <div class="alert alert-error">
                <h2>{{ __('Error while creating your booking!') }}</h2>
                <p>{{ __('Please try again and/or contact the Organization Committee to arrange a booking.') }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
