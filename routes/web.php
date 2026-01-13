<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// USER
use App\Http\Controllers\RoomController as UserRoomController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserNotificationsController as UserNotificationController;
use App\Http\Controllers\User\BookingController as UserBookingController;

// ADMIN
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\AdminCalendarController;

// ADMIN shared
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApprovalController;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {

    // ✅ USER Dashboard (make this the main)
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [UserDashboardController::class, 'index'])->name('user.dashboard'); // ✅ keeps your layout link working

    // ✅ USER Rooms
    Route::get('/rooms', [UserRoomController::class, 'index'])->name('rooms.index');

    // ✅ USER Bookings
    Route::get('/bookings/create/{room}', [UserBookingController::class, 'create'])
    ->name('user.bookings.create');
    Route::post('/bookings', [UserBookingController::class, 'store'])
    ->name('user.bookings.store');
    // ✅ USER Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // ✅ USER Notifications
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('user.notifications');

    // ✅ Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ✅ Password update route
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('departments', DepartmentController::class);
    Route::resource('rooms', AdminRoomController::class);

    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/cancelled', [AdminReservationController::class, 'cancelled'])->name('reservations.cancelled');

    Route::patch('/reservations/{reservation}/approve', [ApprovalController::class, 'approve'])->name('reservations.approve');
    Route::patch('/reservations/{reservation}/reject', [ApprovalController::class, 'reject'])->name('reservations.reject');

    Route::get('/calendar', [AdminCalendarController::class, 'index'])->name('calendar.index');
});

require __DIR__ . '/auth.php';