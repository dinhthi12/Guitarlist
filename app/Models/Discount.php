<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discount';
    protected $fillable = [
        'code',
        'discount',
        'quantity',
        'type',
        'start_time',
        'end_time'
    ];
    public function Product()
    {
        return $this->belongsTo(Product::class,'pro_id','id');
    }
}
