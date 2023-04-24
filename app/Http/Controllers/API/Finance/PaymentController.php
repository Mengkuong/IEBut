<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\SellResource;
use App\Models\Payment;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
        public function index(Request $request){
            $this->authorize('finance-create');
            $query = Payment::query();
//        $query->postcreate($request);
            $payment = $query->latest()->paginate(10);
            return PaymentResource::collection($payment);
        }


        public function show($id){
            $this->authorize('finance-create');
            $payment = Payment::findOrFail($id);
            return new PaymentResource($payment);
        }


        public function store(PaymentRequest $paymentRequest){
            $this->authorize('finance-create');
            $requestKey = $paymentRequest->all();
            $requestKey = Arr::add($requestKey,'user_id', auth()->user()->id);
            $paymentRequest = Payment::create($requestKey);

            return new PaymentResource($paymentRequest);

        }
        public function update(Request $request,$id){
            $this->authorize('finance-create');
            $input = $request->all();
            $validator = Validator::make($input, [
                'expand' => 'required',
                'income' => 'required',
                'date_sell' => 'required',
                'total' => 'required',

            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $payment = Payment::find($id);
            $payment->pexpand = $input['expand'];
            $payment->income = $input['income'];
            $payment->date_sell = $input['date_sell'];
            $payment->total = $input['total'];
            if (Auth::user()->id !== $payment->user_id)
            {
                return response()->json([
                    "message" => "You are not authorize to make this request"
                ], 403);
            }
            $payment->save();
            return response([
                'data' => $payment ,
                'message' => 'update successfully'
            ]);

        }
        public function destroy()
        {

        }
}
