<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\TrainingVenue;

class TrainingVenueController extends Controller
{
    public function getAll(){
        $venues = TrainingVenue::all();
        $countries = Countries::all();

        return view('training-venue.index', compact('venues', 'countries'));
    }

    public function createTrainingVenue()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'type' => 'required',
            'capacity' => 'nullable|numeric',
            'contact_phone' => 'required|min:10',
            'contact_person' => 'required',
            'country' => 'required',
            'district' => 'required',
            'city' => 'required',
        ]);

        $attributes['created_by'] = auth()->user()->id;

        $venue = TrainingVenue::create($attributes);

        return response()->json(['id' => $venue->id]);
    }

    public function createTrainingVenueSuccess(){
        return redirect()->route('training.venues')->with('status', 'The training venue has been added successfully.');
    }

    public function updateTrainingVenue()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'type' => 'required',
            'capacity' => 'nullable|numeric',
            'contact_phone' => 'required|min:10',
            'contact_person' => 'required',
            'country' => 'required',
            'district' => 'required',
            'city' => 'required',
        ]);

        $attributes['updated_by'] = auth()->user()->id;

        TrainingVenue::find(request()->id)->update($attributes);

        return response()->json(['id', request()->id]);
    }

    public function updateTrainingVenueSuccess(){
        return redirect()->route('training.venues')->with('status', 'The training venue has been updated successfully.');
    }


    public function deleteTrainingVenue(){
        TrainingVenue::find(request()->id)->delete();

        return redirect()->route('training.venues')->with('status', 'The training venue has been deleted successfully.');
    }

    public function addTrainingVenue()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'type' => 'required',
            'capacity' => 'nullable|numeric',
            'contact_phone' => 'required|min:10',
            'contact_person' => 'required',
            'country' => 'required',
            'district' => 'required',
            'city' => 'required',
        ]);

        $attributes['created_by'] = auth()->user()->id;

        $trainingVenue = TrainingVenue::create($attributes);

        return response()->json($trainingVenue);
    }
}
