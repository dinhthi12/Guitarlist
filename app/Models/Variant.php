<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $table = 'variant';

    protected $attributes=[
        'price'=>null
    ];
    protected $fillable=[
        'pro_id',
        'name',
        'eq',
        'price'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class,'pro_id','id');
    }
}
