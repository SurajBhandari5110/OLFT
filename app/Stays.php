<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Stays extends Model
{
    protected $primaryKey = 'pk_hotel_id';
    public $incrementing = true;
    protected $fillable = [
        'name',
        'description',
        'country',
        'state',
        'image'
    ];
    public $timestamps = true;
    
}


