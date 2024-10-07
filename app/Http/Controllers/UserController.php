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
            $image->store(public_path('images/users/profile_pictures'), $image->getClientOriginalName());
            $userData['image'] = 'images/users/profile_pictures' . $image->getClientOriginalName();
        }else {
            // Use a default image if none is uploaded
            $userData['image'] = 'images/profile_pictures/default-profile.png';  // Path to the default image
        }

        if ($userRole === 'admin') {
            $userData['office_id'] = $validatedData['office_id'];
        } else {
            $userData['office_id'] = auth()->user()->office_id;
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $userData['image'] = $imagePath;
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

            return redirect()->intended('/dashboard')->with('loginUserSuccessfully', 'You have successfully loged-in!');
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
        return redirect('users/users')->with('deleteUserSuccessfully', 'Equipment deleted successfully');
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $data = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:15',
            'designation_id' => 'required|exists:designations,id',
        ]);
    
        $user->update($data);
    
        return redirect()->route('profile', ['id' => $id])->with('updateprofilesuccessfully', 'Profile updated successfully');
    }
    
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
    
        $user = User::find($id);
    
        // Verify current password with password_verify
        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
    
        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->save();
    
        return redirect()->route('profile', $id)->with('updateprofilesuccessfully', 'Password changed successfully');
    }
    
}
