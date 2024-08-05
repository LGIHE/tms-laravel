<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Participants;
use App\Models\Project;
use App\Models\Training;
use App\Imports\Participants\GetParticipantSheet;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantController extends Controller
{
    public function getParticipants(){
        $participants = Participants::all();
        $projects = Project::all();
        $trainings = Training::all();
        $countries = Countries::all();

        return view('participant.index', compact('participants', 'projects',  'trainings','countries'));
    }

    public function getParticipant(){
        $participant = Participants::find(request()->id);

        return view('participant.update', compact('participant'));
    }

    public function createParticipant()
    {
        $attributes = request()->validate([
            'id_no' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'category' => 'required',
            'phone' => 'required',
            'district' => 'required'
        ]);

        $attributes['email'] = request()->email;
        $attributes['education_level'] = request()->education_level;
        $attributes['nationality'] = request()->nationality;
        $attributes['institution'] = request()->institution;
        $attributes['created_by'] = auth()->user()->id;

        Participants::create($attributes);

        return response()->json(['id' => request()->training]);
    }

    public function createParticipantSuccess(){
        return redirect()->route('participants', request()->id)->with('status', 'The participant has been added successfully.');
    }

    public function updateParticipant()
    {
        $attributes = request()->validate([
            'id_no' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'category' => 'required',
            'phone' => 'required',
            'district' => 'required'
        ]);

        $attributes['email'] = request()->email;
        $attributes['education_level'] = request()->education_level;
        $attributes['nationality'] = request()->nationality;
        $attributes['institution'] = request()->institution;
        $attributes['updated_by'] = auth()->user()->id;

        Participants::find(request()->id)->update($attributes);

        return response()->json(['id' => request()->id]);
    }

    public function updateParticipantSuccess(){
        return redirect()->route('participants')->with('status', 'The participant has been updated successfully.');
    }

    public function deleteParticipant(){
        $participant = Participants::find(request()->id);
        $participant->delete();

        return redirect()->route('participants')->with('status', 'The participant has been deleted successfully.');
    }

    public function updateParticipantAttendance(){

        request()->validate([
            'participant_id' => 'required|exists:participants,id',
            'training_id' => 'required|exists:trainings,id',
            'attended_dates' => 'required|string',
        ]);

        $participant = Participants::findOrFail(request()->participant_id);
        $trainingData = [
            'training_id' => request()->training_id,
            'dates' => explode(',', request()->attended_dates),
        ];

        $trainings = json_decode($participant->trainings, true) ?? [];
        $trainings[] = $trainingData;

        $participant->trainings = json_encode($trainings);
        $participant->save();

        return response()->json(['message' => 'Attendance updated successfully.']);
    }

    public function getUploadParticipants(){
        return view('participant.upload');
    }

    public function uploadParticipants()
    {
        // Validate the request to ensure a file is provided and it's an Excel file.
        request()->validate([
            'participants_upload' => 'required|mimes:xlsx,xls|max:1024',
        ]);

        // Get the uploaded file
        $file = request()->file('participants_upload');

        // Check if the file is valid
        if (!$file->isValid()) {
            return redirect()
                ->route('training', request()->training)
                ->withErrors(['participants_upload' => 'Invalid file upload.']);
        }

        // Import the file using the specified import class
        try {
            Excel::import(new GetParticipantSheet, $file);
        } catch (\Exception $e) {
            return redirect()
                ->route('get.upload.participants', request()->training)
                ->withErrors(['participants_upload' => 'Failed to upload participants: ' . $e->getMessage()]);
        }

        // Redirect back to the training route with a success message
        return redirect()
            ->route('participants')
            ->with('status', 'The bulk participant upload is successful.');
    }

}
