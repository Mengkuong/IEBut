<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewSellerController extends Controller
{
    public function ViewSeller(){
        $sell = DB::table('sells')->select('id', 'user_id', 'price_sell', 'shares', 'phone_number','date_sell')->latest()->paginate(10);
        return response($sell);
    }
}
