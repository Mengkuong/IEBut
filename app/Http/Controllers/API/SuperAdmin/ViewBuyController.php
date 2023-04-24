<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewBuyController extends Controller
{
    public function ViewBuy()
    {
        $this->authorize('super-admin-view-post');
        $buy = DB::table('buys')->select('id', 'user_id','name_seller',
            'price_buy','shares','phone_number_buyer','phone_number_seller','date_buy','buy_form')->latest()->paginate(10);
        return response($buy);
    }
}
