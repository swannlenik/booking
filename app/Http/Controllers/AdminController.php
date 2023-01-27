<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\BookingService;
use App\Services\PlaceService;
use App\Services\TimetableService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected BookingService $bookingService;
    protected PlaceService $placeService;
    protected TimetableService $timetableService;
    protected UserService $userService;

    public function __construct(
        BookingService $bookingService,
        PlaceService $placeService,
        TimetableService $timetableService,
        UserService $userService,
    )
    {
        $this->middleware('auth');

        $this->bookingService = $bookingService;
        $this->placeService = $placeService;
        $this->timetableService = $timetableService;
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.home');
    }

    public function places(): View {
        $places = $this->placeService->getPlaces();

        return view('admin.places', [
            'places' => $places,
        ]);
    }

    public function addPlace(Request $request) {
        $this->placeService->addPlace($request->all());
        return to_route('admin.places');
    }

    public function deletePlace(Request $request) {
        $this->placeService->deletePlace($request->input('id'));
        return to_route('admin.places');
    }

    protected function getPlaceValidators(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ];
    }

    public function timetables(): View {
        $timetables = $this->timetableService->getTimetables();
        $places = $this->placeService->getPlaces();

        return view('admin.timetables', [
            'timetables' => $timetables,
            'places' => $places,
        ]);
    }

    public function addTimetable(Request $request) {
        $this->timetableService->addTimetable($request->all());
        return to_route('admin.timetables');
    }

    public function deleteTimetable(Request $request) {
        $this->timetableService->deleteTimetable($request->input('id'));
        return to_route('admin.timetables');
    }

    protected function getTimetableValidators(): array
    {
        return [
            'travel_day' => ['required', 'date', 'date_format:Y-m-d'],
            'slot_duration' => ['required', 'numeric', 'min:15', 'max:60'],
            'max_user' => ['required', 'numeric', 'min:3'],
            'start_time' => ['required', 'date', 'date_format:H:i'],
            'end_time' => ['required', 'date', 'date_format:H:i'],
        ];
    }

    public function bookings(Request $request, int $timetableID): View {
        $bookings = $this->bookingService->getBookingByTimetableID($timetableID);
        $places = $this->placeService->getPlaces();
        $timetable = $this->timetableService->getByID($timetableID);
        $slots = $this->bookingService->getSlotsByTimetableIdAdmin($timetableID);

        return view('admin.bookings', [
            'bookings' => $bookings,
            'places' => $places,
            'timetable' => $timetable,
            'slots' => $slots,
        ]);
    }

    public function bookingDetail(Request $request, int $timetableID, int $placeID, string $bookingTime): View {
        $users = $this->bookingService->getUsersByTimetableIdPlaceIdBookingTime($timetableID, $placeID, $bookingTime);
        $places = $this->placeService->getPlaces();
        $timetable = $this->timetableService->getByID($timetableID);
        $time = Carbon::createFromFormat('Y-m-d H:i', sprintf('%s %s', $timetable->travel_day, $bookingTime), 'CST');

        return view('admin.booking', [
            'bookingTime' => $bookingTime,
            'places' => $places,
            'timetable' => $timetable,
            'users' => $users,
            'enableButton' => $time->greaterThan(Carbon::now()),
        ]);
    }

    public function addBooking(Request $request) {
        $this->bookingService->addBooking($request->all());
        return to_route('admin.booking.detail', [
            'timetableID' => $request->input('id_time'),
            'placeID' => $request->input('id_place'),
            'bookingTime' => $request->input('booking_time'),
        ]);
    }

    public function deleteBooking(Request $request) {
        $this->bookingService->deleteBooking($request->input('id'));
        return to_route('admin.booking.detail', [
            'timetableID' => $request->input('timetableID'),
            'placeID' => $request->input('placeID'),
            'bookingTime' => $request->input('bookingTime'),
        ]);
    }

    protected function getBookingValidators(): array
    {
        return [
            'id_time' => ['required', 'numeric'],
            'id_place' => ['required', 'numeric'],
            'booking_time' => ['required', 'date', 'date_format:H:i'],
            'user' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'min:10'],
        ];
    }

    protected function isAdmin(): bool {
        return Auth::user()->role === User::ROLE_ADMIN;
    }
}
