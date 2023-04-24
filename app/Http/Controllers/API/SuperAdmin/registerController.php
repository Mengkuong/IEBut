<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class registerController extends Controller
{
    public function signup(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
            'role_id' => 'required',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,

        ]);

        //$user->save();
        if($user->save()){
            return response()->json([
                'message' => 'Admin account created',
                'data'  =>$user

            ], 201);
        }
        else{
            return response()->json([
                'message' => 'error'
            ], 400);
        }

    }
}
