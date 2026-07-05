<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiNewsController;
use App\Http\Controllers\Api\ApiAnnouncementController;
use App\Http\Controllers\Api\ApiCounselingController;
use App\Http\Controllers\Api\ApiConferenceController;
use App\Http\Controllers\Api\ApiPanelController;
use App\Http\Controllers\Api\ApiRegistrationController;

/*
|──────────────────────────────────────────────────────────────────────────
| API v1 — هنرستان هزاره صنعت
|──────────────────────────────────────────────────────────────────────────
*/

Route::prefix('v1')->group(function () {

    // ── Auth ─────────────────────────────────────────────
    Route::post('/auth/login', [ApiAuthController::class, 'login']);
    Route::post('/auth/register', [ApiAuthController::class, 'register']);
    Route::post('/auth/forgot-password', [ApiAuthController::class, 'forgotPassword']);

    // ── Public Data ───────────────────────────────────────
    Route::get('/home', [ApiHomeController::class, 'index']);
    Route::get('/sliders', [ApiHomeController::class, 'sliders']);
    Route::get('/stats', [ApiHomeController::class, 'stats']);

    Route::get('/news', [ApiNewsController::class, 'index']);
    Route::get('/news/{slug}', [ApiNewsController::class, 'show']);
    Route::get('/news/field/{field}', [ApiNewsController::class, 'byField']);

    Route::get('/announcements', [ApiAnnouncementController::class, 'index']);
    Route::get('/announcements/{id}', [ApiAnnouncementController::class, 'show']);

    Route::get('/conference', [ApiConferenceController::class, 'index']);
    Route::get('/conference/schedule', [ApiConferenceController::class, 'schedule']);
    Route::get('/conference/results', [ApiConferenceController::class, 'results']);
    Route::post('/conference/register', [ApiConferenceController::class, 'register']);

    Route::get('/fields', function () {
        return response()->json(['data' => [
            ['key' => 'electrical', 'name' => 'برق صنعتی', 'icon' => 'bolt'],
            ['key' => 'mechanical', 'name' => 'تاسیسات مکانیکی', 'icon' => 'settings'],
            ['key' => 'instrumentation', 'name' => 'تعمیرکار ابزار دقیق', 'icon' => 'gauge'],
        ]]);
    });

    // ── Pre-Registration (public) ─────────────────────────
    Route::post('/pre-register', [ApiRegistrationController::class, 'store']);
    Route::get('/pre-register/check/{national_id}', [ApiRegistrationController::class, 'checkStatus']);

    // ── Counseling (public) ───────────────────────────────
    Route::post('/counseling', [ApiCounselingController::class, 'store']);
    Route::post('/counseling/track', [ApiCounselingController::class, 'track']);

    // ── Protected Routes (requires Sanctum token) ─────────
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/auth/logout', [ApiAuthController::class, 'logout']);
        Route::get('/auth/me', [ApiAuthController::class, 'me']);
        Route::put('/auth/profile', [ApiAuthController::class, 'updateProfile']);

        // Student Panel
        Route::get('/panel/dashboard', [ApiPanelController::class, 'dashboard']);
        Route::get('/panel/registration', [ApiPanelController::class, 'registrationStatus']);
        Route::get('/panel/counseling', [ApiPanelController::class, 'myCounseling']);

        // Submit paper (conference)
        Route::post('/conference/submit', [ApiConferenceController::class, 'submitPaper']);
        Route::get('/conference/my-paper', [ApiConferenceController::class, 'myPaper']);

        // Notifications
        Route::get('/notifications', [ApiPanelController::class, 'notifications']);
        Route::post('/notifications/{id}/read', [ApiPanelController::class, 'markRead']);

        // App version check
        Route::get('/app-version', function () {
            return response()->json([
                'version' => '1.0.0',
                'force_update' => false,
                'update_url' => url('/app'),
            ]);
        });
    });

    // ── Fallback ─────────────────────────────────────────
    Route::fallback(function () {
        return response()->json([
            'success' => false,
            'message' => 'مسیر یافت نشد',
        ], 404);
    });
});
