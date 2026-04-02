<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\BookingReportController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\backend\mail\Mail_BoxController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\backend\ScheduleController;
use App\Http\Controllers\backend\SpeakersController;
use App\Http\Controllers\backend\SponsorsController;
use App\Http\Controllers\Backend\SupplierBookingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

// ── Root → redirect to frontend home ─────────────────────────────────────────
Route::get('/', fn() => redirect()->route('frontend.home'));

// ── Public Frontend (no auth required) ───────────────────────────────────────
Route::prefix('')->name('frontend.')->group(function () {
    Route::get('/home',                [FrontendController::class, 'home'])          ->name('home');
    Route::get('/events-list',         [FrontendController::class, 'events'])        ->name('events');
    Route::get('/events-list/{event}', [FrontendController::class, 'eventShow'])     ->name('events.show');
    Route::get('/our-speakers',        [FrontendController::class, 'speakers'])      ->name('speakers');
    Route::get('/our-schedule',        [FrontendController::class, 'schedule'])      ->name('schedule');
    Route::get('/our-sponsors',        [FrontendController::class, 'sponsors'])      ->name('sponsors');
    Route::get('/contact-us',          [FrontendController::class, 'contact'])       ->name('contact');
    Route::post('/contact-us',         [FrontendController::class, 'contactSubmit']) ->name('contact.submit');
});

// ── Guest only ────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])   ->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password',  [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])      ->name('password.email');

    Route::get('/verify-otp',  [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])  ->name('password.otp.verify');
    Route::post('/resend-otp', [ForgotPasswordController::class, 'sendOtp'])    ->name('password.otp.resend');
});

// ── Password Reset ────────────────────────────────────────────────────────────
Route::get('/reset-password',  [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.submit');

// ── Authenticated users ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── Booking (auth required) ───────────────────────────────────────────────
    Route::get('/book-event/{event}',  [FrontendController::class, 'bookingForm']) ->name('frontend.booking.form');
    Route::post('/book-event/{event}', [FrontendController::class, 'bookingStore'])->name('frontend.booking.store');

    // ── Dashboard ─────────────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Profile ───────────────────────────────────────────────────────────────
    Route::get('/profile',         [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/setting_profile', [ProfileController::class, 'index'])->name('setting_profile');
    Route::put('/profile/update',  [ProfileController::class, 'update'])->name('profile.update');

    // ── Mailbox ───────────────────────────────────────────────────────────────
    Route::prefix('mailbox')->name('mailbox.')->group(function () {
        Route::get('/',            [Mail_BoxController::class, 'index'])  ->name('index');
        Route::get('/sent',        [Mail_BoxController::class, 'sent'])   ->name('sent');
        Route::get('/compose',     [Mail_BoxController::class, 'compose'])->name('compose');
        Route::post('/send',       [Mail_BoxController::class, 'send'])   ->name('send');
        Route::post('/{id}/reply', [Mail_BoxController::class, 'reply'])  ->name('reply')  ->where('id', '[0-9]+');
        Route::delete('/{id}',     [Mail_BoxController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
        Route::get('/{id}',        [Mail_BoxController::class, 'show'])   ->name('show')   ->where('id', '[0-9]+');
    });

    // ── Admin only ────────────────────────────────────────────────────────────
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ── Admin + User ──────────────────────────────────────────────────────────
    Route::middleware('role:admin,user')->group(function () {
        Route::resource('events',   EventController::class);
        Route::resource('speakers', SpeakersController::class);
        Route::resource('schedule', ScheduleController::class);
        Route::resource('sponsors', SponsorsController::class);

        Route::post('/sponsors/{id}/link-event',
            [SponsorsController::class, 'linkEvent'])->name('sponsors.linkEvent');
        Route::delete('/sponsors/{sponsorId}/unlink/{eventId}',
            [SponsorsController::class, 'unlinkEvent'])->name('sponsors.unlinkEvent');

        Route::get('reports/booking', [BookingReportController::class, 'index'])
             ->name('reports.booking');
    });

    // ── Admin + User + Supplier ───────────────────────────────────────────────
    Route::middleware('role:admin,user,supplier')->group(function () {
        Route::get('supplier-bookings/tracks-by-event', [SupplierBookingController::class, 'tracksByEvent'])
             ->name('supplier_booking.tracks_by_event');

        Route::resource('supplier_booking', SupplierBookingController::class);
    });

});