<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function franchises()
    {
        return $this->belongsToMany(Franchise::class, 'franchise_users')
                    ->withPivot('role', 'joined_date')
                    ->withTimestamps();
    }

    public function ownedFranchises()
    {
        return $this->hasMany(Franchise::class, 'franchisor_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Scopes
    public function scopeFranchisors($query)
    {
        return $query->where('user_type', 'franchisor');
    }

    public function scopeFranchisees($query)
    {
        return $query->where('user_type', 'franchisee');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function isFranchisor(): bool
    {
        return $this->user_type === 'franchisor';
    }

    public function isFranchisee(): bool
    {
        return $this->user_type === 'franchisee';
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }
}
