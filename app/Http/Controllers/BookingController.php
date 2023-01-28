<?php

namespace App\Http\Controllers;


use App\Models\Booking;
use App\Services\BookingService;
use App\Services\PlaceService;
use App\Services\TimetableService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    protected BookingService $bookingService;
    protected PlaceService $placeService;
    protected TimetableService $timetableService;

    public function __construct(
        BookingService $bookingService,
        PlaceService $placeService,
        TimetableService $timetableService,
    ) {
        $this->bookingService = $bookingService;
        $this->placeService = $placeService;
        $this->timetableService = $timetableService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function new(Request $request): View
    {
        $places = $this->placeService->getPlaces();

        return view('booking.new', [
            'places' => $places,
        ]);
    }

    public function details(Request $request): View
    {
        $method = 'POST';
        $action = route('booking.create');
        $textTitle = 'Create a new booking';
        $textButton = 'Book';

        $placeID = $request->post('destination');
        $day = $request->post('day');
        $timetables = $this->timetableService->getTimetablesByDestinationAndDay($placeID, $day);
        $slots = [];

        foreach ($timetables as $timetable) {
            $slots[$timetable->id] = $this->bookingService->getSlotsByTimetableID($timetable->id);
        }

        return view('booking.details', [
            'method' => $method,
            'route' => $action,
            'textTitle' => $textTitle,
            'textButton' => $textButton,
            'placeID' => $placeID,
            'timetables' => $timetables,
            'slots' => $slots,
            'day' => $day,
            'idTime' => 0,
            'bookingTime' => 0,
            'publicID' => '',
            'place' => $this->placeService->getPlaceByID($placeID),
        ]);
    }

    public function create(Request $request): View {
        $booking = $this->bookingService->addBooking($request->post());
        
        return view('booking.create', [
            'booking' => $booking,
            'titleText' => strlen($request->post('public_id') ?? '') > 0 ? 'Booking updated' : 'Booking created',
        ]);
    }

    public function delete(Request $request, string $publicID) {
        $this->bookingService->deleteBookingByPublicID($publicID);
        return to_route('booking.new');
    }

    public function view(Request $request, string $publicID): View {
        $booking = $this->bookingService->getBookingByPublicID($publicID);
        if (!empty($booking)) {
            $timetable = $this->timetableService->getByID($booking->id_time);
            $place = $this->placeService->getPlaceByID($booking->id_place);
        } else {
            $timetable = null;
            $place = null;
        }

        return view('booking.view', [
            'booking' => $booking,
            'place' => $place,
            'timetable' => $timetable,
        ]);
    }

    public function load(Request $request, string $publicID = ''): View {
        return view('booking.load', [
            'publicID' => $publicID,
        ]);
    }

    public function viewPost(Request $request) {
        return to_route('booking.view', ['publicID' => $request->post('public_id')]);
    }

    public function modify(Request $request, string $publicID): View {
        $method = 'POST';
        $action = route('booking.create');
        $textTitle = 'Modify my booking';
        $textButton = 'Modify';
        $booking = $this->bookingService->getBookingByPublicID($publicID);
        $timetable = $this->timetableService->getByID($booking->id_time);

        $placeID = $booking->id_place;
        $day = $timetable->travel_day;
        $timetables = $this->timetableService->getTimetablesByDestinationAndDay($placeID, $day);
        $slots = [];

        foreach ($timetables as $timetable) {
            $slots[$timetable->id] = $this->bookingService->getSlotsByTimetableID($timetable->id);
        }

        return view('booking.details', [
            'method' => $method,
            'route' => $action,
            'textTitle' => $textTitle,
            'textButton' => $textButton,
            'placeID' => $placeID,
            'timetables' => $timetables,
            'slots' => $slots,
            'day' => $day,
            'idTime' => 0,
            'bookingTime' => 0,
            'publicID' => '',
            'booking' => $booking,
            'place' => $this->placeService->getPlaceByID($placeID),
        ]);
    }
}
