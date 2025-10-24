<?php

namespace App\Livewire;

use App\Models\ComplianceRecord;
use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ComplianceList extends Component
{
    use WithPagination;

    public $franchiseId = '';
    public $status = '';
    public $showOverdueOnly = false;
    
    public function render()
    {
        $query = ComplianceRecord::with(['franchise', 'requirement', 'completedBy']);
        
        if ($this->franchiseId) {
            $query->where('franchise_id', $this->franchiseId);
        } elseif (!Auth::user()->isFranchisor() && !Auth::user()->isAdmin()) {
            $userFranchise = Auth::user()->franchises()->first();
            if ($userFranchise) {
                $query->where('franchise_id', $userFranchise->id);
            }
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->showOverdueOnly) {
            $query->overdue();
        }
        
        $complianceRecords = $query->latest('due_date')->paginate(15);
        
        $franchises = Franchise::active()->get();
        
        return view('livewire.compliance-list', [
            'complianceRecords' => $complianceRecords,
            'franchises' => $franchises
        ]);
    }
}
