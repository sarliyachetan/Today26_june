<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class GuestController extends Controller
{
    public function login()
    {
        return view('auth.login');
    } 
    public function loginPost(Request $request)
    {
        $this->validate($request,[
            'email'    => 'required|email',
			'password' => 'required'
        ]);
        if(\Auth::attempt(['email' => $request->email, 'password'=> $request->password])){
            return redirect('dashboard');
        }else{
           return redirect()->back()->withInput($request->only('email','remember'))->with('error','Invalid email address or password!');
        }
    
    }
}
