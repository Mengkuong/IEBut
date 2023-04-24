<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyRequest;
use App\Http\Resources\BuyResource;
use App\Http\Resources\SellResource;
use App\Models\Buy;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BuyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('user-buy');
        $query = Buy::query();
        $query->where("user_id",auth()->user()->id);
//        $query->postcreate($request);
        $sell = $query->latest()->paginate(10);
        return BuyResource::collection($sell);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuyRequest $buyRequest)
    {
        $this->authorize('user-buy');
        $requestKey = $buyRequest->all();
        $requestKey = Arr::add($requestKey,'user_id', auth()->user()->id);
        $buy = Buy::create($requestKey);
        return new BuyResource($buy);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('user-buy');
        $buy = Buy::findOrFail($id);
        return new BuyResource($buy);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('user-buy');
        $input = $request->all();
        $validator = Validator::make($input, [
            'name_seller' => 'required',
            'price_buy' => 'required',
            'shares' => 'required',
            'phone_number_buyer' => 'required',
            'phone_number_seller' => 'required',
            'date_buy' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $buy = Buy::find($id);
        $buy->name_seller = $input['name_seller'];
        $buy->price_buy = $input['price_buy'];
        $buy->shares= $input['shares'];
        $buy->phone_number_buyer = $input['phone_number_buyer'];
        $buy->phone_number_seller= $input['phone_number_seller'];
        $buy->date_buy= $input['date_buy'];

        if (Auth::user()->id !== $buy->user_id)
        {
            return response()->json([
                "message" => "You are not authorize to make this request"
            ], 403);
        }
        $buy->save();
        return response([
            'data' => $buy ,
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('user-buy');
        $buy = Buy::find($id);
        $buy->delete();
        return response([
            'data' =>$buy,
            'message' => 'deleted']);
    }

}
