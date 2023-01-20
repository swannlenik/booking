@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>{{ __('Timetables') }}</h1>

                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="col-md-1">{{ __('ID') }}</th>
                        <th scope="col" class="col-md-1">{{ __('Day') }}</th>
                        <th scope="col" class="col-md-4">{{ __('Direction') }}</th>
                        <th scope="col" class="col-md-2">{{ __('Slot duration') }} ({{ __('in minutes') }})</th>
                        <th scope="col" class="col-md-1">{{ __('Max users') }}</th>
                        <th scope="col" class="col-md-1">{{ __('Start time') }}</th>
                        <th scope="col" class="col-md-1">{{ __('End time') }}</th>
                        @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                        <th scope="col" class="col-md-1">{{ __('Delete') }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($timetables as $timetable)
                        <tr>
                            <td>
                                <a href="{{ route('admin.bookings', ['timetableID' => $timetable->id]) }}" class="btn btn-success">
                                    {{ $timetable->id }}
                                </a>
                            </td>
                            <td>{{ $timetable->day }}</td>
                            <td>{{ $places[$timetable->id_place]->name }}</td>
                            <td>{{ $timetable->slot_duration }}</td>
                            <td>{{ $timetable->max_user }}</td>
                            <td>{{ $timetable->start_time }}</td>
                            <td>{{ $timetable->end_time }}</td>
                            @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                            <td>
                                <form method="POST" action="{{ route('admin.timetables.delete', ['id' => $timetable->id]) }}">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <input type="submit" class="btn btn-danger" value="{{ __('Delete') }}">
                                    @csrf
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach

                    @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                    <tr>
                        <form method="POST" action="{{ route('admin.timetables.add') }}">
                            <td></td>
                            <td>
                                <input type="date" name="day" value="{{ old('day', date('Y-m-d')) }}" placeholder="{{ __('Day') }}" class="day-timetable form-control @error('day') is-invalid @enderror"/>
                            </td>
                            <td>
                                <select name="id_place" class="form-select">
                                    @foreach ($places as $place)
                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="slot_duration" value="{{ old('slot_duration', '30') }}" placeholder="{{ __('slot_duration in minutes') }}" class="form-control @error('slot_duration') is-invalid @enderror"/>
                            </td>
                            <td>
                                <input type="text" name="max_user" value="{{ old('max_user', '12') }}" placeholder="{{ __('Maximum number of users/slot') }}" class="form-control @error('max_user') is-invalid @enderror"/>
                            </td>
                            <td>
                                <input type="time" name="start_time" value="{{ old('start_time', '08:00') }}" placeholder="{{ __('Start time') }}" class="form-control @error('start_time') is-invalid @enderror"/>
                            </td>
                            <td>
                                <input type="time" name="end_time" value="{{ old('end_time', '18:00') }}" placeholder="{{ __('End time') }}" class="form-control @error('end_time') is-invalid @enderror"/>
                            </td>
                            <td>
                                <input type="submit" name="submit" value="{{ __('Add') }}" class="btn btn-success" />
                            </td>
                            @csrf
                        </form>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
