<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\RouteHelper;

class ModuleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module)
    {
        // SuperAdmin and Customer have access to all modules
        if (RouteHelper::isSuperAdmin() || RouteHelper::isCustomer()) {
            return $next($request);
        }

        // Check staff module access
        if (RouteHelper::isStaff()) {
            if (!RouteHelper::hasModuleAccess($module)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to access this module.'
                    ], 403);
                }
                
                return redirect()->route(RouteHelper::getDashboardRoute())
                    ->with('error', 'You do not have permission to access this module.');
            }
        }

        return $next($request);
    }
}