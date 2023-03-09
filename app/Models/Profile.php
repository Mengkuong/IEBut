<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','image','address','phone','bio','email'];
    protected $table = 'userprofiles';

    public function scopePost($query, Request $request){

        if ($request->has("search")) {
            $search = $request->get("search");
            $query->where('phone', "LIKE", "%$search%")->orWhere("bio", "LIKE", "%$search%");
        }

        return $query;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

}

