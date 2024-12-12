<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class TourCategory extends Model
{
    protected $table = 'tour_categories'; // Table name

    protected $fillable = [
        'pk_Package_id',
        'name',
    ]; // Mass-assignable fields

    public function category()
    {
        return $this->belongsTo(Category::class, 'name', 'name'); // Define relationship to Category
    }
}