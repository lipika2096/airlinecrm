<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ModuleController extends Controller
{
    /**
     * Display a listing of modules with pricing
     */
    public function index()
    {
        // Get all permissions that are main modules (no dot in name)
        $modules = Permission::where('guard_name', 'web')
            ->where(function($query) {
                $query->where('name', 'not like', '%.%')
                      ->orWhere('name', 'like', '%.%');
            })
            ->orderBy('name')
            ->get();

        // Group by main module name
        $groupedModules = $modules->groupBy(function($permission) {
            if (strpos($permission->name, '.') !== false) {
                return explode('.', $permission->name)[0];
            }
            return $permission->name;
        });

        // Get unique main modules with their pricing info
        $mainModules = [];
        foreach ($groupedModules as $moduleName => $permissions) {
            $mainPermission = $permissions->first(function($p) use ($moduleName) {
                return strpos($p->name, '.') === false || explode('.', $p->name)[0] === $moduleName;
            });

            if ($mainPermission) {
                $mainModules[] = [
                    'id' => $mainPermission->id,
                    'name' => $moduleName,
                    'display_name' => ucfirst(str_replace('-', ' ', $moduleName)),
                    'description' => $mainPermission->description ?? '',
                    'status' => $mainPermission->status,
                    'monthly_price' => $mainPermission->monthly_price ?? 0,
                    'is_priced_module' => $mainPermission->is_priced_module ?? false,
                ];
            }
        }

        return view('admin.modules.index', compact('mainModules'));
    }

    /**
     * Update module details
     */
    public function update(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:permissions,id',
            'description' => 'nullable|string|max:500',
            'monthly_price' => 'nullable|numeric|min:0',
            'is_priced_module' => 'nullable',
            'status' => 'nullable|in:published,unpublished',
        ]);

        $permission = Permission::findOrFail($request->module_id);

        // Convert is_priced_module to boolean
        $isPricedModule = filter_var($request->is_priced_module, FILTER_VALIDATE_BOOLEAN);

        $permission->update([
            'description' => $request->description,
            'monthly_price' => $request->monthly_price ?? 0,
            'is_priced_module' => $isPricedModule,
            'status' => $request->status ?? $permission->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Module updated successfully'
        ]);
    }

    /**
     * Toggle module status
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:permissions,id',
        ]);

        $permission = Permission::findOrFail($request->module_id);
        $newStatus = $permission->status === 'published' ? 'unpublished' : 'published';

        $permission->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Module status updated successfully',
            'status' => $newStatus
        ]);
    }
}
