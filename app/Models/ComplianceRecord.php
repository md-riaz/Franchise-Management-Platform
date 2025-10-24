<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'compliance_requirement_id',
        'due_date',
        'completion_date',
        'status',
        'completed_by',
        'notes',
        'document_path',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    // Relationships
    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function requirement()
    {
        return $this->belongsTo(ComplianceRequirement::class, 'compliance_requirement_id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    // Scopes
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                     ->orWhere(function($q) {
                         $q->where('status', 'pending')
                           ->where('due_date', '<', now());
                     });
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
