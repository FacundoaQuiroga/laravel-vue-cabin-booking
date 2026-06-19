<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (! Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid credentials',
            'errors' => [
                'email' => ['The provided credentials are incorrect.'],
            ],
        ], 422);
    }

    $request->session()->regenerate();

    return response()->json([
        'user' => $request->user(),
    ]);
});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json([
        'message' => 'Logged out',
    ]);
});