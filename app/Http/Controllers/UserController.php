<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredUserMail;
use App\Models\Designation;
use App\Models\User;
use App\Models\Office;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Carbon\Carbon;


class UserController extends Controller
{
    public function addUserPost(Request $request)
    {
        $userRole = Auth::user()->type;

        // Validation rules
        $rules = [
            'designation_id' => 'required|integer|exists:designations,id',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'mobile_no' => 'required|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'type' => 'required|string|max:255',  // Check if office or department is selected
            'office_id' => 'nullable|exists:offices,id', // Added validation for office_id
            'department' => 'nullable|string|max:255', // Added validation for department
        ];

        $validatedData = $request->validate($rules);

        $officeId = null;

        $typeofOffice = $request->input('select_type');

        // If the user is an admin and selects office or department
        if ($userRole === 'admin') {
            if ($typeofOffice === 'office') {
                if (!$request->office_id) {
                    return back()->withErrors(['office' => 'Office field cannot be empty.']);
                }
                $officeId = $request->office_id; // Use the office_id from the dropdown

            } elseif ($typeofOffice ===  'department') {
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
        } elseif(($userRole != 'admin')) {
            // If not admin, use the authenticated user's office_id
            $officeId = Auth::user()->office_id;
        }

        $randomPassword = Str::random(10);
        // Prepare user data
        $userData = [
            'firstname' => ucwords($validatedData['firstname']),
            'lastname' => ucwords($validatedData['lastname']),
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
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if "Remember Me" was selected

        if (Auth::attempt($credentials, $remember)) {

            $user = Auth::user();

            if ($user) {
                $user->timestamps = false;
            
                $user->last_login_at = Carbon::now();
                $user->save();
            
                $user->timestamps = true;
            }

            if ($remember) {
                Cookie::queue('email', $request->email, 43200); 
            } else {
                // Forget cookies if "Remember Me" wasn't selected
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
            }
            if(Auth::user()->type === 'student'){
                if(Auth::user()->created_at->eq(Auth::user()->updated_at)){
                    return redirect()->route('student.dashboard')->with('newUser', "Looks like you haven't changed your password yet. Change it now");
                }else{
                    return redirect()->route('student.dashboard')->with('loginUserSuccessfully', 'You are logged in!');
                }
            }
            if(Auth::user()->type != 'admin'){
                if(Auth::user()->created_at->eq(Auth::user()->updated_at)){
                    return redirect()->intended('dashboard')->with('newUser', "Looks like you haven't changed your password yet. Change it now");
                }else{
                    return redirect()->intended('dashboard')->with('loginUserSuccessfully', 'You are logged in!');
                }
            }
            
            
        }

        return back()->with('status', 'Invalid login credentials')->withInput();
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
    
        if($user->email === $request->email){
            $data = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'mobile_no' => 'required|string|max:15',
                'designation_id' => 'required|exists:designations,id',
            ]);
        }else{
            $data = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'mobile_no' => 'required|string|max:15',
                'designation_id' => 'required|exists:designations,id',
            ]);
        }
    
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

    public function resetUserPassword($user)
    {
        // Generate a password reset token
        $user = User::findOrFail($user);

        // Generate a password reset token
        $token = Password::getRepository()->create($user);

        // Details for the email
        $details = [
            'type' => 'reset',
            'token' => $token,
            'email' => $user->email,
        ];

        // Send the email notification
        Notification::send($user, new SendEmailNotification($details));

        return back()->with('successResetPassword', 'Password reset email sent successfully.');
    }

    public function showResetForm(Request $request)
    {
        return view('users/reset_password', [
            'token' => $request->query('token'),
            'email' => $request->query('email'),
        ])->with('title', 'Reset Password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('successPasswordReset', 'Password reset successfully.')
            : back()->withErrors(['email' => [__($status)]]);
    }

        
    public function searchUser(Request $request)
    {
        $query = User::query();
    
        // Handle search
        if ($request->has('search') && $request->input('search') !== '') {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('firstname', 'LIKE', "%{$searchTerm}%")
                ->orWhere('lastname', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                ->orWhere('mobile_no', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // Paginate the results
        $users = $query->paginate(10);
        $totalUsers = $query->count(); // Total users in the database
    
        // Calculate start and end for display
        $start = ($users->currentPage() - 1) * $users->perPage() + 1;
        $end = min($start + $totalUsers - 1, $totalUsers);
    
        return view('users.users', compact('users', 'totalUsers', 'start', 'end'))->with('title', 'Users');
    }

        
    }
