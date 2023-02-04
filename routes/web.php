<?php

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Validator;

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

Route::get('/', function () {
    return view('welcome to version 1');
});

/**
 * Proper way of writing the code
 */
Route::group(['middleware' => ['web']], function () {
   Route::get('/task', [TaskController::class, 'index']);               // Show task dashboard
   Route::post('/task', [TaskController::class, 'store']);          // Add new task
   Route::delete('/task/{task}', [TaskController::class, 'destroy']); // Delete task
});