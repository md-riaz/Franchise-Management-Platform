<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'product_id',
        'quantity',
        'reserved_quantity',
        'last_restocked_at',
    ];

    protected function casts(): array
    {
        return [
            'last_restocked_at' => 'date',
        ];
    }

    // Relationships
    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->whereHas('product', function ($q) {
            $q->whereRaw('inventory.quantity <= products.reorder_level');
        });
    }

    // Helper methods
    public function getAvailableQuantity()
    {
        return $this->quantity - $this->reserved_quantity;
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->product->reorder_level;
    }
}
