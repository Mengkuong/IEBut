<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Models\Post;
use Illuminate\Http\Request;

class ViewCertificateController extends Controller
{
    public function index(Request $request){
        $this->authorize('user-view-certificate');
        $query = Certificate::query();
        $certificate = $query->latest()->paginate(10);
        return CertificateResource::collection($certificate);
    }
    public function show($id)
    {
        $this->authorize('user-view-certificate');
        $certificate = Certificate::findOrFail($id);
        return new CertificateResource( $certificate);
    }
}
