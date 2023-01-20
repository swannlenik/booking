@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('New booking') }}</h1>
            <a href="{{ route('start') }}" class="btn btn-info">
                {{ __('Back') }}
            </a>

            <form method="POST" action="{{ route('booking.view.post') }}">
                <div class="form-group row">
                    <label for="public-id" class="col-md-2 col-form-label">{{ __('Booking Public ID') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="public_id" id="public-id" value="" class="form-control" placeholder="{{ __('Public ID') }}" />
                        <small id="public-id-help" class="form-text text-muted">{{ __('It looks like an alpha-numeric string like, for example: "abc23455d32"') }}</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <input type="submit" name="submit" value="{{ __('View my booking') }}" class="btn btn-success" />
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
