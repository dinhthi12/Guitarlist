<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateItem extends Model
{
    use HasFactory;
    protected $table = 'category_item';
    protected $fillable = [
        'name',
        'category_id'
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function Product()
    {
        return $this->hasMany(Product::class,'cateitem_id','id');
    }
}
