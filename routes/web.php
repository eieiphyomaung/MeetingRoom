<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// USER controllers
use App\Http\Controllers\RoomController as UserRoomController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserNotificationController;
use App\Http\Controllers\User\BookingController as UserBookingController;

// ADMIN controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\AdminCalendarController;

// Shared CRUD (admin)
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApprovalController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// ----------------------
// USER (auth)
// ----------------------
Route::middleware('auth')->group(function () {

    // User dashboard (this is your main user landing after login)
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [UserDashboardController::class, 'index'])->name('user.dashboard');


    // Rooms (User)
    Route::get('/rooms', [UserRoomController::class, 'index'])->name('rooms.index');

    // Booking create/store (User)
    Route::get('/bookings/create/{room}', [UserBookingController::class, 'create'])
        ->name('user.bookings.create');

    Route::post('/bookings', [UserBookingController::class, 'store'])
        ->name('user.bookings.store');

    // Calendar (User)
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // Notifications (User)
    Route::get('/notifications', [UserNotificationController::class, 'index'])
        ->name('user.notifications');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ----------------------
// ADMIN (auth + admin)
// ----------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Departments CRUD
    Route::resource('departments', DepartmentController::class);

    // Rooms CRUD (ADMIN)
    Route::resource('rooms', AdminRoomController::class);

    // Reservations
    Route::get('/reservations', [AdminReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/cancelled', [AdminReservationController::class, 'cancelled'])
        ->name('reservations.cancelled');

    // Approve/Reject actions
    Route::patch('/reservations/{reservation}/approve', [ApprovalController::class, 'approve'])
        ->name('reservations.approve');

    Route::patch('/reservations/{reservation}/reject', [ApprovalController::class, 'reject'])
        ->name('reservations.reject');

    // Calendar (ADMIN)
    Route::get('/calendar', [AdminCalendarController::class, 'index'])->name('calendar.index');
});

require __DIR__ . '/auth.php';
