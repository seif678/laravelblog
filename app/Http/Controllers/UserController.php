<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    function login(Request $Request){
        $incomingdata = $Request->validate([
            'loginemail' =>['required', 'email',],
            'loginpassword' =>['required']
        ]);

        if(auth()->attempt(['email' => $incomingdata['loginemail'], 'password' => $incomingdata['loginpassword']])){
            $Request -> session()->regenerate();
        }
        return redirect("/");
    }


    function logout(){
        auth()->logout();
        return redirect("/");
    }


    function register(Request $Request){
        $incomingdata = $Request->validate([
            'name' => ['required', 'min:3', 'max:10', Rule::unique('users','name')],
            'email' =>['required', 'email', Rule::unique('users','email')],
            'password' => ['required','min:8']
        ]);

        $incomingdata['password'] = bcrypt($incomingdata['password']);
        $user = User::create($incomingdata);
        auth()->login($user);
        return redirect("/");
    }
}
