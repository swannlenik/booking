<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Place;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingService
{
    public function getBookings(): Collection {
        return Booking::all()->keyBy('id');
    }

    public function getBookingByTimetableID(int $timetableID): Collection {
        return Booking::where('id_time', '=', $timetableID)->orderBy('booking_time')->orderBY('user')->get();
    }

    public function addBooking(array $data): Booking {
        $booking = new Booking();
        $booking->id_time = $data['id_time'];
        $booking->id_place = $data['id_place'];
        $booking->booking_time = $data['booking_time'];
        $booking->user = $data['user'];
        $booking->email = $data['email'];
        $booking->phone = $data['phone'];
        $booking->save();

        return $booking;
    }

    public function deleteBooking(int $id): void {
        $booking = Booking::find($id);
        $booking->delete();
    }

    public function getSlotsByTimetableID(int $timetableID): Collection {
        $tt = Timetable::find($timetableID);
        $startTime = Carbon::createFromFormat('H:i:s', $tt->start_time);
        $endTime = Carbon::createFromFormat('H:i:s', $tt->end_time);
        $places = Place::all();
        $slots = [];

        while ($startTime < $endTime) {
            $bookingsCount = Booking::where('id_place', '=', $tt->id_place)
                ->where('booking_time', '=', $startTime->format('H:i'))
                ->where('id_time', '=', $tt->id)
                ->count();
            $slots[$startTime->format('H:i')] = $tt->max_user - $bookingsCount;
            $startTime->addMinutes($tt->slot_duration);
        }

        return collect($slots);
    }

    public function getUsersByTimetableIdPlaceIdBookingTime(int $timetableID, int $placeID, string $bookingTime): Collection {
       $users = Booking::where('id_time', '=', $timetableID)
           ->where('id_place', '=', $placeID)
           ->where('booking_time', '=', $bookingTime)
           ->get();
       return $users;

    }
}
