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
            <div class="col-md-12">
                <a href="{{ route('booking.view', ['publicID' => $booking->public_id]) }}" class="btn btn-info">{{ __('View my booking') }}</a>
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

@section('footer')
    <div class="card">
        <div class="card-footer">
            {{ __('For further informations, please contact') }} Murray (204-558-5679) {{ __('or') }} Tasha (204-330-0055)
        </div>
    </div>
@endsection
