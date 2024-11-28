<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Training;
use App\Models\Participants;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $trainings = Training::all();
        $participants = Participants::all();

        return view('reports.index', compact('projects', 'trainings', 'participants'));
    }

    public function getParticipantsData(Request $request)
    {
        // Start with the Participants query
        $query = Participants::query();

        // Apply Training Filter if provided
        if ($request->filled('training')) {
            $trainingId = $request->input('training');
            $query->whereRaw("JSON_CONTAINS(trainings, JSON_OBJECT('training_id', ?), '$')", [$trainingId]);
        }

        // Apply Project Filter if provided
        if ($request->filled('project')) {
            $projectId = $request->input('project');
            // Retrieve all training IDs associated with the selected project
            $projectTrainings = Training::where('project', $projectId)->pluck('id')->toArray();

            if (!empty($projectTrainings)) {
                // Participants must have at least one of the project's trainings
                $query->where(function ($q) use ($projectTrainings) {
                    foreach ($projectTrainings as $trainingId) {
                        $q->orWhereRaw("JSON_CONTAINS(trainings, JSON_OBJECT('training_id', ?), '$')", [$trainingId]);
                    }
                });
            } else {
                // No trainings associated with the project; no participants should match
                $query->whereRaw('0 = 1');
            }
        }

        // Apply Gender Filter if provided
        if ($request->filled('gender')) {
            $gender = $request->input('gender');
            $query->where('gender', $gender);
        }

        // Apply Age Range Filter if provided
        if ($request->filled('age_range')) {
            $ageUpper = (int)$request->input('age_range');
            $ageLower = $ageUpper < 21 ? 0 : $ageUpper - 5;
            $query->whereBetween('age', [$ageLower, $ageUpper]);
        }

        // Apply Category Filter if provided
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category', $category);
        }

        // Execute the query to get the filtered participants
        $participants = $query->get();

        // Collect all unique training_ids from participants
        $trainingIds = [];
        foreach ($participants as $participant) {
            $trainings = json_decode($participant->trainings, true) ?? [];
            foreach ($trainings as $training) {
                if (isset($training['training_id'])) {
                    $trainingIds[] = (int)$training['training_id'];
                }
            }
        }
        $trainingIds = array_unique($trainingIds);

        // Fetch all relevant trainings in one query
        $trainings = Training::whereIn('id', $trainingIds)->get()->keyBy('id');

        // Collect all unique project_ids from the trainings
        $projectIds = $trainings->pluck('project')->unique()->toArray();

        // Fetch all relevant projects in one query
        $projects = Project::whereIn('id', $projectIds)->get()->keyBy('id');

        // Process participants data
        $participantsData = $participants->map(function ($participant) use ($trainings, $projects) {
            $trainingsData = json_decode($participant->trainings, true) ?? [];
            $trainingNames = [];
            $projectNames = [];

            foreach ($trainingsData as $training) {
                if (isset($training['training_id'])) {
                    $trainingId = (int)$training['training_id'];
                    if ($trainings->has($trainingId)) {
                        $trainingRecord = $trainings->get($trainingId);
                        $trainingNames[] = $trainingRecord->name;

                        $projectId = $trainingRecord->project;
                        if ($projects->has($projectId)) {
                            $projectNames[] = $projects->get($projectId)->name;
                        }
                    }
                }
            }

            return [
                'id_no' => $participant->id_no,
                'name' => $participant->name,
                'gender' => $participant->gender === 'M' ? 'Male' : 'Female',
                'age' => $participant->age,
                'category' => $participant->category,
                'institution' => $participant->institution,
                'phone' => $participant->phone,
                'district' => $participant->district,
                'project_name' => implode(', ', array_unique($projectNames)),
                'training_name' => implode(', ', array_unique($trainingNames)),
                'actions' => '<a href="#" class="btn btn-sm btn-primary">View</a>',
            ];
        });

        // Return the data in DataTables format
        return DataTables::of($participantsData)
            ->rawColumns(['actions']) // Allow HTML in the actions column
            ->make(true);
    }

}
