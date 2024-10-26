<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inclusion extends Model
{
    protected $primaryKey = 'inclusion_id';
    protected $fillable = ['include_id', 'pk_Package_id', 'isActive'];
    public $timestamps = true;

    public function include()
    {
        return $this->belongsTo(Includes::class, 'include_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'pk_Package_id');
    }
}
