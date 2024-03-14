<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request) {
        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:4'
        ]);

        if($validatedData->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'error' => $validatedData->errors(),
            ], 403);
        }

        $user = User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }


    public function login(Request $request) {
        $validatedData = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validatedData->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'error' => $validatedData->errors(),
            ], 401);
        }
    }
}
