<?php

namespace App\Http\Controllers;

use App\Models\Trainee;

class TraineeController extends Controller
{
    public function getTrainees(){
        $trainees = Trainee::all();

        return view('trainee.index', compact('trainees'));
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
            'phone' => 'required|min:10',
            'address' => 'required|max:255',
        ]);

        $attributes['training'] = request()->training;
        $attributes['created_by'] = auth()->user()->id;

        Trainee::create($attributes);

        return redirect()->route('trainees')->with('status', 'The trainee has been added successfully.');
    }

    public function createTraineeSuccess(){
        return redirect()->route('trainees')->with('status', 'The trainee has been added successfully.');
    }

    public function updateTrainee()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required|min:10',
            'address' => 'required|max:255',
        ]);

        $attributes['training'] = request()->training;
        $attributes['updated_by'] = auth()->user()->id;

        Trainee::find(request()->id)->update($attributes);

        return response()->json(['id' => request()->training]);
    }

    public function updateTraineeSuccess(){
        return redirect()->route('training', request()->id)->with('status', 'The trainee has been updated successfully.');
    }

    public function deleteTrainee(){
        Trainee::find(request()->id)->delete();

        return redirect()->route('trainees')->with('status', 'The trainee has been deleted successfully.');
    }
}
