<?php

use App\Http\Controllers\AdminController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function (Router $router) {
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
