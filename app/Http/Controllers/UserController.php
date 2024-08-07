<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;

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

        $user = User::create($attributes);
        $user['pass'] = request()->password;

        Mail::to($user->email)->send(new RegistrationConfirmation($user));

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

    public function addFacilitator()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|min:10',
            'location' => 'max:255',
            'role' => 'required',
            'password' => 'required|min:5|max:255',
        ]);

        $attributes['type'] = $attributes['role'] == 'user';
        $attributes['email_verified_at'] = Carbon::now()->toDateTimeString();

        $facilitator = User::create($attributes);

        return response()->json($facilitator);
    }
}
