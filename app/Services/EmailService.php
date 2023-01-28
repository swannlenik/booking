<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Place;
use App\Models\Timetable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    protected const CONFIRMATION_TEMPLATE = 'email.confirmation';
    protected const CANCELLATION_TEMPLATE = 'email.cancel';
    protected const FROM_EMAIL = 'booking@2023nationals.ca';

    public const SEND_CONFIRMATION = 'SEND_CONFIRMATION';
    public const SEND_CANCELLATION = 'SEND_CANCELLATION';

    public static function sendConfirmationEmail(Booking $booking, Place $place, Timetable $timetable): void {
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
        Log::info('Send Confirmation Email', [
            'booking' => $booking->toArray(),
            'place' => $place->toArray(),
            'timetable' => $timetable->toArray(),
        ]);
    }

    public static function sendCancellationEmail(Booking $booking): void {
        Mail::send(self::CANCELLATION_TEMPLATE, [
            'newURL' => route('booking.new'),
        ], function ($message) use ($booking) {
            $message->from(self::FROM_EMAIL, 'Shuttle Service');
            $message->subject('Your booking for a shuttle is cancelled!');
            $message->to($booking->email);
        });
        Log::info('Send Cancellation Email', [
            'booking' => $booking->toArray(),
        ]);
    }
}
