<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $table = 'slide';
    protected $attributes=[
        'slide_desc'=>null
    ];
    protected $fillable = [
        'name',
        'image',
        'slide_status',
        'slide_desc',
    ];
}
