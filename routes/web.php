<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TrainingVenueController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\GoogleSheetsController; // Add this line

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('update', function(){
    Artisan::call('optimize');
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    return "<pre>Application Settings Updated</pre>";
});

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
    // Route::get('/sheets', [GoogleSheetsController::class, 'getSheetDataFunc'])->name('sheets');

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

    // FACILITATOR ROUTES
    Route::post('add-facilitator', [UserController::class, 'addFacilitator'])->middleware('admin')->name('add.facilitator');

    //TRAINEES ROUTES
    Route::get('trainees', [TraineeController::class, 'getTrainees'])->middleware('admin')->name('trainees');
    Route::get('trainee/{id}', [TraineeController::class, 'getTrainee'])->middleware('admin')->name('get.trainee');
    Route::post('create-trainee', [TraineeController::class, 'createTrainee'])->middleware('admin')->name('create.trainee');
    Route::get('create-trainee-success/{id}', [TraineeController::class, 'createTraineeSuccess'])->middleware('admin')->name('create.trainee.success');
    Route::get('delete-trainee/{id}', [TraineeController::class, 'deleteTrainee'])->middleware('admin')->name('delete.trainee');
	Route::post('update-trainee/{id}', [TraineeController::class, 'updateTrainee'])->name('update.trainee');
	Route::get('update-trainee-success/{id}', [TraineeController::class, 'updateTraineeSuccess'])->name('update.trainee.success');
    Route::get('upload-trainees/{id}', [TraineeController::class, 'getUploadTrainees'])->name('get.upload.trainees');
    Route::post('upload-trainees', [TraineeController::class, 'uploadTrainees'])->name('upload.trainees');

    //PARTICIPANTS ROUTES
    Route::get('participants', [ParticipantController::class, 'getParticipants'])->middleware('admin')->name('participants');
    Route::get('participant/{id}', [ParticipantController::class, 'getParticipant'])->middleware('admin')->name('get.participant');
    Route::post('create-participant', [ParticipantController::class, 'createParticipant'])->middleware('admin')->name('create.participant');
    Route::get('create-participant-success/{id}', [ParticipantController::class, 'createParticipantSuccess'])->middleware('admin')->name('create.participant.success');
    Route::get('delete-participant/{id}', [ParticipantController::class, 'deleteParticipant'])->middleware('admin')->name('delete.participant');
	Route::post('update-participant/{id}', [ParticipantController::class, 'updateParticipant'])->name('update.participant');
	Route::get('update-participant-success/{id}', [ParticipantController::class, 'updateParticipantSuccess'])->name('update.participant.success');
    Route::get('get-upload-participants/{id}', [ParticipantController::class, 'getUploadParticipants'])->name('get.upload.participants');
    Route::post('upload-participants/{id}', [ParticipantController::class, 'uploadParticipants'])->name('upload.participants');
    Route::get('remove-participant/{id}/{training_id}', [ParticipantController::class, 'removeParticipant'])->middleware('admin')->name('remove.participant');

    // ATTENDANCE ROUTES
	Route::post('update-participant-attendance', [ParticipantController::class, 'updateParticipantAttendance'])->name('update.participant.attendance');

    //TRAINING ROUTES
	Route::get('trainings', [TrainingController::class, 'getAll'])->name('trainings');
	Route::get('training/{id}', [TrainingController::class, 'getTraining'])->name('training');
	Route::get('create-training', [TrainingController::class, 'getCreate'])->name('get.create.training');
	Route::post('training', [TrainingController::class, 'createTraining'])->name('create.training');
    Route::get('create-training-success', [TrainingController::class, 'createTrainingSuccess'])->name('create.training.success');
	Route::get('get-update-training/{id}', [TrainingController::class, 'getUpdateTraining'])->name('get.update.training');
	Route::post('update-training/{id}', [TrainingController::class, 'updateTraining'])->name('update.training');
	Route::get('update-training-success/{id}', [TrainingController::class, 'updateTrainingSuccess'])->name('update.training.success');
	Route::post('delete-training/{id}', [TrainingController::class, 'deleteTraining'])->name('delete.training');

    //TRAINING VENUES ROUTES
	Route::get('training-venues', [TrainingVenueController::class, 'getAll'])->name('training.venues');
    Route::post('create-training-venue', [TrainingVenueController::class, 'createTrainingVenue'])->name('create.training.venue');
	Route::get('create-training-venue-success', [TrainingVenueController::class, 'createTrainingVenueSuccess'])->name('create.training.venue.success');
    Route::post('update-training-venue/{id}', [TrainingVenueController::class, 'updateTrainingVenue'])->name('update.training.venue');
	Route::get('update-training-venue-success', [TrainingVenueController::class, 'updateTrainingVenueSuccess'])->name('update.training.venue.success');
	Route::get('delete-training-venue/{id}', [TrainingVenueController::class, 'deleteTrainingVenue'])->name('delete.training.venue');
    Route::post('add-training-venue', [TrainingVenueController::class, 'addTrainingVenue'])->name('add.training.venue');

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
