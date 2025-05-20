<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

// Публичные маршруты регистрации/логина
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Выход
    Route::post('/logout', [AuthController::class, 'logout']);

    // Профиль
    Route::get('/profile', [ProfileController::class, 'me']);

    // Записи (общие)
    Route::get('/appointments',              [AppointmentController::class, 'index']);
    Route::post('/appointments',             [AppointmentController::class, 'store']);
    Route::get('/appointments/by-date',      [AppointmentController::class, 'getByDate']);
    Route::patch('/appointments/{id}/attendance', [AppointmentController::class, 'markAttendance']);

    // **Удаление записи**
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);

    // Админ‑функции
    Route::middleware('checkAbility:admin')->group(function () {
        Route::get('/admin/profile', [ProfileController::class, 'me']);

        // Пользователи
        Route::get('/users',           [UserController::class, 'index']);
        Route::post('/users',          [UserController::class, 'store']);
        Route::put('/users/{user}',    [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        // Услуги
        Route::post('/services',            [ServiceController::class, 'store']);
        Route::put('/services/{service}',   [ServiceController::class, 'update']);
        Route::delete('/services/{service}',[ServiceController::class, 'destroy']);

        // Акции
        Route::post('/promotions',               [PromotionController::class, 'store']);
        Route::put('/promotions/{promotion}',    [PromotionController::class, 'update']);
        Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy']);

        // Список клиентов
        Route::get('/admin/clients', [UserController::class, 'getClients']);
    });

    // Маршруты для мастеров
    Route::middleware('checkAbility:master')->group(function () {
        Route::get('/master/appointments', [AppointmentController::class, 'masterAppointments']);
    });
});

// Публичные чтения
Route::get('/services',                   [ServiceController::class, 'index']);
Route::get('/promotions',                 [PromotionController::class, 'index']);
Route::get('/masters',                    [UserController::class, 'getMasters']);
Route::get('/appointments/occupied-slots', [AppointmentController::class, 'occupiedSlots']);
Route::get('/appointments/master-schedule',[AppointmentController::class, 'getMasterSchedule']);


Route::middleware(['auth:sanctum', 'checkAbility:client,master'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'me']);
    Route::patch('/profile', [ProfileController::class, 'update']);
});

