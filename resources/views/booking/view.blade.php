@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('View booking') }}</h1>
            <a href="{{ route('booking.load') }}" class="btn btn-info">
                {{ __('Back') }}
            </a>

            @if (!empty($booking))
            <div class="col-md-12">
                <ul class="list-group">
                    <li class="list-group-item">{{ __('Booking reference') }}: {{ $booking->public_id }}</li>
                    <li class="list-group-item">{{ __('Destination') }}: {{ $place->name }}</li>
                    <li class="list-group-item">{{ __('Day Booked') }}: {{ $timetable->travel_day }}</li>
                    <li class="list-group-item">{{ __('Time Booked') }}: {{ $booking->booking_time }}</li>
                    <li class="list-group-item">{{ __('User') }}: {{ $booking->user }}</li>
                </ul>
            </div>

            <div class="col-md-12">
                <form method="POST" action="{{ route('booking.delete', ['publicID' => $booking->public_id]) }}">
                    <a href="{{ route('booking.modify', ['publicID' => $booking->public_id]) }}" class="btn btn-info">
                        {{ __('Modify my booking') }}
                    </a>

                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="publicID" value="{{ $booking->public_id }}">
                    <input type="submit" class="btn btn-danger" value="{{ __('Cancel my booking') }}">
                    @csrf
                </form>
            </div>

            @else
            <div class="alert alert-danger">
                {{ __('No booking with this reference exists. Please check!') }}
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
