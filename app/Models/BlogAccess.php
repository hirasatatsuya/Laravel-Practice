<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogAccess extends Model
{
    use HasFactory;

    protected $fillable=[
        'id'
    ];

    public function blog(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Blog', 'blog_id','id' );
    }
}
