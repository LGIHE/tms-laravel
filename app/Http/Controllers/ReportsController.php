<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Training;
use App\Models\Participants;

class ReportsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $trainings = Training::all();
        $participants = Participants::all();

        return view('reports.index', compact('projects', 'trainings', 'participants'));
    }
}
