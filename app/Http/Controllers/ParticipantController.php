<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Participants;
use App\Models\Project;
use App\Models\Subject;
use App\Models\Training;
use App\Imports\Participants\GetParticipantSheet;
use App\Rules\UniqueParticipantIdForTraining;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ParticipantController extends Controller
{
    public function getParticipants(){
        $participants = Participants::all();
        $projects = Project::all();
        $trainings = Training::all();
        $countries = Countries::all();
        $subjects = Subject::all();

        return view('participant.index', compact('participants', 'projects',  'trainings', 'countries', 'subjects'));
    }

    public function getParticipant(){
        $participant = Participants::find(request()->id);

        return view('participant.update', compact('participant'));
    }

    public function createParticipant()
    {
        $attributes = request()->validate([
            'training_id' => 'required',
            'id_no' => [
                'required',
                new UniqueParticipantIdForTraining(request()->training_id, 'id_no'),
            ],
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'category' => 'required',
            'phone' => 'required',
            'district' => 'required',
            'attended_dates' => 'required|string'
        ]);

        $attributes['email'] = request()->email;
        $attributes['education_level'] = request()->education_level;
        $attributes['nationality'] = request()->nationality;
        $attributes['institution'] = request()->institution;
        $attributes['institution_ownership'] = request()->institution_ownership;
        $attributes['subjects'] = json_encode(request()->subjects);

        $trainingData = [
            'training_id' => request()->training_id,
            'dates' => explode(',', request()->attended_dates),
        ];

        // Encode the trainings array to JSON
        $attributes['trainings'] = json_encode([$trainingData]);
        $attributes['created_by'] = auth()->user()->id;

        Participants::create($attributes);

        return response()->json(['id' => request()->training_id]);
    }

    public function createParticipantSuccess(){
        return redirect()->route('participants', request()->id)->with('status', 'The participant has been added successfully.');
    }

    public function updateParticipant()
    {
        $attributes = request()->validate([
            'training_id' => 'required',
            'id_no' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'category' => 'required',
            'phone' => 'required',
            'district' => 'required',
            'attended_dates' => 'required|string',
        ]);

        $attributes['email'] = request()->email;
        $attributes['education_level'] = request()->education_level;
        $attributes['nationality'] = request()->nationality;
        $attributes['institution'] = request()->institution;
        $attributes['institution_ownership'] = request()->institution_ownership;
        $attributes['subjects'] = json_encode(request()->subjects);

        $trainingData = [
            'training_id' => request()->training_id,
            'dates' => explode(',', request()->attended_dates),
        ];

        $attributes['trainings'] = json_encode([$trainingData]);
        $attributes['updated_by'] = auth()->user()->id;

        Participants::find(request()->id)->update($attributes);

        return response()->json(['id' => request()->training_id]);
    }

    public function updateParticipantSuccess(){
        return redirect()->route('participants')->with('status', 'The participant has been updated successfully.');
    }

    public function deleteParticipant(){
        $participant = Participants::find(request()->id);
        $participant->delete();

        return redirect()->route('participants')->with('status', 'The participant has been deleted successfully.');
    }

    public function removeParticipant(){
        $trainingId = request()->training_id;
        $participant = Participants::find(request()->id);

        // Decode the trainings JSON column
        $trainings = json_decode($participant->trainings, true);

        // Filter out the training with the specific training_id
        $updatedTrainings = array_filter($trainings, function ($training) use ($trainingId) {
            return $training['training_id'] !== $trainingId;
        });

        // Reindex array to prevent gaps in the index keys
        $updatedTrainings = array_values($updatedTrainings);

        // Update the participant's trainings column
        $participant->trainings = json_encode($updatedTrainings);

        // Save the changes
        $participant->save();

        return redirect()->route('training', request()->training_id)->with('status', 'The participant has been removed from the training successfully.');
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

        return response()->json(['id' => request()->training_id]);
    }

    public function getUploadParticipants(){
        $training = Training::find(request()->id);
        return view('participant.upload', compact('training'));
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
                ->route('get.upload.participants', request()->id)
                ->withErrors(['participants_upload' => 'Invalid file upload.']);
        }

        // Import the file using the specified import class
        try {
            Excel::import(new GetParticipantSheet, $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return redirect()
                ->route('get.upload.participants', request()->id)
                ->withErrors($errors);
        }

        // Redirect back to the training route with a success message
        return redirect()
            ->route('training', request()->id)
            ->with('status', 'The bulk participant upload is successful.');
    }

    public function getTrainingParticipants()
    {
        $id = request()->id;
        $query = Participants::whereJsonContains('trainings', ['training_id' => $id]);

        return DataTables::of($query)
            ->addColumn('days_attended', function ($participant) use ($id) {
                $daysAttended = 0;
                foreach (json_decode($participant->trainings, true) as $training) {
                    if ($training['training_id'] == $id) {
                        $daysAttended = count($training['dates']);
                    }
                }
                return $daysAttended;
            })
            ->addColumn('actions', function ($participant) {
                $editButton = '<a rel="tooltip" class="btn btn-link p-0 m-0" role="btn"
                                data-bs-toggle="modal"
                                data-bs-target="#updateParticipantModal-' . $participant->id . '">
                                <i class="material-icons" style="font-size:1.4rem;">edit</i>
                                <div class="ripple-container"></div>
                            </a>';

                $deleteButton = '';
                if ($participant->role != 'Administrator') {
                    $deleteButton = '<button type="button" class="btn btn-link p-0 m-0" role="btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#removeModal-' . $participant->id . '"
                                        title="Delete User">
                                        <i class="material-icons" style="font-size:1.4rem;">delete</i>
                                        <div class="ripple-container"></div>
                                    </button>';
                }

                return $editButton . $deleteButton;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

}
