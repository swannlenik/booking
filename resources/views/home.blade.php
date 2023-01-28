@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('Book a shuttle') }}</h1>
            
            <div class="alert alert-info">
                {{ __('To book a shuttle, you don\'t need an account - Just an email and a phone number.') }}
            </div>

            <a href="{{ route('booking.new') }}" class="btn btn-info">{{ __('New booking') }}</a>
            <a href="{{ route('booking.load') }}" class="btn btn-info">{{ __('Modify/Cancel booking') }}</a>
        </div>
    </div>
</div>
@endsection
