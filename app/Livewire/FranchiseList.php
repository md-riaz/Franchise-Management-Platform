<?php

namespace App\Livewire;

use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class FranchiseList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Franchise::with('franchisor');
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        // If user is not admin or franchisor, only show their franchises
        if (!Auth::user()->isFranchisor() && !Auth::user()->isAdmin()) {
            $query->whereHas('users', function($q) {
                $q->where('user_id', Auth::id());
            });
        }
        
        $franchises = $query->latest()->paginate(10);
        
        return view('livewire.franchise-list', [
            'franchises' => $franchises
        ]);
    }
}
