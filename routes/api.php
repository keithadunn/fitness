<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalorieController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeightController;
use App\Http\Controllers\WorkoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);   
    
    Route::put('/user-profile/update/', [UserController::class, 'update']);
    Route::get('/user-stats', [UserController::class, 'userStats']); 

    Route::get('/chart-weight', [UserController::class, 'userCharts']);

    Route::get('/workouts', [WorkoutController::class, 'index']);
    Route::put('/workouts/{id}', [WorkoutController::class, 'update']);
    Route::delete('/workouts/{id}', [WorkoutController::class, 'destroy']);

    Route::post('/store-workout', [SetController::class, 'store']);
    Route::get('/sets/{id}', [SetController::class, 'show']);
    Route::put('/sets/{id}', [SetController::class, 'update']);

    Route::get('/routines', [RoutineController::class, 'index']);

    Route::get('/calories', [CalorieController::class, 'index']);
    Route::post('/store-calories', [CalorieController::class, 'store']);

    Route::get('/weight', [WeightController::class, 'index']);
    Route::post('/store-weight', [WeightController::class, 'store']);

    Route::get('/exercises', [ExerciseController::class, 'index']);
});
