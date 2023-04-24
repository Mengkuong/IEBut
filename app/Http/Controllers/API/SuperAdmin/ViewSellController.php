<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\SellResource;
use App\Http\Resources\ViewSellResource;
use App\Models\Sell;
use App\Models\ViewSell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewSellController extends Controller
{
     public function index(){
         $this->authorize('view-sell-shares');
         $sell = DB::table('sells')->select('id', 'user_id','price_sell', 'shares','phone_number','date_sell')
             ->latest()->paginate(10);
         return response($sell);
     }

}
