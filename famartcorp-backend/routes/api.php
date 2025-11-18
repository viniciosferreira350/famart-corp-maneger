<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\CelularController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\ConsultorController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Whatsapp endpoints
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('whatsapp', [WhatsappController::class, 'index']);
    Route::post('whatsapp', [WhatsappController::class, 'store']);
    Route::get('whatsapp/{id}', [WhatsappController::class, 'show']);
    Route::put('whatsapp/{id}', [WhatsappController::class, 'update']);
    Route::delete('whatsapp/{id}', [WhatsappController::class, 'destroy']);

    // Celular endpoints
    Route::get('celulares', [CelularController::class, 'index']);
    Route::post('celulares', [CelularController::class, 'store']);
    Route::get('celulares/{id}', [CelularController::class, 'show']);
    Route::put('celulares/{id}', [CelularController::class, 'update']);
    Route::delete('celulares/{id}', [CelularController::class, 'destroy']);

    // Equipe endpoints
    Route::get('equipes', [EquipeController::class, 'index']);
    Route::post('equipes', [EquipeController::class, 'store']);
    Route::get('equipes/{id}', [EquipeController::class, 'show']);
    Route::put('equipes/{id}', [EquipeController::class, 'update']);
    Route::delete('equipes/{id}', [EquipeController::class, 'destroy']);

    // Consultor endpoints
    Route::get('consultores', [ConsultorController::class, 'index']);
    Route::post('consultores', [ConsultorController::class, 'store']);
    Route::get('consultores/{id}', [ConsultorController::class, 'show']);
    Route::put('consultores/{id}', [ConsultorController::class, 'update']);
    Route::delete('consultores/{id}', [ConsultorController::class, 'destroy']);
});
