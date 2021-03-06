<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Hash;

class AuthController extends Controller
{

    public function register(Request $request){
        $validateData = $request->validate([
           "name" => "required|max:30",
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $user = new User([
            "name" => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)

        ]);
        $user->save();
        $accessToken = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response([
            'user' =>$user,
            'accessToken'=> $accessToken,
            'message' => 'شما با موفقیت ثبت نام شدید.',

        ], 201);



    }


    public function login(Request $request){
        $validateDate = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if (!auth()->attempt($validateDate)){
            return response(['message' => 'invalid user']);
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        return response([
            'user' => auth()->user(),
            'accessToken' => $accessToken,
            'message' => 'شما با موفقیت وارد شدید.'
        ] , 200);
    }


    public function logout(Request $request){
        $user = Auth::user()->token();
        $user->revoke();
        return 'logged out';
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
