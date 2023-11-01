<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Http\Middleware\TrustHosts;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user';
    protected $attributes = [
        'image' => '',
        'status' => 0, // default
        'role' => 0 // default is user

    ];
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'address',
        'phone',
        'status',
        'role'
    ];

    public function Wishlist()
    {
        return $this->hasOne(Wishlist::class, 'user_id', 'id');
    }
    // public function Address()
    // {
    //     return $this->hasMany(Address::class, 'user_id', 'id');
    // }
    public function Address()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }
    public function Order()
    {
        return $this->hasMany(OrderDetail::class, 'user_id', 'id');
    }
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
}
