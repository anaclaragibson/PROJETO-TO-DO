<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/', function() {
//     return view('home');
// })

Route::middleware(['auth']) -> group(function() {

    Route::get ('/home', [HomeController::class, 'index']) -> middleware('auth') -> name ('home');

    Route::get('/task', [TaskController::class, 'index']) -> name('task.view');

    Route::get('/task/new', [TaskController::class, 'create']) -> middleware('auth') -> name('task.create');

    Route::post('/task/create_action', [TaskController::class, 'create_action']) -> name('task.create_action');

    Route::get('/task/edit', [TaskController::class, 'edit']) -> name('task.edit');

    Route::post('/task/edit_action', [TaskController::class, 'edit_action']) -> name('task.edit_action');

    Route::get('/task/delete', [TaskController::class, 'delete']) -> name('task.delete');

    Route::post('/task/update', [TaskController::class, 'update']) -> name('task.update');

});

Route::get('/login', [AuthController::class, 'index']) -> name('login');

Route::post('/login', [AuthController::class, 'login_action']) -> name('user.login_action');

Route::get('/logout', [AuthController::class, 'logout']) -> name('logout');

Route::get('/register', [AuthController::class, 'register']) -> name('register');

Route::post('/register', [AuthController::class, 'register_action']) -> name('user.register_action');


