<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contact';
    protected $fillable = [
        'user_id',
        'user_email',
        'user_name',
        'message'
    ];
    public function User()
    {
        return $this-> belongsTo('App\Models\User','user_id','id');
    }
}
