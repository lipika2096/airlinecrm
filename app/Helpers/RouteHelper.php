<?php

namespace App\Helpers;

class RouteHelper
{
    /**
     * Get the appropriate route prefix based on the authenticated user type
     *
     * @return string
     */
    public static function getRoutePrefix()
    {
        if (auth('admin')->check()) {
            if (auth('admin')->user()->hasRole('SuperAdmin')) {
                return 'admin.';
            } else {
                return 'customer.';
            }
        } elseif (auth()->check()) {
            return 'staff.';
        }
        
        return 'admin.'; // Default fallback
    }

    /**
     * Get the appropriate route name with dynamic prefix
     *
     * @param string $routeName
     * @return string
     */
    public static function route($routeName)
    {
        $prefix = self::getRoutePrefix();
        return $prefix . $routeName;
    }

    /**
     * Check if current user is SuperAdmin
     *
     * @return bool
     */
    public static function isSuperAdmin()
    {
        return auth('admin')->check() && auth('admin')->user()->hasRole('SuperAdmin');
    }

    /**
     * Check if current user is Customer
     *
     * @return bool
     */
    public static function isCustomer()
    {
        return auth('admin')->check() && !auth('admin')->user()->hasRole('SuperAdmin');
    }

    /**
     * Check if current user is Staff
     *
     * @return bool
     */
    public static function isStaff()
    {
        return auth()->check() && !auth('admin')->check();
    }

    /**
     * Get dashboard route based on user type
     *
     * @return string
     */
    public static function getDashboardRoute()
    {
        if (self::isSuperAdmin()) {
            return route('admin.dashboard');
        } elseif (self::isCustomer()) {
            return route('customer.dashboard');
        } elseif (self::isStaff()) {
            return route('staff.dashboard');
        }
        
        return route('admin.login');
    }

    /**
     * Get logout route based on user type
     *
     * @return string
     */
    public static function getLogoutRoute()
    {
        if (self::isSuperAdmin()) {
            return route('admin.logout');
        } elseif (self::isCustomer()) {
            return route('customer.logout');
        } elseif (self::isStaff()) {
            return route('staff.logout');
        }
        
        return route('admin.login');
    }

    /**
     * Get profile route based on user type
     *
     * @return string
     */
    public static function getProfileRoute()
    {
        if (self::isSuperAdmin()) {
            return route('admin.admin-profile');
        } elseif (self::isCustomer()) {
            return route('customer.profile');
        } elseif (self::isStaff()) {
            return route('staff.profile');
        }
        
        return route('admin.login');
    }
}