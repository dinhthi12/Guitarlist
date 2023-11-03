<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $attributes = [
        'status'=>0,
        'note'=>''
    ];
    protected $fillable = [
        'user_id',
        'user_address',
        'deli_id',
        'discount',
        'total',
        'status',
        'note'
    ];

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class,'order_id', 'id');
    }
    public function Product()
    {
        return $this->hasMany(Product::class,'pro_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function Address()
    {
        return $this->belongsTo(Address::class,'address_id','id');
    }
    public function Delivery()
    {
        return $this->belongsTo(Delivery::class,'delivery_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            OrderDetail::where('order_id', $order->id)->delete();
        });
    }
}
