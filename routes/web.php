<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('start');

Route::prefix('booking')->group(function (Router $router) {
    $router->get('new', [BookingController::class, 'new'])->name('booking.new');
    $router->post('view', [BookingController::class, 'viewPost'])->name('booking.view.post');
    $router->get('view/{publicID?}', [BookingController::class, 'view'])->name('booking.view');
    $router->get('load/{publicID?}', [BookingController::class, 'load'])->name('booking.load');
    $router->post('details', [BookingController::class, 'details'])->name('booking.details');
    $router->post('create', [BookingController::class, 'create'])->name('booking.create');
    $router->get('modify/{publicID}', [BookingController::class, 'modify'])->name('booking.modify');
    $router->delete('delete/{publicID}', [BookingController::class, 'delete'])->name('booking.delete');
});

Route::prefix('admin')->group(function (Router $router) {
    $router->get('/home', [AdminController::class, 'index'])->name('home');
    $router->prefix('places')->group(function(Router $router) {
        $router->get('list', [AdminController::class, 'places'])->name('admin.places');
        $router->post('add', [AdminController::class, 'addPlace'])->name('admin.places.add');
        $router->delete('delete', [AdminController::class, 'deletePlace'])->name('admin.places.delete');
    });
    $router->prefix('timetables')->group(function(Router $router) {
        $router->get('list', [AdminController::class, 'timetables'])->name('admin.timetables');
        $router->post('add', [AdminController::class, 'addTimetable'])->name('admin.timetables.add');
        $router->delete('delete', [AdminController::class, 'deleteTimetable'])->name('admin.timetables.delete');
    });
    $router->prefix('bookings')->group(function(Router $router) {
        $router->get('list/{timetableID}', [AdminController::class, 'bookings'])->name('admin.bookings');
        $router->get('detail/{timetableID}/{placeID}/{bookingTime}', [AdminController::class, 'bookingDetail'])->name('admin.booking.detail');
        $router->post('add', [AdminController::class, 'addBooking'])->name('admin.booking.add');
        $router->delete('delete', [AdminController::class, 'deleteBooking'])->name('admin.booking.delete');
    });
});
