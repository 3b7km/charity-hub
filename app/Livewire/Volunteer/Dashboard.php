<?php

namespace App\Livewire\Volunteer;

use Livewire\Component;
use App\Models\Volunteer;
use App\Models\VolunteerSchedule;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $volunteer;
    public $upcomingShifts;
    public $recentHours;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->volunteer = Volunteer::where('user_id', Auth::id())->first();
        
        if ($this->volunteer) {
            $this->upcomingShifts = $this->volunteer->upcomingSchedules()
                ->with('campaign')
                ->take(5)
                ->get();
                
            $this->recentHours = $this->volunteer->completedSchedules()
                ->orderBy('shift_end', 'desc')
                ->take(5)
                ->get();
        }
    }

    public function register()
    {
        if (Volunteer::where('user_id', Auth::id())->exists()) {
            return;
        }

        Volunteer::create([
            'user_id' => Auth::id(),
            'skills' => ['General Advocacy', 'Community Outreach'],
            'total_hours' => 0,
        ]);

        $this->loadData();
        
        session()->flash('message', 'Welcome to the team! Your volunteer profile has been created.');
    }

    public function render()
    {
        return view('livewire.volunteer.dashboard');
    }
}

