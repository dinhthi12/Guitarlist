<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlist';
    protected $primary = 'id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'pro_id',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'pro_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
