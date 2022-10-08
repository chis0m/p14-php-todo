<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/', [TaskController::class, 'index']);               // Show task dashboard
    Route::post('/task', [TaskController::class, 'store']);          // Add new task
    Route::delete('/task/{task}', [TaskController::class, 'destroy']); // Delete task
});