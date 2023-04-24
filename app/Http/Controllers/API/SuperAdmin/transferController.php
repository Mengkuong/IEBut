<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Models\deposit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class transferController extends Controller
{
    public function transfer(TransferRequest $request)
    {
        $this->authorize('transfer-super');
        $user = Auth::user();

        // check if the $user is not null/empty and the request is validated
        if((!is_null($user)) && ($request->validated())){
            try{
                // check to make sure the sender current balance is not lower than the sender current balance
                if($this->senderCurrentBalance($user->id) >= $request->amount){

                    // store the receiver current balance aadd the amount being transfered to it
                    $receiver_balance = $this->receiverCurrentBalance($request->receiver) + $request->amount;

                    // create tranfer. If the transfer is successful, perform deduction from senders current balance
                    if(deposit::create([
                        'send_by' => $user->id,
                        'sent_to' => $request->receiver,
                        'amount' => $request->amount,
                        'type' => 'credit',
                        'current_balance' => $receiver_balance
                    ])){

                        // update the sender's current balance
                        $senderNewBalance = $this->senderCurrentBalance($user->id) -  $request->amount;
                        $this->updateSenderCurrentBalance($user->id, $senderNewBalance);


                        // let the sender know that the transaction was successful
                        return response()->json([
                            'status' => 200,
                            'success' => true,
                            'message' => 'Transfer Successful',
                            'amountSent' => number_format($request->amount),
                            'newBalance' => number_format($senderNewBalance)
                        ]);
                    }
                }
                else{
                    // we want to tell the senders that their account balance is lower than the amount they are trying to send
                    return response()->json([
                        'status' => 500,
                        'success' => false,
                        'message' => "Insufficient Fund"
                    ]);
                }

            }
            catch (Exception $e) {
                return response()->json(['message' => $e->getMessage()]);
            }
        }
        else{
            // we want to tell the users that the data they supplied does not match any credentials in the database
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => "Sorry No User Found"
            ]);
        }
    }
    public function receiverCurrentBalance($receiver_id)
    {
        $currentBalance = deposit::select('current_balance')
            ->where('sent_to', $receiver_id)
            ->orderby('id', 'desc')
            ->get()
            ->first();

        return $currentBalance['current_balance'] ?? 0;
    }

    public function senderCurrentBalance($sender_id)
    {
        $currentBalance = deposit::select('current_balance')
            ->where('sent_to', $sender_id)
            ->orderby('id', 'desc')
            ->get()
            ->first();

        return $currentBalance['current_balance'] ?? 0;

    }

    public function updateSenderCurrentBalance($sender_id, $amount)
    {
        deposit::where('sent_to', $sender_id)
            ->orderBy('id', 'desc')
            ->first()
            ->update(['current_balance' => $amount]);
    }
}
