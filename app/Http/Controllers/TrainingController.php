<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\TrainingCenter;

class TrainingController extends Controller
{
    public function getAll(){

        $trainings = Training::join('users', 'trainings.facilitator', '=', 'users.id')
                            ->join('training_centers', 'trainings.training_center', '=', 'training_centers.id')
                            ->select('trainings.*', 'users.name as facilitatorName', 'training_centers.name as trainingCenter')
                            ->orderBy('trainings.created_at', 'asc')
                            ->get();

        return view('training.index', compact('trainings'));
    }
}
