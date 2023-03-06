<?php

namespace App\Http\Controllers\API\Admin;

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
            'sex' =>'required',
            'dob' => 'required',
            'id_card_number' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'price_per_share' => 'required',
            'date_buy_share' => 'required',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'sex' => $request->sex,
            'dob' =>$request->dob,
            'id_card_number' => $request->id_card_number,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'price_per_share' => $request->price_per_share,
            'date_buy_share' => $request->date_buy_share,

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
