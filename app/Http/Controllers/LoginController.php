<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    public function index(){
        return view('login');
    }

    public function login(Request $request)
    {
        // return $request;
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);


        $email = $request->email;

       // $password = Hash::make($request->password);
        $password = $request->password;
        $users = User::where('email', $email)->first();
        $id = $users->id;
    
       //$credentials = $request->only('email', 'password');
       if (Auth::attempt(array('email' => $email, 'password' => $password)))
        {

           return response()->json(['success'=>true,'message'=>'success', 'data' => $users]);

        }
        else{
            
            return redirect()->route('login')->with('error', 'Oppes! You have entered invalid credentials');

        }
    }


}
