<?php

namespace App\Models;


use Couchbase\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sex',
        'dob',
        'id_card_number',
        'address',
        'phone_number',
        'buy_share',
        'price_per_share',
        'date_buy_share',
        'role_id'
    ];
    protected $guarded = ['id'];
    protected $table = "users";

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role(){
        return $this->belongsTo(\App\Models\Role::class);
    }
    public function scopeUserSearch($query, Request $request){

        if ($request->has("search")) {
            $search = $request->get("search");
            $query->where('name', "LIKE", "%$search%")->orWhere("email", "LIKE", "%$search%");
        }

        return $query;
    }
    public function post(){
        return $this->hasMany(Post::class);

    }
    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
    public function certificate(){
        return $this->hasMany(Certificate::class);

    }
    public function sell(){
        return $this->hasMany(Sell::class);
    }
    public function chats():HasMany{
        return $this->hasMany(Chat::class,'created_by');
    }
    public function routeNotificationForOneSignal() : array{
        return ['tags'=>['key'=>'userId','relation'=>'=', 'value'=>(string)($this->id)]];
    }
    public function sendNewMessageNotification(array $data) : void {
        $this->notify(new MessageSent($data));
    }


}
