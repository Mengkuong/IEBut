<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = ['image','title','description','user_id'];
    public function scopePostcreate($query, Request $request){

        if($request->has("search")){
            $search = $request->get("search");
            $query->where('title',"LIKE","%$search%")->orWhere("description","LIKE", "%$search%");
        }

        return $query;
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }
}
