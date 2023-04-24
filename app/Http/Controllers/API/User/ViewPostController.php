<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class ViewPostController extends Controller
{
    public function index(Request $request){
        $this->authorize('view-post');
        $query = Post::query();
        $query->userview($request);
        $post = $query->latest()->paginate(10);
        return response([
            'data' => $post,
        ],200);
    }
}
