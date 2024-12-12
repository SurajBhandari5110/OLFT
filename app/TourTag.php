<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class TourTag extends Model
{
    protected $table = 'tour_tags'; // Table name

    protected $fillable = [
        'pk_Package_id',
        'tag',
    ]; // Mass-assignable fields

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag', 'tag'); // Define relationship to Tag
    }
}