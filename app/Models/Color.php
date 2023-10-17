<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = 'color';
    protected $attributes=[
        'price'=>null
    ];
    protected $fillable=[
        'pro_id',
        'color',
        'image',
        'price'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class,'pro_id','id');
    }
}
