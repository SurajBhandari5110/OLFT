<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'tag';
    public $incrementing = false; // For non-integer primary keys
    protected $keyType = 'string';
    public $timestamps = false; // Remove timestamps if not needed
}

