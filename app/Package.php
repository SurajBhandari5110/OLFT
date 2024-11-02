<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    // Specify the primary key name
    protected $primaryKey = 'pk_Package_id';

    //relation for packaegeinclusion table
    

    // If the primary key is not auto-incrementing, set this to false (optional)
    public $incrementing = true;

    // Define the table fillable fields
    protected $fillable = [
        'title',
        'about',
        'location',
        'duration',
        'tour_type',
        'image',
        'group_size',
        'tour_guide',
        'coordinates',
        'travel_with_bus'
    ];
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'pk_Package_id');
    }
    public function inclusions()
    {
        return $this->hasMany(Inclusion::class, 'pk_Package_id');
    }
    // Package.php
public function itineraries()
{
    return $this->hasMany(Itineraries::class, 'package_id', 'pk_Package_id');
}

    public $timestamps = true;
}
