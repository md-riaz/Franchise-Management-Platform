<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Royalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'period',
        'period_start',
        'period_end',
        'gross_sales',
        'royalty_percentage',
        'royalty_amount',
        'status',
        'due_date',
        'paid_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'due_date' => 'date',
            'paid_date' => 'date',
            'gross_sales' => 'decimal:2',
            'royalty_percentage' => 'decimal:2',
            'royalty_amount' => 'decimal:2',
        ];
    }

    // Relationships
    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }
}
