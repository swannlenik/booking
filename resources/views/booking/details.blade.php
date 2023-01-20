@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('New booking') }} - {{ __('User details') }}</h1>
            <a href="{{ route('booking.new') }}" class="btn btn-info">
                {{ __('Back') }}
            </a>

            @if (count($slots) > 0)
            @include('booking.partial.bookingForm')
            @else
                <div class="alert alert-warning">
                    {{ __('No slots available for that day. Please try another day') }}
                </div>
                <a href="{{ route('booking.new') }}" class="btn btn-info">
                    {{ __('Back') }}
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
