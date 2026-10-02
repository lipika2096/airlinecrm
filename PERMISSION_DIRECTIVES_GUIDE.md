# Permission Directives Implementation Guide

This guide explains how to implement permission checks in blade pages using the module_permissions table.

## Available Blade Directives

The following directives are available in AppServiceProvider.php:

- `@canAccessModule('module-name')` - Check if user has access to a module
- `@canAccessSubmodule('module.submodule')` - Check if user has access to a specific submodule
- `@canView('module.submodule')` - Check if user has view permission
- `@canCreate('module.submodule')` - Check if user has create permission
- `@canEdit('module.submodule')` - Check if user has edit permission
- `@canDelete('module.submodule')` - Check if user has delete permission

## Implementation Examples

### 1. Add/Create Button
```blade
@canCreate('hr.add-staff')
    <a href="{{ route('staff.add-staff') }}" class="btn add-btn">
        <i class="fa fa-plus"></i> Add Employee
    </a>
@endcanCreate
```

### 2. View/Edit/Delete Actions in Table
```blade
<td>
    <div class="action-icons">
        @canView('hr.staff-list')
            <a href="{{ route('staff.view-staff', ['id' => $data->id]) }}" class="action-icon">
                <i class="fa fa-eye"></i>
            </a>
        @endcanView

        @canEdit('hr.staff-list')
            <a href="#" data-bs-toggle="modal" data-bs-target="#edit_{{ $data->id }}" class="action-icon">
                <i class="fa fa-pencil"></i>
            </a>
        @endcanEdit

        @canDelete('hr.staff-list')
            <a href="#" class="action-icon delete-btn" data-id="{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </a>
        @endcanDelete
    </div>
</td>
```

### 3. Reports Button
```blade
@canView('travel-agent.reports')
    <a href="{{ route('staff.agent-reports') }}" class="btn btn-primary">
        <i class="fa fa-chart-bar"></i> Reports
    </a>
@endcanView
```

### 4. Submodule Menu Items in Sidebar
```blade
@canAccessSubmodule('hr.add-staff')
    <li>
        <a href="{{ route('staff.add-staff') }}">Add Staff</a>
    </li>
@endcanAccessSubmodule
```

## Module and Submodule Names

Based on the RolePermissionSeeder, here are the available modules and submodules:

### HR
- `hr.add-staff`
- `hr.staff-list`
- `hr.manage-staff`
- `hr.holidays-leaves`
- `hr.pending-approvals`
- `hr.user-profiles`
- `hr.user-rights`
- `hr.reports`

### Travel Agent
- `travel-agent.travel-partners-list`
- `travel-agent.library`
- `travel-agent.reports`
- `travel-agent.case-history`

### Airline
- `airline.airlines-list`
- `airline.library`
- `airline.reports`

### Sales & Marketing
- `sales-marketing.add-sales-lead`
- `sales-marketing.record-sales-call-visit`

### Reservations
- `reservations.manage-reservations`
- `reservations.new-reservations`

### Accounts
- `accounts.account`
- `accounts.bookings`
- `accounts.new-booking`
- `accounts.add-account`
- `accounts.view-accounts`
- `accounts.customer-ledger`
- `accounts.general-ledger`
- `accounts.supplier-ledger`
- `accounts.expense-entry`
- `accounts.payment-pool`
- `accounts.bank-accounts`
- `accounts.view-invoice`
- `accounts.booking-accounts`

### Support Tickets
- `support-tickets.dashboard`
- `support-tickets.my-created-tickets`
- `support-tickets.assigned-tickets`
- `support-tickets.create-ticket`

### B2B Partners
- `b2b-partners.b2b-partners-list`

### B2C Customers
- `b2c-customers.b2c-customers-list`

### Customer
- `customer.add-customer`
- `customer.manage-customer`
- `customer.library`
- `customer.reports`
- `customer.case-history`
- `customer.b2c-customers`

### System Admin
- `system-admin.add-departments`
- `system-admin.add-designations`
- `system-admin.add-category`
- `system-admin.add-duties`
- `system-admin.add-status`
- `system-admin.add-ticket-status`
- `system-admin.add-leave-types`
- `system-admin.products-services`
- `system-admin.add-agent-types`
- `system-admin.add-report-types`
- `system-admin.add-fare-types`
- `system-admin.add-discounts`
- `system-admin.deleted-travel-agents`
- `system-admin.deleted-airlines-list`
- `system-admin.add-customer-types`

### Roles Permissions
- `roles-permissions.manage-modules`

### Sales Packages
- `sales-packages.manage-packages`

### Bank Accounts
- `bank-accounts.my-bank-accounts`

## Files Already Updated

1. `resources/views/admin/employees.blade.php` - HR staff list page
2. `resources/views/admin/b2b-partners/index.blade.php` - B2B partners list page

## Files to Update

Apply the same pattern to the following files based on their functionality:

### HR Module
- `resources/views/admin/add-staff.blade.php`
- `resources/views/admin/manage-staff.blade.php`
- `resources/views/admin/view-staff.blade.php`
- `resources/views/admin/staff-report.blade.php`

### Travel Agent Module
- `resources/views/admin/agent.blade.php`
- `resources/views/admin/agent-library.blade.php`
- `resources/views/admin/agent-reports.blade.php`

### Airline Module
- `resources/views/admin/airlines.blade.php`
- `resources/views/admin/airline-details.blade.php`
- `resources/views/admin/airline-reports.blade.php`

### Accounts Module
- `resources/views/admin/account-index.blade.php`
- `resources/views/admin/add-account.blade.php`
- `resources/views/admin/payment-pool.blade.php`

### Support Tickets Module
- `resources/views/admin/support-tickets/index.blade.php`
- `resources/views/admin/support-tickets/create.blade.php`
- `resources/views/admin/support-tickets/show.blade.php`
- `resources/views/admin/support-tickets/my-created.blade.php`
- `resources/views/admin/support-tickets/assigned.blade.php`

### B2C Customers Module
- `resources/views/admin/b2c-customers/index.blade.php`
- `resources/views/admin/b2c-customers/create.blade.php`
- `resources/views/admin/b2c-customers/edit.blade.php`
- `resources/views/admin/b2c-customers/show.blade.php`

### And all other blade files with CRUD operations

## Important Notes

1. **SuperAdmin and Customers**: These roles have access to all modules by default, so permissions are primarily for Staff users.

2. **Permission Logic**: The `has_access` field in module_permissions is automatically set to `true` if any of the action permissions (view, create, edit, delete) are `true`.

3. **Testing**: After implementing permissions, test with different staff users who have different permission sets to ensure the UI correctly shows/hides elements.

4. **Module Access**: For sidebar menu items, use `@canAccessSubmodule()` to show/hide entire menu sections. For individual actions within pages, use the specific action directives (`@canView`, `@canCreate`, `@canEdit`, `@canDelete`).
