<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'checkout_token',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_note',
        'subtotal',
        'service_fee',
        'total',
        'status',
        'payment_status',
        'expires_at',
        'paid_at',
        'stock_released_at',
        'detail_requested_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'service_fee' => 'integer',
            'total' => 'integer',
            'expires_at' => 'datetime',
            'paid_at' => 'datetime',
            'stock_released_at' => 'datetime',
            'detail_requested_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
