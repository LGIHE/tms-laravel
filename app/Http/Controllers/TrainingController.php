<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Project;
use App\Models\User;
use App\Models\Participants;
use App\Models\Training;
use App\Models\TrainingVenue;
use App\Models\Subject;

class TrainingController extends Controller
{
    public function getAll(){
        $trainings = Training::all();
        $facilitators = User::all();
        $venues = TrainingVenue::all();
        $projects = Project::all();

        return view('training.index', compact('trainings', 'facilitators', 'venues', 'projects'));
    }

    public function getCreate(){
        $facilitators = User::all();
        $venues = TrainingVenue::all();
        $projects = Project::all();
        $countries = Countries::all();

        return view('training.create', compact('facilitators', 'venues', 'projects', 'countries'));
    }

    public function createTraining(){

        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'facilitators' => 'required|array',
            'facilitators.*' => 'exists:users,id',
            'training_venue' => 'required|array',
            'training_venue.*' => 'exists:training_venues,id',
            'project' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $attributes['created_by'] = auth()->user()->id;
        $attributes['facilitators'] = json_encode($attributes['facilitators']);
        $attributes['training_venue'] = json_encode($attributes['training_venue']);
        $training = Training::create($attributes);

        return response()->json(['status' => 'success', 'id' => $training->id]);
    }

    public function createTrainingSuccess(){
        return redirect()->route('trainings')->with('status', 'The training has been added successfully.');
    }

    public function getTraining(){
        $id = request()->id;
        $training = Training::find($id);
        $venues = TrainingVenue::all();
        $projects = Project::all();
        $facilitators = User::all();
        $participants = Participants::whereRaw("JSON_CONTAINS(trainings, '{\"training_id\": \"$id\"}', '$')")->get();
        $countries = Countries::all();
        $subjects = Subject:: all();

        return view('training.view', compact('training', 'venues', 'projects', 'participants', 'facilitators', 'countries', 'subjects'));
    }

    public function getUpdateTraining(){
        $training = Training::find(request()->id);
        $venues = TrainingVenue::all();
        $projects = Project::all();
        $facilitators = User::all();
        $participants = Participants::all()->where('training', request()->id);
        $countries = Countries::all();

        $selectedFacilitators = json_decode($training->facilitators, true);
        $selectedTrainingVenues = json_decode($training->training_venue, true);

        return view('training.update', compact('training', 'venues', 'projects', 'participants', 'facilitators', 'countries', 'selectedFacilitators', 'selectedTrainingVenues'));
    }

    public function updateTraining(){

        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'facilitators' => 'required|array',
            'facilitators.*' => 'exists:users,id',
            'training_venue' => 'required|array',
            'training_venue.*' => 'exists:training_venues,id',
            'project' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $attributes['updated_by'] = auth()->user()->id;
        $attributes['facilitators'] = json_encode($attributes['facilitators']);
        $attributes['training_venue'] = json_encode($attributes['training_venue']);
        Training::find(request()->id)->update($attributes);

        return response()->json(['id' => request()->id]);
    }

    public function updateTrainingSuccess(){
        return redirect()->route('training', request()->id)->with('status', 'The training has been updated successfully.');
    }

    public function deleteTraining(){
        Training::find(request()->id)->delete();
        Participants::all()->where('training', request()->id)->delete();

        return redirect()->route('training')->with('status', 'The training has been deleted successfully.');
    }
}
