<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
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

    public static function getAttendanceForTraining($training, $startDate, $endDate)
    {
        $total_days = Training::find($training)->number_of_days;

        $attendees = Participants::all()->where('training', $training);
        $total_attendees = $attendees->count();
        // $actualAttendance = DB::table('participants')
        //                     ->where('training', $training)
        //                     ->sum('days_attended');
        $actualAttendance = 0;

        // $start = Carbon::parse($startDate);
        // $end = Carbon::parse($endDate);
        // $total_days = $start->diffInDays($end);

        // $actualAttendance = DB::table('trainees')
        //                         ->select(DB::raw('SUM(LENGTH(attendance) - LENGTH(REPLACE(attendance, ",", "")) + 1) AS actual_attendance'))
        //                         ->first()
        //                         ->actual_attendance;

        $attendance_percentage = $total_attendees != 0 ? (($actualAttendance) / ($total_attendees * $total_days)) * 100 : 0;

        return round($attendance_percentage, 0);
    }

    public static function getValueRound($value){
        if($value > 0 && $value < 10){
            return 10;
        }
        else if($value > 10 && $value < 20){
            return 20;
        }
        else if($value > 20 && $value < 30){
            return 30;
        }
        else if($value > 30 && $value < 40){
            return 40;
        }
        else if($value > 40 && $value < 50){
            return 50;
        }
        else if($value > 50 && $value < 60){
            return 60;
        }
        else if($value > 60 && $value < 70){
            return 70;
        }
        else if($value > 70 && $value < 80){
            return 80;
        }
        else if($value > 80 && $value < 90){
            return 90;
        }
        else if($value > 90 && $value < 100){
            return 90;
        }else if($value >= 100){
            return 100;
        }
    }
}
