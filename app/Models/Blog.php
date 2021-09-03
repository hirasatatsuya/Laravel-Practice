<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content'
    ];

//    protected $fillable = [
//        'user_id',
//        'picture',
//        'all_count',
//        'active'
//    ];
}
