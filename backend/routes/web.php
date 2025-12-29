<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Sistema Iglesia API is running', 'status' => 'OK']);
});

// Ruta de fallback para API (opcional, para depuración)
Route::fallback(function () {
    return response()->json(['message' => 'Route not found'], 404);
});
