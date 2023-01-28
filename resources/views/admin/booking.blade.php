@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ __('Booking') }}</h1>

                <div class="col-md-12">
                    <a href="{{ route('admin.bookings', ['timetableID' => $timetable->id]) }}" class="btn btn-info">{{ __('Back to Bookings') }}</a>
                </div>

                <h3>{{ __('Informations') }}</h3>
                <div class="col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item">
                            {{ __('Day') }}: {{ $timetable->travel_day }}
                        </li>
                        <li class="list-group-item">
                            {{ __('Leaving at') }}: {{ $bookingTime }}
                        </li>
                        <li class="list-group-item">
                            {{ __('Pick-up at') }}: <strong>{{ $places[$timetable->id_place]->name }}</strong>
                        </li>
                        <li class="list-group-item">
                            {{ __('Spots available') }}: {{ $timetable->max_user - count($users) }}
                        </li>
                    </ul>
                </div>

                <h3>{{ __('Users') }}</h3>
                <tr class="col-md-12 row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="col-md-1">{{ __('#') }}</th>
                                <th scope="col" class="col-md-4">{{ __('First and Last Name') }}</th>
                                <th scope="col" class="col-md-3">{{ __('Email address') }}</th>
                                <th scope="col" class="col-md-3">{{ __('Phone number') }}</th>
                                @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                                <th scope="col" class="col-md-1">{{ __('Delete') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($users) <= 0)
                            <tr>
                                <td colspan="{{ Auth::user()->role === \App\Models\User::ROLE_ADMIN ? 4 : 3 }}" class="table-warning">
                                    {{ __("No user for this time slot") }}
                                </td>
                            </tr>
                        @endif
                        @foreach ($users as $id => $user)
                            <tr>
                                <td>{{ $id + 1 }}</td>
                                <td>{{ $user->user }}</td>
                                <td>{{ __('Phone') }}: {{ $user->phone }}</td>
                                <td>{{ __('Email') }}: {{ $user->email }}</td>
                                @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                                <td>
                                    <form method="POST" action="{{ route('admin.booking.delete', ['id' => $user->id]) }}">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <input type="hidden" name="timetableID" value="{{ $timetable->id }}">
                                        <input type="hidden" name="placeID" value="{{ $timetable->id_place }}">
                                        <input type="hidden" name="bookingTime" value="{{ $bookingTime }}">
                                        <input type="submit" class="btn btn-danger" value="{{ __('Delete') }}">
                                        @csrf
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN && $enableButton && count($users) < $timetable->max_user )
                <h3>{{ __('New booking') }}</h3>
                <form method="POST" action="{{ route('admin.booking.add') }}">
                    <div class="form-group row">
                        <label for="user" class="col-md-2 col-form-label">{{ __('First and last name') }}</label>
                        <div class="col-md-10">
                            <input type="text" name="user" id="user" value="{{ old('user') }}" placeholder="{{ __('First and Last name') }}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label">{{ __('Email address') }}</label>
                        <div class="col-md-10">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('Email address') }}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-md-2 col-form-label">{{ __('Phone number') }}</label>
                        <div class="col-md-10">
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="{{ __('Phone number') }}" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row col-md-2">
                        <input type="hidden" name="id_time" value="{{ $timetable->id }}">
                        <input type="hidden" name="id_place" value="{{ $timetable->id_place }}">
                        <input type="hidden" name="booking_time" value="{{ $bookingTime }}">
                        <input type="submit" value="{{ __('Book') }}" class="btn btn-success" />
                    </div>
                    @csrf
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection
