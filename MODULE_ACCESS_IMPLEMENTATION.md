# Module Access Control Implementation

## Overview
This implementation adds module-level access control for staff users, ensuring that staff can only access the modules they've been granted permission for by administrators.

## Components Implemented

### 1. Database Schema
- **ModulePermission Model**: Stores module access permissions for users
  - `employee_id`: The staff user ID
  - `module_name`: The module identifier (e.g., 'hr', 'support-tickets', 'customer')
  - `has_access`: Boolean flag indicating access permission

### 2. Helper Functions (RouteHelper.php)
- `hasModuleAccess($moduleName)`: Checks if current user has access to a specific module
- `getAccessibleModules()`: Returns array of modules accessible to current user
- **Logic**:
  - SuperAdmin: Always returns true (access to all modules)
  - Customer: Always returns true (access to all modules by default)
  - Staff: Checks ModulePermission table for granted access

### 3. Middleware (ModuleAccessMiddleware.php)
- **Purpose**: Protects routes based on module access
- **Usage**: Applied to route groups with module parameter
- **Behavior**:
  - SuperAdmin/Customer: Always allows access
  - Staff: Checks module permissions, redirects to dashboard if denied
  - Returns 403 for JSON requests

### 4. Blade Directive (@canAccessModule)
- **Purpose**: Conditionally show/hide sidebar menu items based on module access
- **Usage**: `@canAccessModule('module-name') ... @endcanAccessModule`
- **Registered in**: AppServiceProvider.php

### 5. Route Updates
- **Module Access Routes**: Moved from admin-only to auth middleware for universal access
  - `update.module.access` - POST route for updating module permissions
  - `employee.module.permissions` - GET route for retrieving user permissions
  - `available.modules` - GET route for available modules

- **Protected Route Groups**: Added module access middleware to staff routes
  - Support Tickets: `module.access:support-tickets`
  - HR Management: `module.access:hr`
  - Travel Agents: `module.access:travel-agent`
  - System Admin: `module.access:system-admin`

### 6. Sidebar Updates
- Added `@canAccessModule` directives to hide/show menu items
- **Modules Protected**:
  - Support Tickets
  - HR (Staff Management)
  - Customer Management
  - B2B Partners
  - B2C Customers
  - System Admin
  - Manage Modules
  - Sales Packages

## Module Names Used
- `support-tickets` - Support ticket management
- `hr` - Human resources and staff management
- `customer` - Customer management
- `b2b-partners` - B2B partner management
- `b2c-customers` - B2C customer management
- `system-admin` - System administration (departments, designations, etc.)
- `manage-modules` - Module/permission management
- `sales-packages` - Sales package management
- `travel-agent` - Travel agent management
- `airline` - Airline management
- `sales-marketing` - Sales and marketing
- `accounts` - Accounts and financial management
- `reservations` - Booking and reservation management

## Usage Example

### Setting Module Access for Staff
```php
// Via the UI in view-profile.blade.php
// Toggle switches grant/revoke module access
// Updates ModulePermission table via AJAX

// Or programmatically:
ModulePermission::updateOrCreate(
    [
        'user_id' => $staffId,
        'module_name' => 'hr'
    ],
    [
        'has_access' => true
    ]
);
```

### Protecting Routes
```php
Route::middleware(['module.access:hr'])->group(function () {
    Route::get('employees', [EmployeeController::class, 'allEmployees']);
    Route::get('add-staff', [EmployeeController::class, 'addStaff']);
    // ... other HR routes
});
```

### Conditionally Showing Menu Items
```blade
@canAccessModule('hr')
    <li class="submenu">
        <a href="#"><i class="la la-user"></i> <span>HR</span></a>
        <ul>
            <li><a href="{{ route('staff.employees') }}">Staff List</a></li>
            <!-- ... other HR menu items -->
        </ul>
    </li>
@endcanAccessModule
```

## Benefits
1. **Security**: Staff can only access approved modules
2. **Flexibility**: Easy to grant/revoke module access via UI
3. **Scalability**: Module-based access control can be extended
4. **User Experience**: Menu items automatically hide for inaccessible modules
5. **Consistency**: Both UI and route-level protection

## Testing Recommendations
1. Test module access toggling in staff profile view
2. Verify unauthorized access attempts are blocked
3. Check sidebar menu items reflect current permissions
4. Test SuperAdmin and Customer access (should have full access)
5. Verify AJAX requests to protected routes are properly handled

## Future Enhancements
- Add role-based module templates
- Implement module access expiration
- Add audit logging for permission changes
- Create bulk permission assignment interface
- Add module dependency management