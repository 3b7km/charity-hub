<?php

namespace App\Services;

use App\Models\Volunteer;
use App\Models\VolunteerSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VolunteerService
{
    /**
     * Register a new volunteer.
     */
    public function register(array $data, string $userId): Volunteer
    {
        return Volunteer::updateOrCreate(
            ['user_id' => $userId],
            [
                'skills' => $data['skills'] ?? [],
                'availability' => $data['availability'] ?? [],
                'emergency_contact' => $data['emergency_contact'] ?? null,
            ]
        );
    }

    /**
     * Check if the new shift conflicts with existing shifts.
     */
    public function hasConflict(string $volunteerId, Carbon $start, Carbon $end): bool
    {
        return VolunteerSchedule::where('volunteer_id', $volunteerId)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('shift_start', [$start, $end])
                      ->orWhereBetween('shift_end', [$start, $end])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('shift_start', '<=', $start)
                            ->where('shift_end', '>=', $end);
                      });
            })->exists();
    }

    /**
     * Calculate hours logged.
     */
    public function calculateHours(Carbon $start, Carbon $end): float
    {
        return round($start->diffInMinutes($end) / 60, 2);
    }

    /**
     * Clock in a volunteer.
     */
    public function clockIn(VolunteerSchedule $schedule): void
    {
        if ($schedule->status !== 'confirmed') {
            throw new \Exception('Only confirmed shifts can be clocked in.');
        }

        $schedule->update([
            'status' => 'in_progress',
            'shift_start' => now(),
        ]);
    }

    /**
     * Clock out a volunteer and update total hours.
     */
    public function clockOut(VolunteerSchedule $schedule): void
    {
        if ($schedule->status !== 'in_progress') {
            throw new \Exception('Shift is not in progress.');
        }

        $endTime = now();
        $hours = $this->calculateHours(Carbon::parse($schedule->shift_start), $endTime);

        DB::transaction(function () use ($schedule, $endTime, $hours) {
            $schedule->update([
                'status' => 'completed',
                'shift_end' => $endTime,
                'hours_logged' => $hours,
            ]);

            $schedule->volunteer()->increment('total_hours', $hours);
        });

        Log::info("Volunteer {$schedule->volunteer_id} clocked out. Hours logged: {$hours}.");
    }
}
