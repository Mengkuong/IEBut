<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Controller
{

    public function index(Request $request){
        $this->authorize('manage-users');
        $query = User::query();
//        $query->where("user_id", auth()->user()->id);
        $query->usersearch($request);
        $user = $query->latest()->paginate(10);
        return response([
            'data' => $user,
            'message' => 'create successfully'
        ]);
    }
    public function show($id){
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('Post not found.');
        }

        return response([
            'data' => $user,
            'message' => 'Post Retrieved Successfully.']);

    }

    public function createUser(Request $request,User $user){
         $this->authorize('manage-users');
         $this->validate($request, [
             'name' => 'required',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|same:confirm-password',
             'sex' =>'required',
             'dob' => 'required',
             'id_card_number' => 'required',
             'address' => 'required',
             'phone_number' => 'required',
             'price_per_share' => 'required',
             'date_buy_share' => 'required',
             'role_id' => 'required',
             'buy_share' => 'required',

    ]);
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    return response([
        'data' => $user,
        'message' => 'created']);

}

    public function updateUser(Request $request,$id){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'sex' =>'required',
            'dob' => 'required',
            'id_card_number' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'price_per_share' => 'required',
            'date_buy_share' => 'required',
            'role_id' => 'required',
            'buy_share' => 'required',

        ]);
        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        return response([
            'data' => $user,
            'message' => 'created']);
    }

}
