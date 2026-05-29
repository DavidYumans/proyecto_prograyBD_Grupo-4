<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'commerce_id',
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function commerce()
    {
        return $this->hasOne(Commerce::class);
    }

    public function repartidorCommerce()
    {
        return $this->belongsTo(Commerce::class, 'commerce_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function deliveryOrders()
    {
        return $this->hasMany(Order::class, 'repartidor_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Order::class, 'repartidor_id');
    }

    public function siteRatings()
    {
        return $this->hasMany(SiteRating::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function sentConversationMessages()
    {
        return $this->hasMany(ConversationMessage::class, 'sender_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isComerciante(): bool
    {
        return $this->role === 'comerciante';
    }

    public function isRepartidor(): bool
    {
        return $this->role === 'repartidor';
    }

    public function isUsuario(): bool
    {
        return $this->role === 'usuario';
    }

    public function isActivo(): bool
    {
        return $this->status === 'activo';
    }

    public function isBaneado(): bool
    {
        return $this->status === 'baneado';
    }
}
