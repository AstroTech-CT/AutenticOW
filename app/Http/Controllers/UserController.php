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
    public function Register(Request $request) {

        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'last_name' => 'required|max:255',
                'username' => 'required|unique:users',
                'ci' => 'required|unique:users',
                'phone' => 'required',
            ]);

            if ($validation->fails()) {
                return $validation->errors();
            }

            $this->createUser($request);
            return response()->json(['message' => 'Registro exitoso'], 201);

        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Error registrando al usuario'], 500);
        }
    }

    private function createUser($request){

        try {
            $user = new User();
            $user->name = $request->post("name");
            $user->email = $request->post("email");
            $user->password = Hash::make($request->post("password"));
            $user->last_name = $request->post('last_name');
            $user->username = $request->post("username");
            $user->cedula = $request->post("ci");
            $user->phone_number = $request->post("phone");
            $user->save();

        } catch (\Exception $e) {

            throw $e;
        }
    }

    public function login(Request $request){

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = $request->user();
                $token = $user->createToken('Personal Access Token')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            return response()->json(['error' => 'Credenciales invalidas'], 401);
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Error en el login'], 500);
        }
    }

    public function getUser(Request $request){

        try {
            return $request->user();
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Error'], 500);
        }
    }

    public function ValidateToken(Request $request){

        try {
            return auth('api')->user();
        } catch (\Exception $e) {
           
            return response()->json(['error' => 'Error validando el token'], 500);
        }
    }

    public function Logout(Request $request){

        try {
            $request->user()->token()->revoke();
            return ['message' => 'Token Revoked'];
        } catch (\Exception $e) {
           
            return response()->json(['error' => 'Error revokando el token'], 500);
        }
    }
}