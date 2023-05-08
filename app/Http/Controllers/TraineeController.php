<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Models\Training;

class TraineeController extends Controller
{
    public function getTrainees(){
        $trainees = Trainee::all();
        $trainings = Training::all();

        return view('trainee.index', compact('trainees', 'trainings'));
    }

    public function getTrainee(){
        $trainee = Trainee::find(request()->id);

        return view('trainee.update', compact('trainee'));
    }

    public function createTrainee()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255|unique:trainees,email',
            'gender' => 'required',
            'age' => 'required',
            'category' => 'required',
            'nationality' => 'required',
            'phone' => 'required|min:10',
            'address' => 'required|max:255',
        ]);

        $attendance = explode(',', request()->attendance);
        $attributes['attendance'] = json_encode($attendance);
        $attributes['training'] = request()->training;
        $attributes['created_by'] = auth()->user()->id;

        Trainee::create($attributes);

        return response()->json(['id' => request()->training]);
    }

    public function createTraineeSuccess(){
        return redirect()->route('training', request()->id)->with('status', 'The trainee has been added successfully.');
    }

    public function updateTrainee()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'required',
            'age' => 'required',
            'category' => 'required',
            'nationality' => 'required',
            'phone' => 'required|min:10',
            'address' => 'required|max:255',
            'attendance' => 'required',
        ]);

        $attributes['attendance'] = json_decode(request()->attendance, true);
        $attributes['training'] = request()->training;
        $attributes['updated_by'] = auth()->user()->id;

        Trainee::find(request()->id)->update($attributes);

        return response()->json(['id' => request()->training]);
    }

    public function updateTraineeSuccess(){
        return redirect()->route('training', request()->id)->with('status', 'The trainee has been updated successfully.');
    }

    public function deleteTrainee(){
        $trainee = Trainee::find(request()->id);
        $trainee->delete();

        return redirect()->route('training', $trainee->training)->with('status', 'The trainee has been deleted successfully.');
    }
}
