<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\SellResource;
use App\Models\Certificate;
use App\Models\Post;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SellController extends Controller
{
    public function index(Request $request){
        $this->authorize('user-sell-shares');
        $query = Sell::query();
        $query->where("user_id",auth()->user()->id);
//        $query->postcreate($request);
        $sell = $query->latest()->paginate(10);
        return SellResource::collection($sell);
    }


    public function show($id){
        $this->authorize('user-sell-shares');
        $sell = Sell::findOrFail($id);
        return new SellResource($sell);
    }

    public function store(SellRequest $sell){
    $this->authorize('user-sell-shares');
    $requestKey = $sell->all();
    $requestKey = Arr::add($requestKey,'user_id', auth()->user()->id);
    $sell = Sell::create($requestKey);

    return new SellResource($sell);
    }
    public function update(Request $request,$id){
        $this->authorize('user-sell-shares');
        $input = $request->all();
        $validator = Validator::make($input, [
            'price_sell' => 'required',
            'shares' => 'required',
            'phone_number' => 'required',
            'date_sell' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $sell = Sell::find($id);
        $sell->price_sell = $input['price_sell'];
        $sell->shares = $input['shares'];
        $sell->phone_number = $input['phone_number'];
        $sell->date_sell = $input['date_sell'];
        if (Auth::user()->id !== $sell->user_id)
        {
            return response()->json([
                "message" => "You are not authorize to make this request"
            ], 403);
        }
        $sell->save();
        return response([
            'data' => $sell ,
            'message' => 'update successfully'
        ]);
    }
    public function destroy($id){
        $sell = Sell::find($id);
        $sell->delete();
        return response([
            'data' =>$sell,
            'message' => 'deleted']);
    }

}
