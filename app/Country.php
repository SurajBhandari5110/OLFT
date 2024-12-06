<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Package;
use App\Destination;

class Country extends Model
{
    use HasFactory;
    

    // Table name (optional, defaults to "countries")
    protected $table = 'countries';

    // Mass assignable attributes
    protected $fillable = ['name', 'code'];

    // Define relationships if necessary (e.g., with packages)
    public function packages()
    {
        return $this->hasMany(Package::class, 'country');
    }
    public function destination()
    {
        return $this->hasMany(Destination::class, 'country');
    }
}
