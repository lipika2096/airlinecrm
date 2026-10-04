<?php

namespace App\Http\Controllers\dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionRule;
use App\Models\Admin;
use Spatie\Permission\Models\Permission;

class SubscriptionController extends Controller
{
    /**
     * Display subscription settings form
     */
    public function index()
    {
        $rule = SubscriptionRule::first();
        return view('admin.subscriptions.index', compact('rule'));
    }

    /**
     * Update subscription rules
     */
    public function update(Request $request)
    {
        $request->validate([
            'billing_frequency' => 'required|in:monthly,yearly',
            'annual_discount' => 'required|numeric|min:0|max:100',
            'proration_first_month' => 'nullable',
            'billing_cycle' => 'required|string',
            'cancellation_policy' => 'required|string',
            'minimum_subscription_period' => 'required|string',
            'notice_period' => 'required|string',
        ]);

        $rule = SubscriptionRule::first();

        $prorationEnabled = $request->proration_first_month == '1';

        if (!$rule) {
            SubscriptionRule::create([
                'billing_frequency' => $request->billing_frequency,
                'annual_discount' => $request->annual_discount,
                'proration_first_month' => $prorationEnabled,
                'billing_cycle' => $request->billing_cycle,
                'cancellation_policy' => $request->cancellation_policy,
                'minimum_subscription_period' => $request->minimum_subscription_period,
                'notice_period' => $request->notice_period,
                'is_active' => true,
                'created_by' => auth('admin')->user()->id ?? null,
            ]);
        } else {
            $rule->update([
                'billing_frequency' => $request->billing_frequency,
                'annual_discount' => $request->annual_discount,
                'proration_first_month' => $prorationEnabled,
                'billing_cycle' => $request->billing_cycle,
                'cancellation_policy' => $request->cancellation_policy,
                'minimum_subscription_period' => $request->minimum_subscription_period,
                'notice_period' => $request->notice_period,
            ]);
        }

        return redirect()->back()->with('success', 'Subscription rules updated successfully.');
    }

    /**
     * Display customer subscriptions form
     */
    public function customerSubscriptions()
    {
        // Get all customers (admins with Customer role)
        $customers = Admin::with('adminDetail')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superAdmin');})->latest()->get();

        // Get all priced modules (main modules for subscription)
        $modules = Permission::where('guard_name', 'web')
            ->where('is_priced_module', true)
            ->where('status', 'published')
            ->orderBy('name')
            ->get();

        // Get all permissions (including submodules) for the view functionality
        $allPermissions = Permission::where('guard_name', 'web')
            ->where('status', 'published')
            ->orderBy('name')
            ->get();

        // Get subscription rule for discount info
        $rule = SubscriptionRule::first();
        $annualDiscount = $rule ? $rule->annual_discount : 15;

        // Get selected customer's existing subscription data if provided
        $selectedCustomer = null;
        $existingModules = [];
        $existingSubscription = null;

        if (request()->has('customer_id')) {
            $selectedCustomer = Admin::with('adminDetail')->find(request()->customer_id);
            if ($selectedCustomer && $selectedCustomer->adminDetail) {
                $existingSubscription = $selectedCustomer->adminDetail;
                $existingModules = $selectedCustomer->adminDetail->subscription_modules ?? [];
            }
        }

        return view('admin.customer-subscriptions', compact('customers', 'modules', 'allPermissions', 'annualDiscount', 'selectedCustomer', 'existingModules', 'existingSubscription'));
    }

    /**
     * Store customer subscription
     */
    public function storeCustomerSubscription(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:admins,id',
            'modules' => 'required|array',
            'modules.*' => 'exists:permissions,id',
            'setup_fee' => 'nullable|numeric|min:0',
            'billing_frequency' => 'required|in:monthly,annual',
        ]);

        try {
            $customer = Admin::find($request->customer_id);
            $newModules = Permission::whereIn('id', $request->modules)->get();

            // Merge with existing modules if any
            $existingModuleIds = [];
            if ($customer->adminDetail && $customer->adminDetail->subscription_modules) {
                $existingModuleIds = $customer->adminDetail->subscription_modules;
            }

            // Merge new modules with existing ones (avoid duplicates)
            $allModuleIds = array_unique(array_merge($existingModuleIds, $request->modules));
            $allModules = Permission::whereIn('id', $allModuleIds)->get();

            // Calculate totals for all modules
            $monthlyTotal = $allModules->sum('monthly_price');
            $setupFee = $request->setup_fee ?? 0;

            $annualTotal = $monthlyTotal * 12;
            $rule = SubscriptionRule::first();
            $discount = $rule ? $rule->annual_discount : 15;
            $discountAmount = ($annualTotal * $discount) / 100;
            $annualTotalWithDiscount = $annualTotal - $discountAmount;

            // Give permissions to customer (merge with existing)
            $existingPermissions = $customer->getAllPermissions()->pluck('name')->toArray();
            $newPermissions = $newModules->pluck('name')->toArray();
            $allPermissions = array_unique(array_merge($existingPermissions, $newPermissions));
            $customer->syncPermissions($allPermissions);

            // Store subscription data in admin details
            if ($customer->adminDetail) {
                $customer->adminDetail->update([
                    'subscription_type' => $request->billing_frequency,
                    'subscription_modules' => $allModuleIds,
                    'monthly_charge' => $monthlyTotal,
                    'annual_charge' => $annualTotalWithDiscount,
                    'setup_fee' => $setupFee,
                ]);
            } else {
                // Create admin detail if it doesn't exist
                $customer->adminDetail()->create([
                    'admin_id' => $customer->id,
                    'subscription_type' => $request->billing_frequency,
                    'subscription_modules' => $allModuleIds,
                    'monthly_charge' => $monthlyTotal,
                    'annual_charge' => $annualTotalWithDiscount,
                    'setup_fee' => $setupFee,
                ]);
            }

            return redirect()->back()->with('success', 'Customer subscription updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating subscription: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Get customer module permissions
     */
    public function getCustomerModulePermissions($customerId)
    {
        try {
            // Store customer module permissions in admin_details JSON field
            $customer = Admin::with('adminDetail')->find($customerId);

            if (!$customer || !$customer->adminDetail) {
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }

            // Get permissions from admin_details JSON field
            $modulePermissions = $customer->adminDetail->permissions ?? [];

            return response()->json([
                'success' => true,
                'data' => $modulePermissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching module permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update customer module access
     */
    public function updateCustomerModuleAccess(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:admins,id',
                'module' => 'required|string',
                'access' => 'sometimes|boolean',
                'permissions' => 'sometimes|array'
            ]);

            $customerId = $request->input('employee_id');
            $module = $request->input('module');
            $submodulePermissions = $request->input('permissions', []);

            $customer = Admin::with('adminDetail')->find($customerId);

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found'
                ], 404);
            }

            // Get existing permissions
            $existingPermissions = $customer->adminDetail->permissions ?? [];

            // Update with new submodule permissions
            foreach ($submodulePermissions as $permissionKey => $permissionData) {
                $existingPermissions[$permissionKey] = $permissionData;
            }

            // Ensure main module has access if any submodule has access
            if (!empty($submodulePermissions)) {
                $existingPermissions[$module] = [
                    'has_access' => true,
                    'can_view' => true,
                    'can_create' => true,
                    'can_edit' => true,
                    'can_delete' => true
                ];
            }

            // Update admin_details
            $customer->adminDetail->update([
                'permissions' => $existingPermissions
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Module access updated successfully',
                'data' => $existingPermissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating module access: ' . $e->getMessage()
            ], 500);
        }
    }
}
