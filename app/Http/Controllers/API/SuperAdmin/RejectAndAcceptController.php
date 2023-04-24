<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RejectAndAcceptController extends Controller
{
    public function accept($id){
        $this->authorize('accept-reject');
        $buy =DB::table('buys')->select('buy_form')->from('buys')->where('id', '=', $id)->first();
        if($buy->buy_form == 'pending'){
            $buy_form ='accept';
        }

        $value = array('buy_form' =>$buy_form);
        DB::table('buys')->where('id', $id)->update($value);
        return response()->json([
            'message' => 'This request is accepted.'
        ]);
    }
    public function reject($id){
        $this->authorize('accept-reject');
        $buy =DB::table('buys')->select('buy_form')->from('buys')->where('id', '=', $id)->first();
        if($buy->buy_form == 'pending'){
            $buy_form ='reject';
        }

        $value = array('buy_form' =>$buy_form);
        DB::table('buys')->where('id', $id)->update($value);
        return response()->json([
            'message' => 'This request is rejected.'
        ]);
    }

}
