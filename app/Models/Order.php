<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'repartidor_id',
        'coupon_id',
        'coupon_code',
        'subtotal',
        'discount_total',
        'total',
        'status',
        'delivery_status',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryUser()
    {
        return $this->belongsTo(User::class, 'repartidor_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function siteRating()
    {
        return $this->hasOne(SiteRating::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pendiente' => 'Pendiente',
            'confirmado' => 'Confirmado',
            'en_preparacion' => 'En preparación',
            'en_camino' => 'En camino',
            'entregado' => 'Entregado',
            'cancelado' => 'Cancelado',
            default => 'Pendiente',
        };
    }

    public function deliveryStatusLabel(): string
    {
        return match ($this->delivery_status) {
            'asignado' => 'Asignado',
            'recogido' => 'Recogido',
            'en_camino' => 'En camino',
            'entregado' => 'Entregado',
            default => 'Sin asignar',
        };
    }
}
