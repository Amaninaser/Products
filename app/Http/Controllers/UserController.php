<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        return view('registration-form');
    }

    // ----------- [ Form validate ] -----------
    public function store(Request $request)
    {

        $request->validate(
            [
                'name'              =>      'required|string|max:20',
                'email'             =>      'required|email|unique:users,email',
                'password'          =>      'required|alpha_num',
                /* 'phone'             =>  [
                   'required' ,
                   'regex:/^(059|056)\-[0-9]{7}$/',
                ] ,
                'Gender'            =>      'required|in:Male,Female',
                'Brithday'          =>      'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(14)->format('Y-m-d'),*/
            ]
        );

        $User = new User();

        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = $request->post('password');
        /*  $User->phone = $request->input('phone');
        $User->Gender = $request->input('Gender');
        $User->Brithday = $request->input('Brithday');*/

        $User->save();
        return redirect()
            ->route('/user')
            ->with("success", "Success! Registration completed");
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user->profile->first_name;
    }
    public function profile(Request $request, $id)
    {
        $user = User::findOrFile($id);
        $profile = $user->profile()->create([]);
        $profile = new Profile([]);

        $profile->user()->associate($user);
        $profile->save();
        // update profiles set user_id = $user->id wehere id = $profile_id
        $profile->user()->disassociate();
        $profile->save();


    }
}
