<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    // Specify the primary key name
    protected $primaryKey = 'id';

    // If the primary key is not auto-incrementing, set this to false (optional)
    public $incrementing = true;

    // Define the table fillable fields
    protected $fillable = [
        'phn_number',
        'facebook',
        'insta',
        'twitter',
        'location',
        'adrdress',
    ];
    public $timestamps = true;
}
