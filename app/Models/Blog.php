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

    public function blogaccesses()
    {
        return $this->hasMany('App\Models\BlogAccess');
    }

    public function scopeActive($query, $blogs)
    {
        return $query->where('active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', 0);
    }

}
