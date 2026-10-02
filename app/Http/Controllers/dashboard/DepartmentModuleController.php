<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\DepartmentModule;
use App\Models\Department;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class DepartmentModuleController extends Controller
{
    /**
     * Display a listing of department-module assignments
     */
    public function index()
    {
        $departmentModules = DepartmentModule::orderBy('department_name')
            ->orderBy('module_name')
            ->get()
            ->groupBy('department_name');

        $allPermissions = Permission::where('guard_name', 'web')->get();
        $availableModules = [];

        foreach ($allPermissions as $permission) {
            $moduleName = explode('.', $permission->name)[0];
            if (!array_key_exists($moduleName, $availableModules) && !str_contains($permission->name, '.')) {
                $availableModules[$moduleName] = ucfirst(str_replace('-', ' ', $moduleName));
            }
        }

        asort($availableModules);

        // Fetch departments from the database
        $departments = Department::pluck('department_name', 'id')->toArray();

        return view('admin.department-modules.index', compact('departmentModules', 'availableModules', 'departments'));
    }

    /**
     * Store a new department-module assignment
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string',
            'module_name' => 'required|string',
        ]);

        try {
            DepartmentModule::updateOrCreate(
                [
                    'department_name' => $request->department_name,
                    'module_name' => $request->module_name
                ],
                [
                    'is_active' => true
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Module assigned to department successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning module: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a department-module assignment
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string',
            'module_name' => 'required|string',
        ]);

        try {
            DepartmentModule::where('department_name', $request->department_name)
                ->where('module_name', $request->module_name)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Module removed from department successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing module: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get modules for a specific department
     */
    public function getModulesByDepartment($departmentName)
    {
        $modules = DepartmentModule::where('department_name', $departmentName)
            ->where('is_active', true)
            ->pluck('module_name')
            ->toArray();

        return response()->json([
            'success' => true,
            'modules' => $modules
        ]);
    }

    /**
     * Toggle module activation for a department
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string',
            'module_name' => 'required|string',
        ]);

        try {
            $departmentModule = DepartmentModule::where('department_name', $request->department_name)
                ->where('module_name', $request->module_name)
                ->first();

            if ($departmentModule) {
                $departmentModule->update([
                    'is_active' => !$departmentModule->is_active
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Module status updated successfully',
                    'is_active' => $departmentModule->is_active
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Department-module assignment not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating module status: ' . $e->getMessage()
            ], 500);
        }
    }
}
