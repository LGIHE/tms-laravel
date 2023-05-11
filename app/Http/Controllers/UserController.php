<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Trainee;
use App\Models\Training;
use App\Models\TrainingCenter;

class UserController extends Controller
{

    public function getUsers(){
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function getUser(){
        $user = User::find(request()->id);

        return view('user.update', compact('user'));
    }

    public function createUser()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|min:10',
            'location' => 'max:255',
            'role' => 'required',
            'password' => 'required|min:5|max:255',
        ]);

        $attributes['type'] = $attributes['role'] == 'Trainee' ? 'trainee' : 'admin';
        $attributes['email_verified_at'] = Carbon::now()->toDateTimeString();

        // return response()->json($attributes);

        User::create($attributes);

        return redirect()->route('users')->with('status', 'The user has been added successfully.');
    }

    public function createUserSuccess(){
        return redirect()->route('users')->with('status', 'The user has been added successfully.');
    }

    public function updateUser(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:10',
            'location' => 'max:255',
            'role' => 'required',
            'school' => 'required|numeric',
            'subject_1' => 'required_if:role,==,Teacher',
            'subject_2' => 'nullable',
            'subject_3' => 'nullable',
        ]);

        #Update the User
        User::find(request()->id)->update($attributes);


        return redirect()->route('get.user', request()->id)->with('status', 'The user has been updated successfully.');

    }

    public function deleteUser(){
        $status = User::find(request()->id)->delete();

        return redirect()->route('users')->with('status', 'The user has been deleted successfully.');
    }

    public function updatePassword()
    {
        $attributes = request()->validate([
            'password' => 'required|min:5|max:255',
        ]);

        $attributes['updated_by'] = auth()->user()->id;

        User::find(request()->id)->update($attributes);

        return response()->json(['id' => request()->id]);
    }

    public function updatePasswordSuccess()
    {
        return redirect()->route('get.user', request()->id)->with('status', 'The user password has been updated successfully.');
    }

}
