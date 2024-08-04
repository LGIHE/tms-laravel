<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Trainee;
use App\Models\Training;
use App\Imports\GetTraineeSheet;
use Maatwebsite\Excel\Facades\Excel;

class TraineeController extends Controller
{
    public function getTrainees(){
        $trainees = Trainee::all();
        $trainings = Training::all();
        $countries = Countries::all();

        return view('trainee.index', compact('trainees', 'trainings', 'countries'));
    }

    public function getTrainee(){
        $trainee = Trainee::find(request()->id);

        return view('trainee.update', compact('trainee'));
    }

    public function createTrainee()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'gender' => 'required',
            'category' => 'required',
            'days_attended' => 'required',
            'institution' => 'required',
        ]);

        $attributes['email'] = request()->email;
        $attributes['age'] = request()->age;
        $attributes['address'] = request()->address;
        $attributes['nationality'] = request()->nationality;
        $attributes['phone'] = request()->phone;
        $attributes['attendance'] = request()->attendance;
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
            'gender' => 'required',
            'days_attended' => 'required',
            'institution' => 'required',
        ]);

        $attributes['email'] = request()->email;
        $attributes['age'] = request()->age;
        $attributes['address'] = request()->address;
        $attributes['nationality'] = request()->nationality;
        $attributes['phone'] = request()->phone;
        $attributes['attendance'] = request()->attendance;
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

    public function getUploadTrainees(){
        $training = Trainee::find(request()->id);
        return view('trainee.upload', compact('training'));
    }

    public function uploadTrainees()
    {
        // Validate the request to ensure a file is provided and it's an Excel file.
        request()->validate([
            'trainees_upload' => 'required|mimes:xlsx,xls|max:1024',
        ]);

        // Get the uploaded file
        $file = request()->file('trainees_upload');

        // Check if the file is valid
        if (!$file->isValid()) {
            return redirect()
                ->route('training', request()->training)
                ->withErrors(['trainees_upload' => 'Invalid file upload.']);
        }

        // Import the file using the specified import class
        try {
            Excel::import(new GetTraineeSheet, $file);
        } catch (\Exception $e) {
            return redirect()
                ->route('get.upload.trainees', request()->training)
                ->withErrors(['trainees_upload' => 'Failed to upload trainees: ' . $e->getMessage()]);
        }

        // Redirect back to the training route with a success message
        return redirect()
            ->route('training', request()->training)
            ->with('status', 'The bulk trainee upload is successful.');
    }

}
