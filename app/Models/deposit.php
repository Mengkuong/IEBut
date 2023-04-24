<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit extends Model
{
    use HasFactory;
    protected $fillable = [
             'amount','current_balance','sent_to','send_by','type'

    ];
    protected $table = 'trans';
}
