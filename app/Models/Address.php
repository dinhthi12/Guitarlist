<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
