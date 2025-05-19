<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Название категории
        'slug',        // ЧПУ-ссылка
        'description',  // Описание категории (опционально)
        'image',       // Изображение категории (опционально)
    ];

    /**
     * Отношение "один ко многим" с моделью Product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Геттер для URL изображения категории
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/categories/'.$this->image) : null;
    }
}