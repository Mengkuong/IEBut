<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index(Request $request){
        $this->authorize('admin-post');
        $query = Post::query();
        $query->postcreate($request);
        $post = $query->latest()->paginate(10);
        return response([
            'data' => $post,
        ]);

    }
    public function show($id)
    {
        $this->authorize('admin-post');
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        return response([
            'data' => $post,
            'message' => 'Post Retrieved Successfully.']);
    }



    public function store(PostRequest $post){
        $this->authorize('admin-post');
        $requestKey = $post->all();
        $requestKey = Arr::add($requestKey,'user_id', auth()->user()->id);
        $post = Post::create($requestKey);
        return new PostResource($post);
    }

    public function update(Request $request,$id){
        $this->authorize('admin-post');
        $input = $request->all();
        $validator = Validator::make($input, [
            'share_price' => 'required',
            'up_or_down' => 'required',
            'date' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $post = Post::find($id);
        $post->share_price = $input['share_price'];
        $post->up_or_down = $input['up_or_down'];
        $post->date = $input['date'];
        $post->save();
        return response([
            'data' => $post ,
            'message' => 'update successfully'
        ]);
    }
    public function destroy($id){
        $this->authorize('admin-post');
        $post = Post::find($id);
        $post->delete();
        return response([
            'data' => $post,
            'message' => 'deleted']);
    }



}
