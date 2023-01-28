<form method="{{ $method }}" action="{{ $route }}">
    <h2>{{ __($textTitle) }}</h2>
    <h3>{{ __('') }}{{ $day }}</h3>
    <div class="form-group row">
        <label for="user" class="col-md-2 col-form-label">{{ __('Pick-up at') }}</label>
        <div class="col-md-10">
            <input type="text" readonly class="form-control-plaintext" id="destination-name" value="{{ $place->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="user" class="col-md-2 col-form-label">{{ __('Date') }}</label>
        <div class="col-md-10">
            <input type="text" readonly class="form-control-plaintext" id="booking-date" value="{{ $day }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="user" class="col-md-2 col-form-label">{{ __('First and last name') }}</label>
        <div class="col-md-10">
            <input type="text" name="user" id="user" value="{{ old('user', $booking->user ?? '') }}" placeholder="{{ __('First and Last name') }}" class="form-control" />
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-md-2 col-form-label">{{ __('Email address') }}</label>
        <div class="col-md-10">
            <input type="email" name="email" id="email" value="{{ old('email', $booking->email ?? '') }}" placeholder="{{ __('Email address') }}" class="form-control" />
        </div>
    </div>
    <div class="form-group row">
        <label for="phone" class="col-md-2 col-form-label">{{ __('Phone number') }}</label>
        <div class="col-md-10">
            <input type="text" name="phone" id="phone" value="{{ old('phone', $booking->phone ?? '') }}" placeholder="{{ __('Phone number') }}" class="form-control" />
        </div>
    </div>
    <div class="form-group row">
        <label for="slot" class="col-md-2 col-form-label">{{ __('Time') }}</label>
        <div class="col-md-10">
            <select name="time" id="slot" class="form-select" onchange="updateTimetableIdAndBookingTime(this)">
                @foreach ($slots as $timetableID => $list)
                    @foreach ($list as $time => $available)
                        @if ($available > 0)
                        <option value="{{ $timetableID }}-{{ $time }}" {{ $timetableID === ($booking->id_time ?? '') && substr(($booking->booking_time ?? ''), 0, 5) === $time ? 'selected="selected"' : '' }}>{{ $time }} - {{ $available }} {{ __('spots left') }}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row col-md-2">
        <input type="hidden" name="id_time" value="{{ $booking->id_time ?? 0 }}" id="timetable-id">
        <input type="hidden" name="booking_time" value="{{ $booking->booking_time ?? 0 }}" id="booking-time">
        <input type="hidden" name="id_place" value="{{ $placeID }}">
        <input type="hidden" name="day" value="{{ $day }}">
        <input type="hidden" name="public_id" value="{{ $booking->public_id ?? '' }}">
        <input type="submit" value="{{ __($textButton) }}" class="btn btn-success" />
    </div>
    @csrf
</form>

<script>
    function updateTimetableIdAndBookingTime(obj) {
        const val = obj.value.split('-');
        document.getElementById('booking-time').value = val[1];
        document.getElementById('timetable-id').value = val[0];
    }
</script>
