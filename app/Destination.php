<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    // Specify the table name (if different from pluralized model name)
    protected $table = 'destinations';

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'country',
        'image',
        'about',
        'attraction',
        'coordinates',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'name');
    }
}
