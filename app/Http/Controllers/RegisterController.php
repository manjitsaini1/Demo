<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create() {
        return view('registration');
    }

    public function store(Request $request){
    	//return $request;
    	$validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:50|unique:users',
            'dob' => 'required',
            'gender' => 'required',
            'password' => 'required|min:5'
        ]);
        $emailExists = User::where('email', $request->email)->first();
        //return $emailExists;
        if(!empty($emailExists->email)){
        	return ['code' => 402, 'status' => 'error', 'data' => $emailExists, 'message' => 'Email already exist'];
        }

        	$user_obj = new User;
            $user_obj->name = $request->name;
            $user_obj->email = $request->email;
            $user_obj->dob = $request->dob;
            $user_obj->gender = $request->gender;
            $user_obj->password=  Hash::make($request->password);
            // $user_obj->c_password=  $request->password;
            $user_obj->save();

        return redirect('/registration')->with('success', 'Create new user successfully.');    
    }
}
