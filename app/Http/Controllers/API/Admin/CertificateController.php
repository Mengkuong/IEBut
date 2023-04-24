<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function index(Request $request){
        $this->authorize('admin-certificate');
        $query = Certificate::query();
        $query->postcreate($request);
        $certificate = $query->latest()->paginate(10);
        return CertificateResource::collection($certificate);
    }
    public function show($id)
    {
        $this->authorize('admin-certificate');
        $certificate = Certificate::findOrFail($id);
        return new CertificateResource($certificate);
    }
    public function store(CertificateRequest $request,Certificate $certificate){

        $this->authorize('admin-certificate');
        $requestKey = $request->all();
        $requestKey = Arr::add($requestKey,'user_id', auth()->user()->id);
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
        $certificate = Certificate::create($requestKey);
        $certificate -> refresh();

        return new CertificateResource($certificate);
    }
    public function update(Request $request,$id){

        $this->authorize('admin-certificate');
        $certificate = Certificate::find($id);
        $certificate->title = $request->title;
        $certificate->image = $request->image;
        $certificate->description= $request->description;


        $imageName  = null;
        if ($request->hasFile('image'))
        {

            // $destination = 'public/images/'.$post->image;
            if (Storage::exists("public/images/".$certificate->image))

            {
                Storage::delete("public/images/".$certificate->image);
            }

            $image = $request["image"];
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '_.' . $extension;
            $path = $image->storeAs("public/images" ,$imageName);
            $certificate["image"] = $imageName;
        }


        $certificate->save();
        $certificate->refresh();
        $certificate->update();
        return new CertificateResource($certificate);

    }
    public function destroy($id){
        $this->authorize('admin-certificate');
        $certificate = Certificate::find($id);
        $certificate->delete();
        return response([
            'data' => $certificate,
            'message' => 'deleted']);
    }
}
