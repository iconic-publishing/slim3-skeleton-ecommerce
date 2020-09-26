<?php

namespace Base\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model {

    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    
    protected $table = 'blogs';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'published_on'
    ];
	
}

