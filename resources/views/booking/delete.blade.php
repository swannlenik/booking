@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('My booking') }}</h1>

            <div class="alert alert-danger">
                <h2>{{ __('Booking cancelled!') }}</h2>
                <p>
                    <a class="btn btn-info" href="{{ route('booking.new') }}">
                        {{ __('Create a new booking') }}
                    </a>
                </p>
            </div>
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
