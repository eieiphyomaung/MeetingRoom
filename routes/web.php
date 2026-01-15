<?php

use App\Http\Controllers\Admin\AdminCalendarController;
use App\Http\Controllers\Admin\AdminDashboardController;

// USER Controllers
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DepartmentController;

// ADMIN Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController as UserRoomController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\UserDashboardController;

// SHARED (Admin uses these)
use App\Http\Controllers\User\UserNotificationsController as UserNotificationController;
use Illuminate\Support\Facades\Route;

// MAIN HOME ROUTE ( / ) -> Register Page
Route::get('/', function () {
    return redirect()->route('register');
})->name('home');

// USER ROUTES (must be logged in)
Route::middleware('auth')->group(function () {

    // USER Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // USER Rooms
    Route::get('/rooms', [UserRoomController::class, 'index'])->name('rooms.index');

    // USER Bookings
    Route::get('/bookings/create/{room}', [UserBookingController::class, 'create'])
        ->name('user.bookings.create');

    Route::post('/bookings', [UserBookingController::class, 'store'])
        ->name('user.bookings.store');

    // USER Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // USER Notifications
    Route::get('/notifications', [UserNotificationController::class, 'index'])
        ->name('user.notifications');

    // USER Profile (Edit/Update/Delete)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Password update
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN ROUTES
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ADMIN Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ADMIN Departments (CRUD)
        Route::resource('departments', DepartmentController::class);

        // ADMIN Rooms (CRUD)
        Route::resource('rooms', AdminRoomController::class);

        // ADMIN Reservations
        Route::get('/reservations', [AdminReservationController::class, 'index'])
            ->name('reservations.index');

        Route::get('/reservations/cancelled', [AdminReservationController::class, 'cancelled'])
            ->name('reservations.cancelled');

        // Approve / Reject reservation
        Route::patch('/reservations/{reservation}/approve', [ApprovalController::class, 'approve'])
            ->name('reservations.approve');

        Route::patch('/reservations/{reservation}/reject', [ApprovalController::class, 'reject'])
            ->name('reservations.reject');

        // ADMIN Calendar
        Route::get('/calendar', [AdminCalendarController::class, 'index'])->name('calendar.index');
    });

// AUTH ROUTES (login/register/forgot password/etc)
require __DIR__.'/auth.php';
