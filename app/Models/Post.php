<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'up_or_down', 'share_price','date'];
    protected $table = 'posts';
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function scopePostcreate($query, Request $request){

        if($request->has("search")){
            $search = $request->get("search");
            $query->where('share_price',"LIKE","%$search%")->orWhere('share_price',"LIKE", "%$search%");
        }

        return $query;
    }
    public function scopeUserview($query, Request $request){

        if($request->has("search")){
            $search = $request->get("search");
            $query->where('share_price',"LIKE","%$search%")->orWhere("share_price","LIKE", "%$search%");
        }

        return $query;
    }
}
