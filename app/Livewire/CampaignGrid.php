<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Campaign;

class CampaignGrid extends Component
{
    use WithPagination;

    public $search = '';
    public $category = 'All';
    public $sort = 'Most Recent';

    protected $queryString = ['search', 'category', 'sort'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Campaign::active()->withCount('confirmedDonations');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->category !== 'All') {
            $query->where('category', $this->category);
        }

        switch ($this->sort) {
            case 'Ending Soon':
                $query->orderBy('end_date', 'asc');
                break;
            case 'Goal Progress':
                $query->orderByRaw('(raised_amount / goal_amount) desc');
                break;
            case 'Most Recent':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return view('livewire.campaign-grid', [
            'campaigns' => $query->paginate(9),
        ]);
    }
}

