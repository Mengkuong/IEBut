<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreprofileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index(Request $request){
        $query = Profile::query();
        $query->post($request);
        $query->where("user_id",auth()->user()->id);
        $profile= $query->latest()->paginate(10);
        return ProfileResource::collection($profile);
    }
    public function store(StoreprofileRequest $request){

        $requestKey = $request->all();
        $requestKey = Arr::add($requestKey, 'user_id',auth()->user()->id);

        $imageName = null;

        if($request->has('image'))
        {
            $image = $request["image"];
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            $imageName = $filename . '_' . time() . '_.' . $extension;

            $path = $image->storeAs("public/images", $imageName);

            $requestKey["image"] = $imageName;
        }
        $profile = Profile::create($requestKey);
        $profile -> refresh();

        return new ProfileResource($profile);

    }
    public function show(Profile $profile)
    {
        if (Auth::user()->id !== $profile->user_id)
        {
            return response()->json([
                "message" => "You are not authorize to make this request"
            ], 403);
        }
        return new ProfileResource($profile);
    }
    public function update(Request $request ,Profile $profile ){
        $phone = $request->phone;
        $address = $request->address;
        $bio = $request->bio;
        $email = $request->email;

        if ($phone){
            $profile->phone = $phone;
            $profile->save();
        }
        if ($address){
            $profile->address = $address;
            $profile->save();
        }
        if ($bio){
            $profile->bio = $bio;
            $profile->save();
        }
        if ($email){
            $profile->email = $email;
            $profile->save();
        }
        $imageName  = null;
        if ($request->hasFile('image'))
        {

            // $destination = 'public/images/'.$post->image;
            if (Storage::exists("public/images/".$profile->image))

            {
                Storage::delete("public/images/".$profile->image);
            }

            $image = $request["image"];
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '_.' . $extension;
            $path = $image->storeAs("public/images" ,$imageName);
            $profile["image"] = $imageName;
        }
        if (Auth::user()->id !== $profile->user_id)
        {
            return response()->json([
                     "message" => "You are not authorize to make this request"
            ], 403);
        }
        $profile->save();
        $profile->refresh();
        $profile->update();
           return new ProfileResource($profile);
    }
    public function destroy(Profile $profile){
        if (Storage::exists("public/images/".$profile->image)) {
            Storage::delete("public/images/".$profile->image);
        }
        if (Auth::user()->id !== $profile->user_id)
        {
            return response()->json([
                "message" => "You are not authorize to make this request"
            ], 403);
        }
        $profile->delete();
        return response()->json([
            "message" => "deleted"
        ],200);


    }

}
