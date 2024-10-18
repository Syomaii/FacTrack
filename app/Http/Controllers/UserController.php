<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredUserMail;
use App\Models\Designation;
use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function addUserPost(Request $request)
    {
        $userRole = auth()->user()->type;

        // Validation rules
        $rules = [
            'designation_id' => 'required|integer|exists:designations,id',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'mobile_no' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'type' => 'required|string|max:255',
            'select_type' => 'required|string',  // Check if office or department is selected
            'office_id' => 'nullable|exists:offices,id', // Added validation for office_id
            'department' => 'nullable|string|max:255', // Added validation for department
        ];

        $validatedData = $request->validate($rules);

        $officeId = null;

        

        // If the user is an admin and selects office or department
        if ($userRole === 'admin') {
            if ($validatedData['select_type'] === 'office') {
                // Validate that office_id is provided
                if (!$request->office_id) {
                    return back()->withErrors(['office' => 'Office field cannot be empty.']);
                }
                $officeId = $request->office_id; // Use the office_id from the dropdown

            } elseif ($validatedData['select_type'] === 'department') {
                // Validate that department is provided
                if (!$request->department) {
                    return back()->withErrors(['department' => 'Department field cannot be empty.']);
                }
                // Find office ID based on department
                $office = Office::find($request->department);
                
                if ($office) {
                    $officeId = $office->id;

                    $existingUserWithSameDesignation = User::where('designation_id', $validatedData['designation_id'])
                                                        ->where('office_id', $officeId)
                                                        ->first();

                    if ($existingUserWithSameDesignation) {
                        return back()->withErrors(['designation' => 'Their is already an existing dean in this department.']);
                    }
                } else {
                    return back()->withErrors(['department' => 'Selected department does not exist.']);
                }
            }   
        } else {
            // If not admin, use the authenticated user's office_id
            $officeId = auth()->user()->office_id;
        }

        $randomPassword = Str::random(10);
        // Prepare user data
        $userData = [
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => bcrypt($randomPassword),
            'mobile_no' => $validatedData['mobile_no'],
            'type' => $validatedData['type'],
            'designation_id' => $validatedData['designation_id'],
            'status' => 'active',
            'office_id' => $officeId, 
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images/users/profile_pictures', 'public');
            $userData['image'] = $imagePath;
        } else {
            $userData['image'] = 'images/profile_pictures/default-profile.png';  
        }

        // Create the user
        $user = User::create($userData);

        Mail::to($validatedData['email'])->send(new RegisteredUserMail($randomPassword, $user));

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
