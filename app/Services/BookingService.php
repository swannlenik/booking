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

    public function getBookingByPublicID(string $publicID): ?Booking {
        return Booking::where('public_id', '=', $publicID)->first();
    }

    public function addBooking(array $data): Booking {

        if (!empty($data['public_id']) && $data['public_id'] !== '') {
            $booking = $this->getBookingByPublicID($data['public_id']);
        } else {
            $booking = new Booking();
            $booking->id_place = $data['id_place'];
            $booking->public_id = uniqid();
        }
        $booking->id_time = $data['id_time'];
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

    public function deleteBookingByPublicID(string $publicID): void {
        $booking = Booking::where('public_id', '=', $publicID);
        $booking->delete();
    }

    public function getSlotsByTimetableID(int $timetableID): Collection {
        $tt = Timetable::find($timetableID);
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $tt->travel_day, $tt->start_time), 'CST');
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $tt->travel_day, $tt->end_time), 'CST');
        $slots = [];

        $now = Carbon::now('CST');

        if ($endTime->lessThan($now)) {
            return collect([]);
        }
        while ($startTime < $endTime) {
            if ($now->diffInSeconds($startTime, false) > 0 ||
                $startTime->format('H') > $now->format('H') ||
                ($startTime->format('H') === $now->format('H') &&
                    $startTime->format('i') > $now->format('i'))) {
                $bookingsCount = Booking::where('id_place', '=', $tt->id_place)
                    ->where('booking_time', '=', $startTime->format('H:i'))
                    ->where('id_time', '=', $tt->id)
                    ->count();
                $slots[$startTime->format('H:i')] = $tt->max_user - $bookingsCount;
            }
            $startTime->addMinutes($tt->slot_duration);
        }

        return collect($slots);
    }

    public function getSlotsByTimetableIdAdmin(int $timetableID): Collection {
        $tt = Timetable::find($timetableID);
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $tt->travel_day, $tt->start_time), 'CST');
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $tt->travel_day, $tt->end_time), 'CST');
        $slots = [];

        $now = Carbon::now('CST');

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
