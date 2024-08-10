<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Notification;


class UserController extends Controller
{
    public function addUserPost(Request $request)
    {
        $userRole = auth()->user()->type;

        $rules = [
            'designation_id' => 'required|integer|exists:designations,id',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'mobile_no' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'type' => 'required|string|max:255',
        ];

        if ($userRole === 'admin') {
            $rules['office_id'] = 'required|integer|exists:offices,id';
        }

        $validatedData = $request->validate($rules);

        $userData = [
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), 
            'mobile_no' => $validatedData['mobile_no'],
            'type' => $validatedData['type'],
            'designation_id' => $validatedData['designation_id'],
            'status' => 'active',
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->move(public_path('images/users'), $image->getClientOriginalName());
            $userData['image'] = 'images/users/' . $image->getClientOriginalName();
        }

        if ($userRole === 'admin') {
            $userData['office_id'] = $validatedData['office_id'];
        } else {
            $userData['office_id'] = auth()->user()->office_id;
        }

        $user = User::create($userData);

        // Notification::send($user, new SendEmailNotification($details));

        return redirect('/users')
                        ->with('title', 'Users')
                        ->with('success', 'User Added Successfully!');
    }


    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/');
    }

    public function deleteUser($id){

        User::where('id', $id)->delete();
        return redirect('/users')->with('deleteUserSuccessfully', 'Equipment deleted successfully');
    }
}
