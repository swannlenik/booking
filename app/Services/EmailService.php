<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Place;
use App\Models\Timetable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    protected const CONFIRMATION_TEMPLATE = 'email.confirmation';
    protected const FROM_EMAIL = 'booking@2023nationals.ca';

    public static function sendEmail(Booking $booking, Place $place, Timetable $timetable): void {
        Mail::send(self::CONFIRMATION_TEMPLATE, [
            'destination' => $place->name,
            'bookingTime' => $booking->booking_time,
            'bookingDay' => $timetable->travel_day,
            'viewURL' => route('booking.view', ['publicID' => $booking->public_id]),
        ], function ($message) use ($booking) {
            $message->from(self::FROM_EMAIL, 'Shuttle Service');
            $message->subject('Your booking for a shuttle is confirmed!');
            $message->to($booking->email);
        });
    }
}
