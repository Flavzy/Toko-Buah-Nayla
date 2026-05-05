<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_phone',
        'customer_address', 'notes', 'subtotal', 'total',
        'status', 'payment_status', 'payment_method',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'delivered'  => 'Diterima',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => '#f59e0b',
            'processing' => '#3b82f6',
            'shipped'    => '#8b5cf6',
            'delivered'  => '#10b981',
            'cancelled'  => '#ef4444',
            default      => '#6b7280',
        };
    }
}
