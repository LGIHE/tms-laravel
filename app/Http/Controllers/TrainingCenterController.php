<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;

class TrainingCenterController extends Controller
{
    public function getAll(){
        $centers = TrainingCenter::all();

        return view('training-center.index', compact('centers'));
    }

    public function getTrainingCenter(){
        $trainee = TrainingCenter::find(request()->id);

        return view('trainee.update', compact('trainee'));
    }

    public function createTrainingCenter()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|min:10',
            'type' => 'required',
            'capacity' => 'nullable|numeric',
            'contact_phone' => 'required|min:10',
            'contact_person' => 'required',
            'country' => 'required',
            'district' => 'required',
            'city' => 'required',
        ]);

        $attributes['created_by'] = auth()->user()->id;

        $center = TrainingCenter::create($attributes);

        return response()->json(['id' => $center->id]);
    }

    public function createTrainingCenterSuccess(){
        return redirect()->route('training.centers')->with('status', 'The training center has been added successfully.');
    }

    public function updateTrainingCenter()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|min:10',
            'type' => 'required',
            'capacity' => 'nullable|numeric',
            'contact_phone' => 'required|min:10',
            'contact_person' => 'required',
            'country' => 'required',
            'district' => 'required',
            'city' => 'required',
        ]);

        $attributes['updated_by'] = auth()->user()->id;

        $center = TrainingCenter::find(request()->id)->update($attributes);

        return response()->json(['id', request()->id]);
    }

    public function updateTrainingCenterSuccess(){
        return redirect()->route('training.centers')->with('status', 'The training center has been updated successfully.');
    }


    public function deleteTrainingCenter(){
        TrainingCenter::find(request()->id)->delete();

        return redirect()->route('training.centers')->with('status', 'The training center has been deleted successfully.');
    }
}
