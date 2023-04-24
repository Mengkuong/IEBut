<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\deposit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function balance()
    {
        $this->authorize('transfer-user');
        $user = Auth::user();

        if(!is_null($user)){
            try{
                $currentBalance = deposit::select('current_balance')
                    ->where('sent_to', $user['id'])
                    ->orderby('id', 'desc')
                    ->get()
                    ->first();

                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'balance' => number_format($currentBalance['current_balance']) ?? 0.00
                ]);
            }
            catch(Exception $e){
                return response()->json(['message' => $e->getMessage()]);
            }
        }
        else{
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => "Sorry No User Found"
            ]);
        }
    }
}
