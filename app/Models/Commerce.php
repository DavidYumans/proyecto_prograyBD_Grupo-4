<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'banner',
        'logo',
        'address',
        'phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function repartidores()
    {
        return $this->hasMany(User::class)->where('role', 'repartidor');
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) return null;
        return str_starts_with($this->logo, 'http') ? $this->logo : asset('storage/' . $this->logo);
    }

    public function getBannerUrlAttribute(): ?string
    {
        if (!$this->banner) return null;
        return str_starts_with($this->banner, 'http') ? $this->banner : asset('storage/' . $this->banner);
    }

    public function isActivo(): bool
    {
        return $this->status === 'activo';
    }

    public function isSuspendido(): bool
    {
        return $this->status === 'suspendido';
    }

    public function isInactivo(): bool
    {
        return $this->status === 'inactivo';
    }
}
