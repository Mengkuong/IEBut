<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserJson;
use App\TraitHelper\IssueTokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    use IssueTokenTrait;

    public function __construct()
    {
        $this->client = DB::table('oauth_clients')
            ->where('name',  '=', 'user')->first();
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password'=> 'required',
        ]);

        $token = $this->issueToken($request,$request->get('email'), 'password');
        $finalToken = json_decode($token);

        if(Auth::guard()->attempt($request->all())){

            return response()->json([
                "data" => new UserJson(auth()->user()),
                "expires_in" => $finalToken->expires_in,
                "access_token" => $finalToken->access_token,
                "refresh_token" => $finalToken->refresh_token,
            ], 200);
        }
        else{
            // $errors['message'] = __(key:'auth.failed');
            return response()->json([
                'message' => 'error',
            ], 400);
        }
    }

}
