<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'location',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'phone',
        'email',
        'franchisor_id',
        'status',
        'opening_date',
        'initial_investment',
        'franchise_fee',
        'royalty_percentage',
    ];

    protected function casts(): array
    {
        return [
            'opening_date' => 'date',
            'initial_investment' => 'decimal:2',
            'franchise_fee' => 'decimal:2',
            'royalty_percentage' => 'decimal:2',
        ];
    }

    // Relationships
    public function franchisor()
    {
        return $this->belongsTo(User::class, 'franchisor_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'franchise_users')
                    ->withPivot('role', 'joined_date')
                    ->withTimestamps();
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function royalties()
    {
        return $this->hasMany(Royalty::class);
    }

    public function profitSharing()
    {
        return $this->hasMany(ProfitSharing::class);
    }

    public function complianceRecords()
    {
        return $this->hasMany(ComplianceRecord::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
