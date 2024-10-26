<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TourGuide extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'captain',
        'image',
        'phn_number',
        'insta'
    ];
    public $timestamps = true;
    
}


