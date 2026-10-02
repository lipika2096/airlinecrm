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

    /**
     * Check if current user has access to a specific module
     *
     * @param string $moduleName
     * @return bool
     */
    public static function hasModuleAccess($moduleName)
    {
        // SuperAdmin has access to all modules
        if (self::isSuperAdmin()) {
            return true;
        }

        // Customers have access to all modules by default (can be restricted if needed)
        if (self::isCustomer()) {
            return true;
        }

        // Check staff module permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permission = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('module_name', $moduleName)
            ->first();

            return $permission && $permission->has_access;
        }

        return false;
    }

    /**
     * Get current user's accessible modules
     *
     * @return array
     */
    public static function getAccessibleModules()
    {
        // SuperAdmin has access to all modules
        if (self::isSuperAdmin()) {
            return ['all']; // Return all modules
        }

        // Customers have access to all modules by default
        if (self::isCustomer()) {
            return ['all'];
        }

        // Get staff module permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permissions = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('has_access', true)
            ->pluck('module_name')
            ->toArray();

            return $permissions;
        }

        return [];
    }

    /**
     * Check if current user has view permission for a specific module
     *
     * @param string $moduleName
     * @return bool
     */
    public static function hasViewPermission($moduleName)
    {
        // SuperAdmin has all permissions
        if (self::isSuperAdmin()) {
            return true;
        }

        // Customers have all permissions by default
        if (self::isCustomer()) {
            return true;
        }

        // Check staff sub-module permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permission = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('module_name', $moduleName)
            ->first();

            return $permission && $permission->can_view;
        }

        return false;
    }

    /**
     * Check if current user has create permission for a specific module
     *
     * @param string $moduleName
     * @return bool
     */
    public static function hasCreatePermission($moduleName)
    {
        // SuperAdmin has all permissions
        if (self::isSuperAdmin()) {
            return true;
        }

        // Customers have all permissions by default
        if (self::isCustomer()) {
            return true;
        }

        // Check staff sub-module permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permission = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('module_name', $moduleName)
            ->first();

            return $permission && $permission->can_create;
        }

        return false;
    }

    /**
     * Check if current user has edit permission for a specific module
     *
     * @param string $moduleName
     * @return bool
     */
    public static function hasEditPermission($moduleName)
    {
        // SuperAdmin has all permissions
        if (self::isSuperAdmin()) {
            return true;
        }

        // Customers have all permissions by default
        if (self::isCustomer()) {
            return true;
        }

        // Check staff sub-module permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permission = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('module_name', $moduleName)
            ->first();

            return $permission && $permission->can_edit;
        }

        return false;
    }

    /**
     * Check if current user has delete permission for a specific module
     *
     * @param string $moduleName
     * @return bool
     */
    public static function hasDeletePermission($moduleName)
    {
        // SuperAdmin has all permissions
        if (self::isSuperAdmin()) {
            return true;
        }

        // Customers have all permissions by default
        if (self::isCustomer()) {
            return true;
        }

        // Check staff sub-module permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permission = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('module_name', $moduleName)
            ->first();

            return $permission && $permission->can_delete;
        }

        return false;
    }

    /**
     * Check if current user has access to a specific submodule
     *
     * @param string $submoduleName (e.g., 'hr.add-staff', 'hr.staff-list')
     * @return bool
     */
    public static function hasSubmoduleAccess($submoduleName)
    {
        // SuperAdmin has access to all submodules
        if (self::isSuperAdmin()) {
            return true;
        }

        // Customers have access to all submodules by default
        if (self::isCustomer()) {
            return true;
        }

        // Check staff submodule permissions
        if (self::isStaff()) {
            $userId = auth()->user()->id;
            $permission = \App\Models\ModulePermission::where(function($query) use ($userId) {
                $query->where('employee_id', $userId)
                      ->orWhere('employee_id', (string)$userId);
            })
            ->where('module_name', $submoduleName)
            ->first();

            return $permission && $permission->has_access;
        }

        return false;
    }
}