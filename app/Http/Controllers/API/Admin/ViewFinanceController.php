<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewFinanceController extends Controller
{
    public function index(Request $request){
        $this->authorize('view-finance-admin');
        $finance = DB::table('payments')->select('id', 'user_id', 'expand', 'income', 'date','total')->latest()->paginate(10);
        return response($finance);
    }
}
