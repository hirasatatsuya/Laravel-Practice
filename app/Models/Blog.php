<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'user_id',
        'picture',
        'all_count',
        'active'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function blog_accesses()
    {
        return $this->hasMany('App\Models\BlogAccess');
    }

}
