<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TrainingVenue;
use App\Models\Training;
use App\Models\Participants;

class DashboardController extends Controller
{
    public function index()
    {
        $facilitators = User::all()->where('role', 'Facilitator');
        $venues = TrainingVenue::all();
        $trainings = Training::all();
        $participants = Participants::all();
        $projects = Project::all();

        // an admin
        return view('dashboard.admin', compact('facilitators', 'venues', 'trainings', 'participants', 'projects'));
    }

    public static function traineesForTraining($id)
    {
        return Participants::whereJsonContains('trainings', ['training_id' => strval($id)])->count();
    }

    public static function getAttendanceForTraining($training, $startDate, $endDate)
    {
        // Get the total number of days for the training
        // $total_days = Training::find($training)->number_of_days;
        $total_days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;

        // Get all participants for the specified training
        $attendees = Participants::whereJsonContains('trainings', ['training_id' => strval($training)])->get();
        $total_attendees = $attendees->count();

        // Calculate the total number of attendance days
        $actualAttendance = 0;
        foreach ($attendees as $participant) {
            $trainings = json_decode($participant->trainings, true);
            foreach ($trainings as $training_attended) {
                if ($training_attended['training_id'] == $training) {
                    $actualAttendance += count($training_attended['dates']);
                }
            }
        }

        // Calculate the attendance percentage
        $attendance_percentage = $total_attendees != 0 ? ($actualAttendance / ($total_attendees * $total_days)) * 100 : 0;

        return round($attendance_percentage, 0);
    }
    public static function getValueRound($value)
    {
        if ($value <= 0) {
            return 0; // Return 0 for values less than or equal to 0 (if needed)
        } elseif ($value >= 100) {
            return 100; // Return 100 for values greater than or equal to 100
        }

        // Calculate the rounded value to the nearest 10
        return ceil($value / 10) * 10;
    }
}
