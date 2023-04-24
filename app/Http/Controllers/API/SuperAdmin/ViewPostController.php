<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewPostController extends Controller
{
    public function ViewAll(){
        $this->authorize('super-admin-view-post');
        $post = DB::table('posts')->select('id', 'user_id','share_price', 'up_or_down',
            'date')->latest()->paginate(10);
        return response($post);
    }
}
