<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\EmployeeLeave;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        $currentYear = Carbon::now()->year;
        $fromYear = Carbon::now()->subYear()->year;

        User::whereNull('last_leave_update_year')
            ->orWhere('last_leave_update_year', '<', $currentYear)
            ->each(function ($employee) use ($fromYear, $currentYear) {
                $leave_bal_lastyear = EmployeeLeave::where('employee_id', $employee->id)
                    ->where('status', 3)
                    ->where('leave_type', 'Annual Leave')
                    ->whereYear('from', $fromYear)
                    ->sum('no_of_days');

                $employee->update([
                    'leave_count' => $employee->leave_count + $leave_bal_lastyear,
                    'last_leave_update_year' => $currentYear,
                ]);
            });

        // Share RouteHelper with all views
        view()->share('routeHelper', new \App\Helpers\RouteHelper());
    }
}
