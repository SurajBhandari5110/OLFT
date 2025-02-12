<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Blog extends Model
{
    use HasFactory;

    // Define table name (if not following Laravel's naming convention)
    protected $table = 'blogs';

    // Define primary key
    protected $primaryKey = 'blog_id';

    // Enable mass assignment for these fields
    protected $fillable = [
        'title',
        'content', // HTML content (includes Quill editor images)
        'slug',    // SEO-friendly URL
        'by_user', // User who created the blog
        'front_image'//front image which will shown on blogs
    ];

}
