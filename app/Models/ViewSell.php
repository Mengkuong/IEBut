<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewSell extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','price_sell','shares','phone_number','date_sell'];
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
