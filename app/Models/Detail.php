<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $table = 'detail';
    protected $attributes = [
        'mechanicalSet'=>'N/A',
        'soundboard'=>'N/A',
        'keyboard'=>0,
        'size'=>'N/A',
        'weight'=>0,
        'manufacture'=>'N/A'
    ];
    protected $fillable = [
        'pro_id',
        'mechanicalSet',
        'soundboard',
        'keyboard',
        'size',
        'weight',
        'manufacture'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class,'pro_id','id');
    }
}
