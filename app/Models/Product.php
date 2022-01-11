<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'barcode',
        'description',
        'is_visible',
        'parent_id',
        'old_price_amount',
        'price_amount',
        'cost_amount',
        'seo_title',
        'seo_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Get the formatted price value.
     */
    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->parent_id) {
            return $this->price_amount
                ? $this->price_amount
                : ($this->parent->price_amount ? $this->parent->price_amount : null);
        }

        return $this->price_amount
                ? $this->price_amount
                : null;
    }

    public function variations(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->variations()->detele();
        });
    }
}
