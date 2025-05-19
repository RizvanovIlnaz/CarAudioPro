<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'main_image',
        'is_recommended',
        'category_id',  // Добавляем связь с категорией
    ];

    /**
     * Отношение "многие к одному" с моделью Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Геттер для URL изображения товара
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->main_image ? asset('storage/products/'.$this->main_image) : null;
    }

    /**
     * Scope для рекомендуемых товаров
     */
    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    /**
     * Scope для товаров в категории
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}