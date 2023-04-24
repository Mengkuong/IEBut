<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\depositRequest;
use App\Models\deposit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class depositController extends Controller
{
    public function deposit(DepositRequest $request)
    {
        $user = Auth::user();
        if((!is_null($user)) && ($request->validated())){

            try{
                $current_balance = $this->getCurrentBalance($user['id']) + $request->amount;

                deposit::create([
                    'send_by' => $user->id,
                    'sent_to' => $user->id,
                    'amount' => $request->amount,
                    'type' => 'deposit',
                    'current_balance' => $current_balance
                ]);

                return response()->json([
                    'status' => 201,
                    'success' => true,
                    'amountDeposited' => number_format($request->amount),
                    'currentBalance' => number_format($current_balance)

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


    /**
     * [getCurrentBalance returned the current balance of the user, stored it into a variable $current_balance to update next deposit transaction]
     * @param  [type] $sent_to [required parameter to fetch the current balance of an authenticated user]
     * @return [type]  [return a current balance or 0 if the user has not performed any transaction]
     */
    public function getCurrentBalance($sent_to)
    {
        $currentBalance = deposit::select('current_balance')
            ->where('sent_to', $sent_to)
            ->orderby('id', 'desc')
            ->get()
            ->first();

        return $currentBalance['current_balance'] ?? 0;
    }
}
