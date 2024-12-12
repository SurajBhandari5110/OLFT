<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'name';
    public $incrementing = false; // For non-integer primary keys
    protected $keyType = 'string';
    public $timestamps = false; // Remove timestamps if not needed
}

