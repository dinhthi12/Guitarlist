<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $attributes = [
        'image'=>'',
        'discount'=>0,
        'hot'=> 0,
        'view'=> 0,
        'status'=>0
    ];
    protected $fillable = [
        'name',
        'cateitem_id',
        'price',
        'discount',
        'image',
        'view',
        'quantity',
        'detail',
        'hot',
        'status'
    ];

    public function Cate_item()
    {
        return $this->belongsTo(CateItem::class,'cateitem_id','id');
    }
    public function Category()
    {
        return $this->belongsTo(Category::class,'cateitem_id','id');
    }
    public function Comment()
    {
        return $this-> hasMany(Comment::class,'pro_id','id');
    }
    public function Detail()
    {
        return $this-> hasOne(Detail::class,'pro_id','id');
    }
    public function Color()
    {
        return $this-> hasMany(Color::class,'pro_id','id');
    }
    public function Variant()
    {
        return $this-> hasMany(Variant::class,'pro_id','id');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // Xoá các bản ghi trong bảng `detail` có khóa ngoại là `$product->id`
            Detail::where('pro_id', $product->id)->delete();
            // Xoá các bản ghi trong bảng `color` có khóa ngoại là `$product->id`
            Color::where('pro_id', $product->id)->delete();
            // Xoá các bản ghi trong bảng `variant` có khóa ngoại là `$product->id`
            Variant::where('pro_id', $product->id)->delete();
        });
    }
}
