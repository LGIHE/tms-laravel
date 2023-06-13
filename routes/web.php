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
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportsController;

Route::get('optimize', function () {
    $output = Artisan::call('optimize');
    return "<pre>$output</pre>";
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {return redirect('dashboard');});
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
    Route::post('update-user-password/{id}', [UserController::class, 'updatePassword'])->name('update.user.password');
    Route::get('update-user-password-success/{id}', [UserController::class, 'updatePasswordSuccess'])->name('update.user.password.success');

	Route::get('profile', [ProfileController::class, 'get'])->name('profile');
    Route::post('profile', [ProfileController::class, 'updateBio']);
    Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update.password');

    //TRAINEES ROUTES
    Route::get('trainees', [TraineeController::class, 'getTrainees'])->middleware('admin')->name('trainees');
    Route::get('trainee/{id}', [TraineeController::class, 'getTrainee'])->middleware('admin')->name('get.trainee');
    Route::post('create-trainee', [TraineeController::class, 'createTrainee'])->middleware('admin')->name('create.trainee');
    Route::get('create-trainee-success/{id}', [TraineeController::class, 'createTraineeSuccess'])->middleware('admin')->name('create.trainee.success');
    Route::get('delete-trainee/{id}', [TraineeController::class, 'deleteTrainee'])->middleware('admin')->name('delete.trainee');
	Route::post('update-trainee/{id}', [TraineeController::class, 'updateTrainee'])->name('update.trainee');
	Route::get('update-trainee-success/{id}', [TraineeController::class, 'updateTraineeSuccess'])->name('update.trainee.success');

    //LESSON PLAN ROUTES
	Route::get('trainings', [TrainingController::class, 'getAll'])->name('trainings');
	Route::get('training/{id}', [TrainingController::class, 'getTraining'])->name('training');
	Route::get('create-training', [TrainingController::class, 'getCreate'])->name('get.create.training');
	Route::post('training', [TrainingController::class, 'createTraining'])->name('create.training');
    Route::get('create-training-success', [TrainingController::class, 'createTrainingSuccess'])->name('create.training.success');
	Route::get('get-update-training/{id}', [TrainingController::class, 'getUpdateTraining'])->name('get.update.training');
	Route::post('update-training/{id}', [TrainingController::class, 'updateTraining'])->name('update.training');
	Route::get('update-training-success/{id}', [TrainingController::class, 'updateTrainingSuccess'])->name('update.training.success');
	Route::post('delete-training/{id}', [TrainingController::class, 'deleteTraining'])->name('delete.training');

    //TRAINING CENTER ROUTES
	Route::get('training-centers', [TrainingCenterController::class, 'getAll'])->name('training.centers');
    Route::post('create-training-center', [TrainingCenterController::class, 'createTrainingCenter'])->name('create.training.center');
	Route::get('create-training-center-success', [TrainingCenterController::class, 'createTrainingCenterSuccess'])->name('create.training.center.success');
    Route::post('update-training-center/{id}', [TrainingCenterController::class, 'updateTrainingCenter'])->name('update.training.center');
	Route::get('update-training-center-success', [TrainingCenterController::class, 'updateTrainingCenterSuccess'])->name('update.training.center.success');
	Route::get('delete-training-center/{id}', [TrainingCenterController::class, 'deleteTrainingCenter'])->name('delete.training.center');

    //PROJECTS ROUTES
	Route::get('projects', [ProjectController::class, 'getAll'])->name('projects');
	Route::post('project', [ProjectController::class, 'createProject'])->name('create.project');
    Route::get('create-project-success', [ProjectController::class, 'createProjectSuccess'])->name('create.project.success');
    Route::get('delete-project/{id}', [ProjectController::class, 'deleteProject'])->middleware('super.admin')->name('delete.project');
	Route::post('update-project/{id}', [ProjectController::class, 'updateProject'])->name('update.project');
    Route::get('update-project-success', [ProjectController::class, 'updateProjectSuccess'])->name('update.project.success');

    //REPORTS ROUTES
	Route::get('reports', [ReportsController::class, 'index'])->name('reports');

    Route::post('sign-out', [AuthController::class, 'singOut'])->name('logout');
});
