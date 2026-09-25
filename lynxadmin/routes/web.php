<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

// Check if admin is authenticated
Route::get('/check-auth', function () {
    // Debug info
    $sessionId = session()->getId();
    $hasSession = session()->has('_token');
    $authCheck = Auth::check();
    $authUser = Auth::user();

    \Log::info('Auth Check Debug', [
        'session_id' => $sessionId,
        'has_session' => $hasSession,
        'auth_check' => $authCheck,
        'auth_user' => $authUser ? $authUser->toArray() : null,
        'session_data' => session()->all(),
    ]);

    if (Auth::check()) {
        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'debug' => [
                'session_id' => $sessionId,
                'has_session' => $hasSession,
            ]
        ]);
    }

    return response()->json([
        'authenticated' => false,
        'debug' => [
            'session_id' => $sessionId,
            'has_session' => $hasSession,
            'message' => 'No authenticated user found'
        ]
    ], 401);
});

Route::get('/run-livewire-config', function () {
    Artisan::call('livewire:publish --config');
    return 'Livewire config published!';
});

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully.';
});