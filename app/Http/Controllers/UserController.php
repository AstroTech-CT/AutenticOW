<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function Register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'ci' => 'required|unique:users',
            'phone' => 'required',
        ]);

        if ($validation->fails()) {
            return $validation->errors();
        }

        return $this->createUser($request);
    }

    private function createUser($request)
    {
        $user = new User();
        $user->name = $request->post("name");
        $user->email = $request->post("email");
        $user->password = Hash::make($request->post("password"));
        $user->last_name = $request->post("last_name");
        $user->username = $request->post("username");
        $user->ci = $request->post("ci");
        $user->phone = $request->post("phone");
        $user->save();
        return $user; 
    }


    public function Login(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) 
            return redirect("/");
        return redirect("/login")->with("failed",true);
    }

    
    public function ValidateToken(Request $request){
        return auth('api')->user();
    }

    public function Logout(Request $request){
        $request->user()->token()->revoke();
        return ['message' => 'Token Revoked'];
        
        
    }

    
}
