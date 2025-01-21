<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PromotionalDestination extends Model{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'generated_url',
    ];
    public function destination()
    {
        return $this->belongsTo(Destination::class); 
    }

}
