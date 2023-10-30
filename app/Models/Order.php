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
        return $this->hasMany('App\Models\OrderDetail','order_id', 'id');
    }
    public function Product()
    {
        return $this->hasMany('App\Models\Product','pro_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function Address()
    {
        return $this->belongsTo('App\Models\Address','address_id','id');
    }
    // public function Delivery()
    // {
    //     return $this->belongsTo('App\Models\Delivery','delivery_id', 'id');
    // }
}
