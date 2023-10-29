<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'user_id',
        'order_id',
        'pro_id',
        'name',
        'number',
        'price'
    ];

    public function Orders()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
    public function Products()
    {
        return $this->belongsTo('App\Models\Product','pro_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }
}
