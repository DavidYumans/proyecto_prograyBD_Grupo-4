<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'commerce_id',
        'name',
        'description',
        'image',
        'price',
        'stock',
        'discount_percentage',
        'status',
    ];

    public function commerce()
    {
        return $this->belongsTo(Commerce::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) return $this->image;
        return \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)
            ? asset('storage/' . $this->image)
            : null;
    }

    public function finalPrice(): float
    {
        if ($this->discount_percentage > 0) {
            return round($this->price - ($this->price * ($this->discount_percentage / 100)), 2);
        }

        return $this->price;
    }

    public function isActive(): bool
    {
        return $this->status === 'activo';
    }

    public function isInactive(): bool
    {
        return $this->status === 'inactivo';
    }

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }
}
