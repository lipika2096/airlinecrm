<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\EmployeeLeave;
use Illuminate\Support\ServiceProvider;
use App\Helpers\TimezoneHelper;

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

        // Share TimezoneHelper with all views for global timezone access
        view()->share('timezoneHelper', new TimezoneHelper());

        // Set default pagination view to Bootstrap 4
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.bootstrap-4');
        \Illuminate\Pagination\Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4');

        // Register Carbon macros for automatic timezone conversion
        $this->registerCarbonMacros();

        // Register Blade directives for timezone handling
        $this->registerBladeDirectives();
    }

    /**
     * Register Carbon macros for automatic timezone conversion
     */
    protected function registerCarbonMacros()
    {
        Carbon::macro('toUserTimezone', function () {
            $timezone = TimezoneHelper::getUserTimezone();
            return $this->setTimezone($timezone);
        });

        Carbon::macro('toSystemTimezone', function () {
            $timezone = TimezoneHelper::getSystemTimezone();
            return $this->setTimezone($timezone);
        });

        Carbon::macro('formatInUserTimezone', function ($format = 'Y-m-d H:i:s') {
            return $this->toUserTimezone()->format($format);
        });

        Carbon::macro('formatInSystemTimezone', function ($format = 'Y-m-d H:i:s') {
            return $this->toSystemTimezone()->format($format);
        });
    }

    /**
     * Register Blade directives for timezone handling
     */
    protected function registerBladeDirectives()
    {
        // Directive to format datetime in user timezone
        \Blade::directive('timezone', function ($expression) {
            return "<?php echo \App\Helpers\TimezoneHelper::formatInUserTimezone($expression); ?>";
        });

        // Directive to format datetime with custom format in user timezone
        \Blade::directive('timezoneFormat', function ($expression) {
            // Parse expression: $datetime, $format
            $params = explode(',', $expression);
            $datetime = trim($params[0]);
            $format = isset($params[1]) ? trim($params[1]) : "'Y-m-d H:i:s'";
            return "<?php echo \App\Helpers\TimezoneHelper::formatInUserTimezone($datetime, $format); ?>";
        });

        // Directive to get current time in user timezone
        \Blade::directive('now', function ($format = "'Y-m-d H:i:s'") {
            return "<?php echo \App\Helpers\TimezoneHelper::nowInUserTimezone()->format($format); ?>";
        });

        // Directive to check module access
        \Blade::if('canAccessModule', function ($module) {
            return \App\Helpers\RouteHelper::hasModuleAccess($module);
        });

        // Directive to check view permission
        \Blade::if('canView', function ($module) {
            return \App\Helpers\RouteHelper::hasViewPermission($module);
        });

        // Directive to check create permission
        \Blade::if('canCreate', function ($module) {
            return \App\Helpers\RouteHelper::hasCreatePermission($module);
        });

        // Directive to check edit permission
        \Blade::if('canEdit', function ($module) {
            return \App\Helpers\RouteHelper::hasEditPermission($module);
        });

        // Directive to check delete permission
        \Blade::if('canDelete', function ($module) {
            return \App\Helpers\RouteHelper::hasDeletePermission($module);
        });

        // Directive to check submodule access
        \Blade::if('canAccessSubmodule', function ($submodule) {
            return \App\Helpers\RouteHelper::hasSubmoduleAccess($submodule);
        });
    }
}
