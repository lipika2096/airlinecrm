<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentModule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get modules for a specific department
     */
    public static function getModulesForDepartment($departmentName)
    {
        return self::where('department_name', $departmentName)
            ->where('is_active', true)
            ->pluck('module_name')
            ->toArray();
    }

    /**
     * Get departments for a specific module
     */
    public static function getDepartmentsForModule($moduleName)
    {
        return self::where('module_name', $moduleName)
            ->where('is_active', true)
            ->pluck('department_name')
            ->toArray();
    }

    /**
     * Assign a module to a department
     */
    public static function assignModuleToDepartment($departmentName, $moduleName)
    {
        return self::updateOrCreate(
            [
                'department_name' => $departmentName,
                'module_name' => $moduleName
            ],
            [
                'is_active' => true
            ]
        );
    }

    /**
     * Remove a module from a department
     */
    public static function removeModuleFromDepartment($departmentName, $moduleName)
    {
        return self::where('department_name', $departmentName)
            ->where('module_name', $moduleName)
            ->delete();
    }
}
