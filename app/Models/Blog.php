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

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function blogaccesses()
    {
        return $this->hasMany('App\Models\BlogAccess');
    }

//    protected $fillable = [
//        'user_id',
//        'picture',
//        'all_count',
//        'active'
//    ];
}
