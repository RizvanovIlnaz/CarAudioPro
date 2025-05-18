<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'main_image', 'is_recommended'
    ];

    public function getImageUrlAttribute()
    {
        return $this->main_image ? asset('storage/products/'.$this->main_image) : null;
    }
}