<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PromotionalPackage extends Model{
    use HasFactory;

    protected $fillable = [
        'pk_Package_id',
        'generated_url',
    ];

}
