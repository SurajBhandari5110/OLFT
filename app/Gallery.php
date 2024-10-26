<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['pk_Package_id', 'image_url'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'pk_Package_id');
    }
}

