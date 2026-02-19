<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/check-username', function (Request $request) {

    $user = User::where('username', $request->username)->first();
    return response()->json([
        'available' => !$user,
        'error' => $user ? 'Username already taken' : null,
        'message' => $user ? 'Username already taken' : 'Username available'
    ]);
});
