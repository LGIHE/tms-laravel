<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingCenter;
use App\Models\Training;
use App\Models\Trainee;

class DashboardController extends Controller
{
    public function index()
    {
        $facilitators = User::all()->where('role', 'Facilitator');
        $centers = TrainingCenter::all();
        $trainings = Training::all();
        $trainees = Trainee::all();
        $projects = Project::all();

        // an admin
        return view('dashboard.admin', compact('facilitators', 'centers', 'trainings', 'trainees', 'projects'));

        // if (auth()->user()->isAdmin()) {
        //     $teachers = User::all()->where('role', 'Teacher');
        //     $facilitators = User::all()->where('role', 'Facilitator');
        //     $schools = School::all();
        //     $lessonPlans = lessonPlan::all();
        //     $steps = lessonStep::all();

        //     // an admin
        //     return view('dashboard.admin', compact('teachers', 'facilitators', 'schools', 'lessonPlans', 'steps'));

        // }else{
        //     //a teacher
        //     $teachers = User::all()->where('role', 'Teacher');
        //     $facilitators = User::all()->where('role', 'Facilitator');
        //     $schools = School::all();
        //     $subjects = Subject::all();
        //     $lessonPlans = LessonPlan::all();
        //     $yourLPs = LessonPlan::all()->where('owner', auth()->user()->id);
        //     $yourApprovedLPs = LessonPlan::all()->where('owner', auth()->user()->id)
        //                                 ->where('status', 'approved');
        //     $steps = LessonStep::all();

        //     // an admin
        //     return view('dashboard.teacher', compact('teachers', 'facilitators', 'schools', 'subjects', 'lessonPlans', 'yourLPs', 'yourApprovedLPs', 'steps'));
        // }
    }
}
