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
            $ageLower = $ageUpper - 5; // Adjust based on your age range logic
            $query->whereBetween('age', [$ageLower, $ageUpper]);
        }

        // Apply Category Filter if provided
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category', $category);
        }

        // Use Yajra DataTables to handle server-side processing
        return DataTables::of($query)
            ->addColumn('project_name', function ($participant) {
                // Extract project names from the trainings JSON field
                $trainings = json_decode($participant->trainings, true) ?? [];
                $projectNames = [];

                foreach ($trainings as $training) {
                    if (isset($training['training_id'])) {
                        $trainingRecord = Training::find($training['training_id']);
                        if ($trainingRecord) {
                            $project = Project::find($trainingRecord->project);
                            if ($project) {
                                $projectNames[] = $project->name;
                            }
                        }
                    }
                }

                return implode(', ', array_unique($projectNames));
            })
            ->editColumn('gender', function ($participant) {
                return $participant->gender === 'M' ? 'Male' : 'Female';
            })
            ->addColumn('actions', function ($participant) {
                // Optionally, add action buttons (e.g., View, Edit)
                return '<a href="#" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['actions']) // Allow HTML in the actions column
            ->make(true);
    }

}
