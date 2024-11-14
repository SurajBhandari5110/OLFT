<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageStay extends Model
{
    // Specify the primary key name
    protected $primaryKey = 'id';

    //relation for packaegeinclusion table
    

    // If the primary key is not auto-incrementing, set this to false (optional)
    public $incrementing = true;

    // Define the table fillable fields
    protected $fillable = [
        'pk_Package_id',
        'pk_hotel_id'
    ];
        public $timestamps = true;
    }
