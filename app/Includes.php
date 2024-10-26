<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Includes extends Model
{
    protected $primaryKey = 'include_id';
    public $incrementing = true;
    protected $fillable = ['Name', 'isActive'];
    public $timestamps = true;

    public function inclusions()
    {
        return $this->hasMany(Inclusion::class, 'include_id');
    }
}

