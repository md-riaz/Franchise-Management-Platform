<?php

namespace App\Livewire;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class VendorList extends Component
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
        $query = Vendor::query();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        $vendors = $query->latest()->paginate(15);
        
        return view('livewire.vendor-list', [
            'vendors' => $vendors
        ]);
    }
}
