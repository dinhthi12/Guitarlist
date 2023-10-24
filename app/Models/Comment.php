<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $attributes = [
        'rate'=> 0
    ];
    protected $fillable = [
        'pro_id',
        'user_id',
        'content',
        'rate',
        'time',
        'status'
    ];
    public function Product()
    {
        return $this-> belongsTo('App\Models\Product','pro_id','id');
    }
    public function User()
    {
        return $this-> belongsTo('App\Models\User','user_id','id');
    }
}
