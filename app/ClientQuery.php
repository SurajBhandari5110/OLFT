<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'fullname',
        'email',
        'phone',
        'message',
    ];
}
