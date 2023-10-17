<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $fillable = [
        'name',
    ];
    //quan hệ 1-n
    public function Cate_item()
    {
        return $this-> hasMany(CateItem::class,'category_id','id');
    }
    public function Product()
    {
        return $this-> hasManyThrough(Product::class,CateItem::class,'category_id','cateitem_id','id','id');
    }
}
