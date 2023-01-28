@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>{{ __('Bookings') }}</h1>

                <div class="col-md-12">
                    <a href="{{ route('admin.timetables') }}" class="btn btn-info">{{ __('Back to timetables') }}</a>
                </div>

                <h3>{{ __('Informations') }}</h3>
                <div class="col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item">
                            {{ __('Day') }}: {{ $timetable->travel_day }}
                        </li>
                        <li class="list-group-item">
                            {{ __('From') }}: {{ $timetable->start_time }}
                        </li>
                        <li class="list-group-item">
                            {{ __('To') }}: {{ $timetable->end_time }}
                        </li>
                        <li class="list-group-item">
                            {{ __('Time between each rotation') }}: {{ $timetable->slot_duration }} {{ __('minutes') }}
                        </li>
                        <li class="list-group-item">
                            {{ __('Spots available for each slot') }}: {{ $timetable->max_user }} {{ __('persons') }}
                        </li>
                        <li class="list-group-item">
                            {{ __('Pick-up at') }}: <strong>{{ $places[$timetable->id_place]->name }}</strong>
                        </li>
                    </ul>
                </div>

                <h3>{{ __('Time slots') }}</h3>
                <div class="col-md-12 row">
                    @foreach ($slots as $time => $available)
                        <div class="col-md-3">
                            <a href="{{ route('admin.booking.detail', ['timetableID' => $timetable->id, 'placeID' => $timetable->id_place, 'bookingTime' => $time]) }}" class="btn {{ $available <= 0 ? 'btn-danger' : ($available <= 3 ? 'btn-warning' : 'btn-info') }}">
                                {{ $time }} - {{ $available }} {{ __('available') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
