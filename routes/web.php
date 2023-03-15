<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TrainingCenterController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {return redirect('sign-in');});
    // Route::get('sign-up', [RegisterController::class, 'create'])->name('register');
    // Route::post('sign-up', [RegisterController::class, 'store']);
    Route::get('sign-in', [AuthController::class, 'signInGet'])->name('login');
    Route::post('sign-in', [AuthController::class, 'signInPost']);
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::get('verify', function () {return view('auth.verify');})->name('verify');
    Route::get('/reset-password/{token}', function ($token) {return view('auth.reset', ['token' => $token]);})->name('password.reset');
    Route::post('verify', [AuthController::class, 'verifyPasswordReset']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //USER MANAGEMENT
    Route::post('create-user', [UserController::class, 'createUser'])->middleware('super.admin')->name('create.user');
    Route::get('create-user', [UserController::class, 'createUserSuccess'])->middleware('super.admin')->name('create.user.success');
    Route::get('user/{id}', [UserController::class, 'getUser'])->middleware('super.admin')->name('get.user');
    Route::post('user/{id}', [UserController::class, 'updateUser'])->middleware('super.admin')->name('update.user');
    Route::get('user/delete/{id}', [UserController::class, 'deleteUser'])->middleware('super.admin')->name('delete.user');
    Route::get('users', [UserController::class, 'getUsers'])->middleware('admin')->name('users');

	Route::get('profile', [ProfileController::class, 'get'])->name('profile');
    Route::post('profile', [ProfileController::class, 'updateBio']);
    Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update.password');

    //TRAINEES ROUTES
    Route::get('trainees', [TraineeController::class, 'getTrainees'])->middleware('admin')->name('trainees');
    Route::get('trainee/{id}', [TraineeController::class, 'getTrainee'])->middleware('admin')->name('get.trainee');
    Route::post('create-trainee', [TraineeController::class, 'createTrainee'])->middleware('admin')->name('create.trainee');
    Route::get('create-trainee-success', [TraineeController::class, 'createTraineeSuccess'])->middleware('admin')->name('create.trainee.success');
    Route::get('delete-trainee/{id}', [TraineeController::class, 'deleteTrainee'])->middleware('admin')->name('delete.trainee');
	Route::post('update-trainee/{id}', [TraineeController::class, 'updateTrainee'])->name('update.trainee');
	Route::get('update-trainee-success/{id}', [TraineeController::class, 'updateTraineeSuccess'])->name('update.trainee.success');

    //LESSON PLAN ROUTES
	Route::get('trainings', [TrainingController::class, 'getAll'])->name('trainings');
	Route::post('training', [TrainingController::class, 'createTraining'])->name('create.training');

    //TRAINING CENTER ROUTES
	Route::get('training-centers', [TrainingCenterController::class, 'getAll'])->name('training.centers');
    Route::post('create-training-center', [TrainingCenterController::class, 'createTrainingCenter'])->name('create.training.center');
	Route::get('create-training-center-success', [TrainingCenterController::class, 'createTrainingCenterSuccess'])->name('create.training.center.success');
	Route::post('delete-training-center/{id}', [TrainingCenterController::class, 'deleteTrainingCenter'])->name('delete.training.center');

    Route::post('sign-out', [AuthController::class, 'singOut'])->name('logout');
});
