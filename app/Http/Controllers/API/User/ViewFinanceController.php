<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewFinanceController extends Controller
{
    public function ViewFinance(){
        $this->authorize('view-finance-user');
        $finance = DB::table('payments')->select('id', 'user_id','date','total')->latest()->paginate(10);
        return response($finance);
    }

}
