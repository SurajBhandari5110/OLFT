<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itineraries extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = ['package_id', 'days', 'title', 'description','image'];
    public $timestamps = true;

    // Define the relationship with the Package model
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}