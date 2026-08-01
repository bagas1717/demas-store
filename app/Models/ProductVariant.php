<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'account_type',
        'duration_value',
        'duration_unit',
        'user_limit',
        'profile_limit',
        'warranty_text',
        'notes',
        'price',
        'compare_price',
        'stock',
        'minimum_stock',
        'is_active',
        'is_popular',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'compare_price' => 'integer',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp'.number_format(
            $this->price,
            0,
            ',',
            '.'
        );
    }
}
