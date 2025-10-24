<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitSharing extends Model
{
    use HasFactory;

    protected $table = 'profit_sharing';

    protected $fillable = [
        'franchise_id',
        'period',
        'period_start',
        'period_end',
        'total_revenue',
        'total_expenses',
        'net_profit',
        'franchisor_share_percentage',
        'franchisor_share_amount',
        'franchisee_share_percentage',
        'franchisee_share_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'total_revenue' => 'decimal:2',
            'total_expenses' => 'decimal:2',
            'net_profit' => 'decimal:2',
            'franchisor_share_percentage' => 'decimal:2',
            'franchisor_share_amount' => 'decimal:2',
            'franchisee_share_percentage' => 'decimal:2',
            'franchisee_share_amount' => 'decimal:2',
        ];
    }

    // Relationships
    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }
}
