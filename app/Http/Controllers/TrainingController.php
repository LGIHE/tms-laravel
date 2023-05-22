<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Project;
use App\Models\User;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\TrainingCenter;

class TrainingController extends Controller
{
    public function getAll(){
        $trainings = Training::all();
        $facilitators = User::all()->where('role', 'Facilitator');
        $centers = TrainingCenter::all();
        $projects = Project::all();

        return view('training.index', compact('trainings', 'facilitators', 'centers', 'projects'));
    }

    public function getCreate(){
        $facilitators = User::all()->where('role', 'Facilitator');
        $centers = TrainingCenter::all();
        $projects = Project::all();

        return view('training.create', compact('facilitators', 'centers', 'projects'));
    }

    public function createTraining(){

        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'facilitator' => 'required',
            'training_center' => 'required',
            'project' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
        ]);

        $attributes['created_by'] = auth()->user()->id;
        Training::create($attributes);

        return response()->json(['status' => 'success']);
    }

    public function createTrainingSuccess(){
        return redirect()->route('trainings')->with('status', 'The training has been added successfully.');
    }

    public function getTraining(){
        $training = Training::find(request()->id);
        $centers = TrainingCenter::all();
        $projects = Project::all();
        $facilitators = User::all()->where('role', 'Facilitator');
        $trainees = Trainee::all()->where('training', request()->id);
        $countries = Countries::all();

        return view('training.view', compact('training', 'centers', 'projects', 'trainees', 'facilitators', 'countries'));
    }

    public function deleteTraining(){
        Training::find(request()->id)->delete();
        Trainee::all()->where('training', request()->id)->delete();

        return redirect()->route('training')->with('status', 'The training has been deleted successfully.');
    }
}
