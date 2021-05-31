<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User; 

class UserController extends Controller
{
    public function create() {
        return view('registration-form');
    }

    // ----------- [ Form validate ] -----------
    public function store(Request $request) {

        $request->validate(
            [
                'name'              =>      'required|string|max:20',
                'email'             =>      'required|email|unique:users,email',
                'password'          =>      'required|alpha_num',
                'phone'             =>      'required|numeric|min:10|regex:/(059)[0-9]{7}/',
                'Gender'            =>      'required|in:Male,Female',
                'Brithday'          =>      'required|date|min:Y(users,Brithday)>14'
            ]
        );

        $User = new User();

        $User->name = $request->name;
        $User->email = $request->email;
        $User->password = $request->post('password');
        $User->phone = $request->input('phone');
        $User->Gender = $request->input('Gender');
        $User->Brithday = $request->input('Brithday');

        $User->save();
        return redirect()
            ->route('/user')
            ->with("success", "Success! Registration completed");
    }
}
