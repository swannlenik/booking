@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ __('New booking') }}</h1>
            <a href="{{ route('start') }}" class="btn btn-info">
                {{ __('Back') }}
            </a>

            <form method="POST" action="{{ route('booking.details') }}">
                <div class="form-group row">
                    <label for="destination" class="col-md-2 col-form-label">{{ __('Destination') }}</label>
                    <div class="col-md-10">
                        <select class="form-select" name="destination" id="destination">
                            @foreach($places as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="day" class="col-md-2 col-form-label">{{ __('Day') }}</label>
                    <div class="col-md-10">
                        <input type="date" name="day" id="day" value="{{ date("Y-m-d") }}" class="form-control" placeholder="{{ __('Day') }}" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        <input type="submit" name="submit" value="{{ __('Next') }}" class="btn btn-success" />
                    </div>
                </div>
                @csrf
            </form>
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
