<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DentalAppointmentController;
use App\Http\Controllers\InsuranceClaimController;
use App\Http\Controllers\InsurancePolicyController;
use App\Http\Controllers\LifestyleProductController;
use App\Http\Controllers\MemberProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Member Profile
    Route::controller(MemberProfileController::class)->prefix('member/profile')->name('member.profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
    });
    
    // Insurance Policies
    Route::controller(InsurancePolicyController::class)->prefix('insurance/policies')->name('insurance.policies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{policy}', 'show')->name('show');
    });
    
    // Insurance Claims
    Route::controller(InsuranceClaimController::class)->prefix('insurance/claims')->name('insurance.claims.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{claim}', 'show')->name('show');
    });
    
    // Lifestyle Products
    Route::controller(LifestyleProductController::class)->prefix('lifestyle/products')->name('lifestyle.products.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{product}', 'show')->name('show');
    });
    
    // Dental Appointments
    Route::controller(DentalAppointmentController::class)->prefix('dental/appointments')->name('dental.appointments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{appointment}', 'show')->name('show');
        Route::patch('/{appointment}', 'update')->name('update');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
