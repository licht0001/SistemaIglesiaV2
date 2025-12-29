<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\MinistryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\UserController;

// Rutas públicas de configuración del sitio
Route::get('/settings/landing', [SettingsController::class, 'getLandingSettings']);
Route::post('/prayer-requests', [\App\Http\Controllers\Api\PrayerRequestController::class, 'store']);
Route::get('/events/public', [EventController::class, 'publicIndex']);

// Rutas de autenticación
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
});

// Rutas protegidas con autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::put('/settings', [SettingsController::class, 'update']);
    Route::put('/settings/landing', [SettingsController::class, 'updateLandingSettings']);

    // Miembros
    Route::get('/members/export', [MemberController::class, 'export']);
    Route::apiResource('members', MemberController::class);

    // Transacciones
    Route::get('/transactions/export', [TransactionController::class, 'export']);
    Route::apiResource('transactions', TransactionController::class);

    // Eventos
    Route::apiResource('events', EventController::class);

    // Ministerios
    Route::apiResource('ministries', MinistryController::class);
    Route::post('/ministries/{id}/members/sync', [MinistryController::class, 'syncMembers']);
    Route::post('/ministries/{id}/members', [MinistryController::class, 'attachMember']);
    Route::delete('/ministries/{id}/members/{memberId}', [MinistryController::class, 'detachMember']);

    // Tipos de actividad
    Route::apiResource('activity-types', ActivityTypeController::class)->except(['show']);

    // Usuarios
    Route::apiResource('users', UserController::class);

    // Peticiones de Oración (Admin)
    Route::get('/prayer-requests', [\App\Http\Controllers\Api\PrayerRequestController::class, 'index']);
    Route::put('/prayer-requests/{prayerRequest}', [\App\Http\Controllers\Api\PrayerRequestController::class, 'update']);
    Route::delete('/prayer-requests/{prayerRequest}', [\App\Http\Controllers\Api\PrayerRequestController::class, 'destroy']);
});
