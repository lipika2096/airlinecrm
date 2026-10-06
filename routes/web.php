<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process as SymfonyProcess;
use App\Http\Controllers\dashboard\{
    DashboardController,
    AppController,
    EmployeeController,
    TaskController,
    LeadController,
    TicketController,
    SalesController,
    AccountingController,
    PayrollController,
    PolicyController,
    ReportController,
    PerformanceController,
    GoalController,
    TrainingController,
    HRController,
    AdministrationController,
    JobController,
    KnowledgebaseController,
    ActivityController,
    UserController,
    SettingController,
    ProfileController,
    SubscriptionController,
    AdminController,
    AirlineController,
    AgentController,
    GroupController,
    SalesLeadController,
    SupplierController,
    AirTicketController,
    FareConditionController,
    CommissionController,
    EventStatusController,
    SectorController,
    HoldController,
    WalletController,
    SupportTicketController,
    SupportTicketReportController,
    TicketStatusController,
    DashboardSupportTicketController,
    WalletRequestController,
    InventoryController,
    AdminHoldController,
    AirlineLibraryController,
    GroupRequestController,
    AirlineDetailController,
    DelaycodeController,
    B2BPartnerController,
    CategoryController,
    DutyController,
    LeaveTypeController,
    AccountController,
    StaffReportController,
    AgentReportController,
    FlightController,
    LicenseApprovalController,
    AgentLibraryController,
    FareTypeController,
    DiscountController,
    RolePermissionController,
    CustomerReportController,
    CustomerController,
    ReservationController,
    SalesPackageController,
    BankAccountController,
    PaymentPoolController,
    PasswordResetController,
    DepartmentModuleController,
    ModuleController
};
use App\Http\Controllers\B2CCustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StaffController;

// Notification routes (accessible from all user types)
Route::get('notifications/api', [NotificationController::class, 'index'])->name('notifications.api');
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

Route::get('/run-migration', function () {

    Artisan::call('migrate', [
        '--force' => true
    ]);

    return nl2br(Artisan::output());

});

Route::get('/view-table/{table}', function ($table) {
    $tables = DB::select("SHOW TABLES");
    $tableNames = [];
    foreach ($tables as $t) {
        $tableNames[] = array_values((array)$t)[0];
    }

    if (!in_array($table, $tableNames)) {
        return "Table '$table' not found. Available tables: " . implode(', ', $tableNames);
    }

    $columns = DB::select("DESCRIBE $table");
    $data = DB::table($table)->get();

    $html = "<h1>Table: $table</h1>";
    $html .= "<h2>Total Records: " . $data->count() . "</h2>";

    if ($data->isEmpty()) {
        $html .= "<p>No data found in this table.</p>";
    } else {
        $html .= "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        $html .= "<thead><tr>";
        foreach ($columns as $column) {
            $html .= "<th>{$column->Field}</th>";
        }
        $html .= "</tr></thead>";
        $html .= "<tbody>";
        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ($columns as $column) {
                $value = $row->{$column->Field} ?? '';
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
    }

    $html .= "<br><br><h3>Available Tables:</h3><ul>";
    foreach ($tableNames as $tableName) {
        $html .= "<li><a href='/view-table/$tableName'>$tableName</a></li>";
    }
    $html .= "</ul>";

    return $html;
});

Route::get('/run-seeder', function () {

    Artisan::call('db:seed', [
        '--force' => true
    ]);

    return nl2br(Artisan::output());

});

Route::get('/publish-pagination', function () {

    Artisan::call('vendor:publish', [
        // '--tag' => 'laravel-pagination'
        '--force' => true
    ]);

    return nl2br(Artisan::output());

});

Route::get('/clear-cache', function () {

    Artisan::call('cache:clear');
    $output = Artisan::output();

    Artisan::call('config:clear');
    $output .= Artisan::output();

    Artisan::call('route:clear');
    $output .= Artisan::output();

    Artisan::call('view:clear');
    $output .= Artisan::output();

    Artisan::call('config:cache');
    $output .= Artisan::output();

    // Artisan::call('route:cache');
    // $output .= Artisan::output();

    return nl2br($output);

});

Route::get('drop-existing',[AccountController::class, 'dropBookingTables']);

Route::name('admin.')->middleware(['admin'])->group(function () {
    Route::get('roles-permissions', [ModuleController::class, 'index'])->name('roles-permissions.index');
    Route::post('modules/update', [ModuleController::class, 'update'])->name('modules.update');
    Route::post('modules/toggle-status', [ModuleController::class, 'toggleStatus'])->name('modules.toggle-status');
    //Route::get('modules/{moduleId}/submodules', [ModuleController::class, 'getSubmodules'])->name('modules.submodules');
    Route::get('modules/{moduleId}/permissions', [ModuleController::class, 'getModulePermissions'])->name('modules.get.permissions');
    Route::post('modules/save-permissions', [ModuleController::class, 'saveModulePermissions'])->name('modules.save.permissions');
    //Route::post('submodules', [ModuleController::class, 'storeSubmodule'])->name('submodules.store');
    //Route::put('submodules/{id}', [ModuleController::class, 'updateSubmodule'])->name('submodules.update');
    //Route::delete('submodules/{id}', [ModuleController::class, 'deleteSubmodule'])->name('submodules.delete');
    Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'getRolePermissions'])->name('roles.getPermissions');
    Route::put('/roles/update', [RolePermissionController::class, 'update'])->name('roles.update');
    Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store');
    Route::post('/update-permission-status', [RolePermissionController::class, 'updatePermissionStatus'])->name('update.permission.status');
    Route::post('/update-staff-permission', [RolePermissionController::class, 'updateStaffPermission'])->name('update.staff.permission');

    Route::get('admin-view', [AdminController::class, 'showAllAdmin'])->name('admin.view');
    Route::get('admin-add-customer', [AdminController::class, 'addCustomer'])->name('admin.add-customer');
    Route::post('admin-view/store', [AdminController::class, 'registerAdmin'])->name('admin.store');
    Route::patch('admin-view/update/{id}', [AdminController::class, 'editAdmin'])->name('customer.update');

    Route::get('admin-view/kyc/document', [AdminController::class, 'kycDocumentIndex'])->name('kyc.documents');
    Route::patch('admin-view/kyc/document/{id}', [AdminController::class, 'kycDocument'])->name('kyc.document.store');
    Route::get('customer/view/{id}', [CustomerController::class, 'customerProfile'])->name('customer.view');
    Route::post('/update-customer-role', [CustomerController::class, 'updateRole'])->name('update.customer.role');
    Route::patch('customer/update-package/{id}', [CustomerController::class, 'updatePackage'])->name('customer.update-package');

    Route::post('admin/update-customer-permission', [CustomerController::class, 'updatePermission'])->name('update.customer.permission');


});

// Password reset routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.send-link');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Home route
Route::get('/', function () {
    return view('admin.index');
})->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.post.login');
Route::post('/customer/login', [AdminController::class, 'staffLogin'])->name('customer.post.login');
Route::post('/staff/login', [StaffController::class, 'login'])->name('staff.login');
Route::get('/admin/toggle-status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggle.status');

// SuperAdmin routes - only accessible by users with superAdmin role
Route::prefix('superadmin')->name('admin.')->middleware(['admin'])->group(function () {

    Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');

    Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    // Booking routes for SuperAdmin
    Route::get('booking', [AccountController::class, 'bookingIndex'])->name('booking.index');
    Route::get('booking/create', [AccountController::class, 'createBooking'])->name('booking.create');
    Route::get('booking/edit/{id}', [AccountController::class, 'editBooking'])->name('booking.edit');
    Route::post('booking/store', [AccountController::class, 'storeBooking'])->name('booking.store');
    Route::put('booking/update/{id}', [AccountController::class, 'updateBooking'])->name('booking.update');
    Route::post('booking/save-customer', [AccountController::class, 'saveCustomer'])->name('booking.save-customer');
    Route::post('booking/save-customer', [AccountController::class, 'saveCustomer'])->name('booking.save-customer');
    Route::get('booking/invoice/{id}', [AccountController::class, 'generateInvoice'])->name('booking.invoice');

    // Module access routes for SuperAdmin
    Route::post('/update-module-access', [EmployeeController::class, 'updateModuleAccess'])->name('employee.update.module.access');
    Route::get('/employee-module-permissions/{id}', [EmployeeController::class, 'getEmployeeModulePermissions'])->name('employee.module.permissions');
    Route::get('/available-modules', [EmployeeController::class, 'getAvailableModules'])->name('available.modules');

    // Submodule management routes
    Route::get('modules/{moduleId}/submodules', [ModuleController::class, 'getSubmodules'])->name('modules.submodules');
    Route::post('submodules', [ModuleController::class, 'storeSubmodule'])->name('submodules.store');
    Route::put('submodules/{id}', [ModuleController::class, 'updateSubmodule'])->name('submodules.update');
    Route::delete('submodules/{id}', [ModuleController::class, 'deleteSubmodule'])->name('submodules.delete');

    // B2C Customers routes
    Route::get('b2c-customers', [B2CCustomerController::class, 'index'])->name('b2c-customers.index');
    Route::get('b2c-customers/create', [B2CCustomerController::class, 'create'])->name('b2c-customers.create');
    Route::post('b2c-customers', [B2CCustomerController::class, 'store'])->name('b2c-customers.store');
    Route::get('b2c-customers/{id}', [B2CCustomerController::class, 'show'])->name('b2c-customers.show');
    Route::get('b2c-customers/{id}/edit', [B2CCustomerController::class, 'edit'])->name('b2c-customers.edit');
    Route::put('b2c-customers/{id}', [B2CCustomerController::class, 'update'])->name('b2c-customers.update');
    Route::delete('b2c-customers/{id}', [B2CCustomerController::class, 'destroy'])->name('b2c-customers.destroy');
    Route::patch('b2c-customers/{id}/toggle-status', [B2CCustomerController::class, 'toggleStatus'])->name('b2c-customers.toggle-status');
    
    // B2C Passenger routes
    Route::get('b2c-customers/{customerId}/passengers/create', [B2CCustomerController::class, 'addPassenger'])->name('b2c-customers.passengers.create');
    Route::post('b2c-customers/{customerId}/passengers', [B2CCustomerController::class, 'storePassenger'])->name('b2c-customers.passengers.store');
    Route::get('b2c-customers/{customerId}/passengers/{passengerId}/edit', [B2CCustomerController::class, 'editPassenger'])->name('b2c-customers.passengers.edit');
    Route::put('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'updatePassenger'])->name('b2c-customers.passengers.update');
    Route::delete('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'deletePassenger'])->name('b2c-customers.passengers.delete');
    
    // B2C Notes routes
    Route::post('b2c-customers/{customerId}/notes', [B2CCustomerController::class, 'storeNote'])->name('b2c-customers.notes.store');
    Route::delete('b2c-customers/{customerId}/notes/{noteId}', [B2CCustomerController::class, 'deleteNote'])->name('b2c-customers.notes.delete');
    
    // B2C Documents routes
    Route::post('b2c-customers/{customerId}/documents', [B2CCustomerController::class, 'storeDocument'])->name('b2c-customers.documents.store');
    Route::delete('b2c-customers/{customerId}/documents/{documentId}', [B2CCustomerController::class, 'deleteDocument'])->name('b2c-customers.documents.delete');
    Route::get('b2c-customers/search', [B2CCustomerController::class, 'search'])->name('b2c-customers.search');

    // Include all other admin routes here
    Route::get('/get-departments', [EmployeeController::class, 'getDepartments']);
    Route::get('/get-employees/{department}', [EmployeeController::class, 'getEmployeesByDepartment']);
    Route::get('/get-employees/{user_id}', [EmployeeController::class, 'getEmployeesByUsers']);

    // Accounting routes
    Route::get('categories/view', [CategoryController::class, 'categoriesIndex'])->name('categories.view');
    Route::post('categories/store', [CategoryController::class, 'storeCategory'])->name('categories.store');
    Route::put('categories/update/{id}', [CategoryController::class, 'updateCategory'])->name('categories.update');
    Route::post('/update-category-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');

    //Duties routes
    Route::get('duties', [DutyController::class, 'duties'])->name('duties');
    Route::post('duties/store', [DutyController::class, 'storeDuty'])->name('duties.store');
    Route::put('duties/update/{id}', [DutyController::class, 'updateDuty'])->name('duties.update');
    Route::post('/update-duty-status', [DutyController::class, 'updateStatus'])->name('duties.updateStatus');

    Route::get('fare-types', [FareTypeController::class, 'index'])->name('faretypes');
    Route::post('fare-types/store', [FareTypeController::class, 'store'])->name('faretypes.store');
    Route::put('fare-types/update/{id}', [FareTypeController::class, 'update'])->name('faretypes.update');
    Route::delete('fare-types/delete/{id}', [FareTypeController::class, 'delete'])->name('faretypes.delete');
    Route::get('discounts', [DiscountController::class, 'index'])->name('discounts');
    Route::post('discounts/store', [DiscountController::class, 'discountStore'])->name('discounts.store');
    Route::put('discounts/update/{id}', [DiscountController::class, 'discountUpdate'])->name('discounts.update');
    Route::delete('discounts/delete/{id}', [DiscountController::class, 'discountDelete'])->name('discounts.delete');

    //LeaveType rotes
    Route::get('leavetypes', [LeaveTypeController::class, 'leaveType'])->name('leave-type');
    Route::post('leavetypes/store', [LeaveTypeController::class, 'storeLeaveType'])->name('leave-type.store');
    Route::put('leavetypes/update/{id}', [LeaveTypeController::class, 'updateLeaveType'])->name('leave-type.update');
    Route::delete('leavetypes/delete/{id}', [LeaveTypeController::class, 'deleteLeaveType'])->name('leave-type.delete');
    Route::post('/update-leavetype-status', [LeaveTypeController::class, 'updateStatus'])->name('leave-type.updateStatus');

    Route::get('coming-soon', [DashboardController::class, 'comingSoon'])->name('comingSoon');

    //Project Routes
    Route::get('project-view', function(){
        return view('admin.project-view');
    })->name('project-view');

    // App routes
    Route::get('case-history', [AgentController::class, 'caseHistorySearch'])->name('view.case-history');
    Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
    Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
    Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');

    Route::get('customer/case-history', [CustomerController::class, 'caseHistorySearch'])->name('customer.case-history');
    Route::post('customer/casehistory/store', [CustomerController::class, 'caseStore'])->name('customer.case.store');
    Route::patch('customer/casehistory/update/{id}', [CustomerController::class, 'caseUpdate'])->name('customer.cases.update');
    Route::post('customer/casehistory/close/{id}', [CustomerController::class, 'caseClose'])->name('customer.cases.close');

    Route::post('customer/conversation/store', [CustomerController::class, 'conversationStore'])->name('customer.conversation.store');
    Route::post('customer/address/store', [CustomerController::class, 'AddressStore'])->name('customer.address.store');
    Route::post('customer/contact/store', [CustomerController::class, 'ContactStore'])->name('customer.contact.store');
    Route::post('customer/contact/update/{id}', [CustomerController::class, 'contactUpdate'])->name('customer.contact.update');
    Route::delete('customer/contact/delete/{id}', [CustomerController::class, 'contactDelete'])->name('customer.contact.delete');
    Route::post('customer/address/update/{id}', [CustomerController::class, 'addressUpdate'])->name('customer.address.update');

    Route::get('airlines-details', [AirlineDetailController::class, 'index'])->name('airlines-details');
    Route::post('airlines-details/store', [AirlineController::class, 'store'])->name('airlines-details.store');
    Route::patch('/airline-details/{airlineDetail}', [AirlineController::class, 'update'])->name('airlines-details.update');
    Route::delete('/airline-details/delete/{airlineDetail}', [AirlineController::class, 'delete'])->name('airlines-details.delete');
    Route::delete('/admin/airline-details/{airlineDetail}', [AirlineDetailController::class, 'destroy'])->name('airlines-details.destroy');

    Route::get('/delay-code', [DelaycodeController::class, 'delay'])->name('delay.code');
    Route::get('/delay-code-category', [CategoryController::class, 'delaycategory'])->name('delay.code.category');
    Route::get('/origin', [CategoryController::class, 'origin'])->name('origin');
    Route::post('origin/store', [CategoryController::class, 'originstore'])->name('origins.store');
    Route::put('origin/{origin}/update', [CategoryController::class, 'originupdate'])->name('origins.update');
    Route::delete('origin/{origin}', [CategoryController::class, 'origindestroy'])->name('origins.destroy');
    Route::get('/destination', [CategoryController::class, 'destination'])->name('destination');
    Route::post('destination/store', [CategoryController::class, 'destinationstore'])->name('destinations.store');
    Route::put('destination/{destination}/update', [CategoryController::class, 'destinationupdate'])->name('destinations.update');
    Route::delete('destination/{destination}', [CategoryController::class, 'destinationdestroy'])->name('destinations.destroy');
    Route::post('delaycategories/store', [CategoryController::class, 'store'])->name('delay_code_categories.store');
    Route::put('delaycategories/{id}/update', [CategoryController::class, 'update'])->name('delay_code_categories.update');
    Route::delete('delaycategories/{id}/destroy', [CategoryController::class, 'destroy'])->name('delay_code_categories.destroy');
    Route::post('delay-code/store', [DelaycodeController::class, 'store'])->name('delaycodes.store');
    Route::put('delay-code/{id}/update', [DelaycodeController::class, 'update'])->name('delaycodes.update');
    Route::delete('delay-code/{id}/destroy', [DelaycodeController::class, 'destroy'])->name('delaycodes.destroy');

    Route::get('/agent/library', [AgentLibraryController::class, 'index'])->name('agent-library');
    Route::post('agent/library/store', [AgentLibraryController::class, 'store'])->name('agent.library.store');

    Route::get('library', [AirlineLibraryController::class, 'library'])->name('airline-library');
    Route::post('library/store', [AirlineLibraryController::class, 'store'])->name('library.store');
    Route::post('library/airine/store', [AirlineLibraryController::class, 'viewstore'])->name('library.viewstore');
    Route::get('library/{library}/documents', [AirlineLibraryController::class, 'viewDocuments'])->name('library.documents');

    Route::get('license', [LicenseApprovalController::class, 'index'])->name('license');
    Route::post('license/store', [LicenseApprovalController::class, 'store'])->name('license.store');
    Route::patch('license_approvals/{licenseApproval}/status', [LicenseApprovalController::class, 'updateStatus'])->name('license_approvals.updateStatus');
    Route::delete('license_approvals/{licenseApproval}', [LicenseApprovalController::class, 'destroy'])->name('license_approvals.destroy');
    Route::get('flights', [FlightController::class, 'index'])->name('flights');
    Route::get('flights/create', [FlightController::class, 'create'])->name('flights.create');
    Route::post('flights', [FlightController::class, 'store'])->name('flights.store');
    Route::get('flights/{flight}', [FlightController::class, 'show'])->name('flights.show');
    Route::get('flights/{flight}/edit', [FlightController::class, 'edit'])->name('flights.edit');
    Route::put('flights/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::patch('flights/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::delete('flights/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');

    Route::get('wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('wallet/store', [WalletController::class, 'store'])->name('wallet.store');
    Route::put('wallets/edit/{id}', [WalletController::class, 'update'])->name('wallet.update');
    Route::delete('wallets/{id}', [WalletController::class, 'destroy'])->name('wallet.destroy');

    Route::get('walletrequest', [WalletRequestController::class, 'index'])->name('walletrequest');

    Route::get('sectors', [SectorController::class, 'index'])->name('sectors');
    Route::post('store-sector', [SectorController::class, 'store'])->name('sector.store');
    Route::put('update-sector/{id}', [SectorController::class, 'update'])->name('sector.update');
    Route::delete('delete-sector/{id}', [SectorController::class, 'destroy'])->name('sector.delete');

    Route::get('inventories', [InventoryController::class, 'index'])->name('inventories');
    Route::get('inventories/expiry', [InventoryController::class, 'expiryinventory'])->name('expiry.inventories');
    Route::post('inventories/store', [InventoryController::class, 'store'])->name('inventory.store');

    Route::get('admin-holds', [AdminHoldController::class, 'index'])->name('adminholds');
    Route::get('/view-holds/{id}', [HoldController::class, 'view'])->name('view-holds');
    Route::get('/edit-hold/{id}', [HoldController::class, 'edit'])->name('edit-hold');
    Route::post('/edit-hold/{id}', [HoldController::class, 'update'])->name('edit-hold');
    Route::get('holds-confirm/', [HoldController::class, 'confirmHold'])->name('holdsconfirm');

    Route::delete('wallet/delete', [AgentController::class, 'deleteWallet'])->name('wallet.delete');
    Route::post('store-wallet', [AgentController::class, 'storeWallet'])->name('store.wallet');
    Route::post('agentgroups/store', [AgentController::class, 'groupstore'])->name('agentgroups.store');
    Route::put('agentgroups/update/{id}', [AgentController::class, 'groupupdate'])->name('agentgroups.update');
    Route::delete('wallet/requests/{id}', [AgentController::class, 'deleteWalletRequest'])->name('wallet.requests.delete');
    Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
    Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
    Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
    Route::post('airline/target/store', [AirlineController::class, 'targetStore'])->name('airline.target.store');
    Route::post('staff/approvedStaff/store', [EmployeeController::class, 'approvedStaffRightsStore'])->name('staff.approved-staff-rights.store');
    Route::post('airline/approvedStaff/store', [AirlineController::class, 'approvedStaffRightsStore'])->name('airline.approved-staff-rights.store');
    Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
    Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
    Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
    Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
    Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
    Route::get('agent/update/{id}', [AgentController::class, 'update'])->name('agent.update');
    Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
    Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
    Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
    Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');
    Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
    Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
    Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
    Route::post('agent/general/update/{id}', [AgentController::class, 'generalUpdate'])->name('agent.general.update');
    Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
    Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
    Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::get('events', [AppController::class, 'calendar'])->name('events');
    Route::post('events/store', [AppController::class, 'store'])->name('events.store');
    Route::patch('events/update/{id}', [AppController::class, 'update'])->name('events.update');
    Route::get('airlines', [AirlineController::class, 'index'])->name('airlines');
    Route::post('airlines/store', [AirlineController::class, 'store'])->name('airlines.store');
    Route::patch('airlines/edit/{id}', [AirlineController::class, 'update'])->name('airlines.update');
    Route::get('airlines/view/{id}', [AirlineController::class, 'view'])->name('airlines.view');
    Route::get('airlines/get-special-fare/{id}', [AirlineController::class, 'searchSpecialFare'])->name('airlines.special.fare');
    Route::post('airlines/aircraft/', [AirlineController::class, 'aircraftStore'])->name('airline.aircraft.store');
    Route::post('airlines/fleet/', [AirlineController::class, 'fleetStore'])->name('airline.fleet.store');
    Route::patch('airlines/aircraft/update/{id}', [AirlineController::class, 'aircraftUpdate'])->name('airline.aircraft.update');
    Route::delete('airlines/aircraft/delete/{id}', [AirlineController::class, 'aircraftDelete'])->name('airline.aircraft.destroy');
    Route::post('airlines/fleet/update/{id}', [AirlineController::class, 'fleetUpdate'])->name('airline.fleet.update');
    Route::delete('airlines/fleet/delete/{id}', [AirlineController::class, 'fleetDelete'])->name('airline.fleet.destroy');
    Route::post('airlines/approved-staff/', [AirlineController::class, 'approvedStaffStore'])->name('airline.approvedstaff.store');
    Route::post('airlines/approved-staff/upadte/{id}', [AirlineController::class, 'approvedStaffUpdate'])->name('airline.approvedstaff.update');
    Route::get('agent', [AgentController::class, 'index'])->name('agents');
    Route::get('deleted/agent', [AgentController::class, 'deletedAgent'])->name('deleted.agents');

    // B2B Partners routes
    Route::get('b2b-partners', [B2BPartnerController::class, 'index'])->name('b2b-partners');
    Route::get('b2b-partners/create', [B2BPartnerController::class, 'create'])->name('b2b-partners.create');
    Route::post('b2b-partners/store', [B2BPartnerController::class, 'store'])->name('b2b-partners.store');
    Route::get('b2b-partners/{id}', [B2BPartnerController::class, 'show'])->name('b2b-partners.show');
    Route::get('b2b-partners/{id}/edit', [B2BPartnerController::class, 'edit'])->name('b2b-partners.edit');
    Route::put('b2b-partners/{id}', [B2BPartnerController::class, 'update'])->name('b2b-partners.update');
    Route::delete('b2b-partners/{id}', [B2BPartnerController::class, 'destroy'])->name('b2b-partners.destroy');
    Route::post('b2b-partners/{partnerId}/contacts', [B2BPartnerController::class, 'storeContact'])->name('b2b-partners.contacts.store');
    Route::put('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'updateContact'])->name('b2b-partners.contacts.update');
    Route::delete('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'deleteContact'])->name('b2b-partners.contacts.destroy');
    Route::post('b2b-partners/{partnerId}/documents', [B2BPartnerController::class, 'storeDocument'])->name('b2b-partners.documents.store');
    Route::delete('b2b-partners/documents/{id}', [B2BPartnerController::class, 'deleteDocument'])->name('b2b-partners.documents.destroy');
    Route::post('b2b-partners/{partnerId}/notes', [B2BPartnerController::class, 'storeNote'])->name('b2b-partners.notes.store');
    Route::delete('b2b-partners/notes/{id}', [B2BPartnerController::class, 'deleteNote'])->name('b2b-partners.notes.destroy');
    Route::delete('b2b-partners/airlines/{id}', [B2BPartnerController::class, 'deleteAirline'])->name('b2b-partners.airlines.destroy');
    Route::delete('b2b-partners/products/{id}', [B2BPartnerController::class, 'deleteProduct'])->name('b2b-partners.products.destroy');
    Route::get('b2b-partners/reports', [B2BPartnerController::class, 'reports'])->name('b2b-partners.reports');
    Route::post('b2b-partners/generate-report', [B2BPartnerController::class, 'generateReport'])->name('b2b-partners.generate-report');
    Route::get('b2b-partners/search', [B2BPartnerController::class, 'search'])->name('b2b-partners.search');

    // Products routes
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Suppliers routes
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::patch('suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/delete/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Supplier Contact routes
    Route::post('suppliers/{supplierId}/contacts', [SupplierController::class, 'storeContact'])->name('suppliers.contacts.store');
    Route::patch('suppliers/{supplierId}/contacts/{contactId}', [SupplierController::class, 'updateContact'])->name('suppliers.contacts.update');
    Route::delete('suppliers/{supplierId}/contacts/{contactId}', [SupplierController::class, 'destroyContact'])->name('suppliers.contacts.destroy');

    // Supplier Account routes
    Route::post('suppliers/{supplierId}/accounts', [SupplierController::class, 'storeAccount'])->name('suppliers.accounts.store');
    Route::patch('suppliers/{supplierId}/accounts/{accountId}', [SupplierController::class, 'updateAccount'])->name('suppliers.accounts.update');
    Route::delete('suppliers/{supplierId}/accounts/{accountId}', [SupplierController::class, 'destroyAccount'])->name('suppliers.accounts.destroy');

    // Supplier Ledger routes
    Route::get('suppliers/{supplierId}/ledger/data', [SupplierController::class, 'getLedgerData'])->name('suppliers.ledger.data');
    Route::post('suppliers/{supplierId}/ledger', [SupplierController::class, 'storeLedgerTransaction'])->name('suppliers.ledger.store');
    Route::patch('suppliers/{supplierId}/ledger/{transactionId}', [SupplierController::class, 'updateLedgerTransaction'])->name('suppliers.ledger.update');
    Route::delete('suppliers/{supplierId}/ledger/{transactionId}', [SupplierController::class, 'destroyLedgerTransaction'])->name('suppliers.ledger.destroy');

    Route::patch('airlines/specialfares/update/{id}', [AirlineController::class, 'specialfaresUpdate'])->name('airline.specialfares.update');
    Route::get('deleted/airlines', [AirlineController::class, 'deletedAirline'])->name('deleted.airlines');
    Route::post('airlines/SLA/store', [AirlineController::class, 'slaStore'])->name('airline.sla.store');
    Route::patch('airlines/SLA/{id}/update', [AirlineController::class, 'slaUpdate'])->name('airline.sla.update');
    Route::patch('airline/sla/toggle-status/{id}', [AirlineController::class, 'slaUpdateStatus']);
    Route::delete('airlines/SLA/{id}/destroy', [AirlineController::class, 'slaDestroy'])->name('airline.sla.destroy');
    Route::post('airlines/approved-staff/update-status', [AirlineController::class, 'approvedStaffUpdateStatus'])->name('airline.approvedstaff.updatestatus');
    Route::post('airlines/head_office/store', [AirlineController::class, 'headOfficeStore'])->name('airline.head_office.store');
    Route::patch('airlines/head_office/{id}/update', [AirlineController::class, 'headOfficeUpdate'])->name('airline.head_office.update');
    Route::delete('airlines/head_office/{id}/destroy', [AirlineController::class, 'headOfficeDestroy'])->name('airline.head_office.destroy');
    Route::get('sales-lead', [SalesLeadController::class, 'index'])->name('saleslead');
    Route::post('sales-lead/store', [SalesLeadController::class, 'store'])->name('saleslead.store');
    Route::post('sales-lead/staff/store', [SalesLeadController::class, 'assignStaff'])->name('saleslead.staff.store');
    Route::patch('sales-lead/edit/{id}', [SalesLeadController::class, 'update'])->name('saleslead.update');
    Route::get('air-tickets', [AirTicketController::class, 'index'])->name('air-tickets');
    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');
    Route::patch('groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
    Route::get('employees-list', [EmployeeController::class, 'Employeeslist'])->name('employees-list');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::delete('/admin/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('employee/view', [EmployeeController::class, 'viewUserProfile'])->name('employee.view-profile');
    Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
    Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    Route::get('employee/rights', [EmployeeController::class, 'viewUserRights'])->name('employee.rights');
    Route::post('employee/rights/store', [EmployeeController::class, 'storeUserRights'])->name('employee.rights.store');
    Route::patch('employee/rights/update/{id}', [EmployeeController::class, 'updateUserRights'])->name('employee.rights.update');
    Route::get('employee/view/{id}', [EmployeeController::class, 'PemployeeProfile'])->name('employee.list-profile');
    Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
    Route::post('view-staff/leaves/store', [EmployeeController::class, 'leavesEmployeeViewStore'])->name('view-staff.leaves.store');
    Route::patch('view-staff/leaves/edit/{id}', [EmployeeController::class, 'leavesEmployeeViewUpdate'])->name('view-staff.leaves.update');
    Route::post('view-staff/read-doc/store', [EmployeeController::class, 'EmployeeReadSignStore'])->name('view-staff.readsign.store');
    Route::patch('view-staff/read-doc/edit/{id}', [EmployeeController::class, 'EmployeeReadSignUpdate'])->name('view-staff.readsign.update');
    Route::post('view-staff/library', [EmployeeController::class, 'storeLibrary'])->name('view-staff.library.store');
    Route::patch('view-staff/library/{id}', [EmployeeController::class, 'libraryupdate'])->name('view-staff.library.update');
    Route::delete('view-staff/library/delete/{id}', [EmployeeController::class, 'libraryDelete'])->name('view-staff.library.destroy');
    Route::post('view-staff/store', [EmployeeController::class, 'leavesStaffStore'])->name('view-staff.store');
    Route::get('holidays', [EmployeeController::class, 'holidays'])->name('holidays');
    Route::post('holidays/store', [EmployeeController::class, 'holidayStore'])->name('holidays.store');
    Route::patch('holidays/edit/{id}', [EmployeeController::class, 'holidayUpdate'])->name('holidays.update');
    Route::get('leaves', [EmployeeController::class, 'leavesAdmin'])->name('leaves');
    Route::get('/get-holidays', [EmployeeController::class, 'getHolidays']);
    Route::post('leaves/store', [EmployeeController::class, 'leavesAdminStore'])->name('leaves.store');
    Route::patch('leaves/edit/{id}', [EmployeeController::class, 'leavesAdminUpdate'])->name('leaves.update');
    Route::get('leave-settings', [EmployeeController::class, 'leaveSettings'])->name('leave-settings');
    Route::get('support-ticket-settings', [SettingController::class, 'supportTicketSettings'])->name('support-ticket-settings');
    Route::post('support-ticket-settings', [SettingController::class, 'updateSupportTicketSettings'])->name('support-ticket-settings.update');
    Route::get('attendance', [EmployeeController::class, 'attendanceAdmin'])->name('attendance');
    Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
    Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
    Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
    Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
    Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');

    // Department Module Management routes
    Route::get('department-modules', [DepartmentModuleController::class, 'index'])->name('department-modules.index');
    Route::post('department-modules/store', [DepartmentModuleController::class, 'store'])->name('department-modules.store');
    Route::post('department-modules/destroy', [DepartmentModuleController::class, 'destroy'])->name('department-modules.destroy');
    Route::post('department-modules/toggle', [DepartmentModuleController::class, 'toggle'])->name('department-modules.toggle');
    Route::get('department-modules/{departmentName}/modules', [DepartmentModuleController::class, 'getModulesByDepartment'])->name('department-modules.get-modules');
    
    // Ticket Status routes
    Route::get('ticket-status', [TicketStatusController::class, 'index'])->name('ticket-status.index');
    Route::get('ticket-status/create', [TicketStatusController::class, 'create'])->name('ticket-status.create');
    Route::post('ticket-status', [TicketStatusController::class, 'store'])->name('ticket-status.store');
    Route::get('ticket-status/{ticketStatus}/edit', [TicketStatusController::class, 'edit'])->name('ticket-status.edit');
    Route::patch('ticket-status/{ticketStatus}', [TicketStatusController::class, 'update'])->name('ticket-status.update');
    Route::delete('ticket-status/{ticketStatus}', [TicketStatusController::class, 'destroy'])->name('ticket-status.destroy');
    Route::get('timesheet', [EmployeeController::class, 'timesheet'])->name('timesheet');
    Route::get('shift-scheduling', [EmployeeController::class, 'shiftScheduling'])->name('shift-scheduling');
    Route::get('overtime', [EmployeeController::class, 'overtime'])->name('overtime');
    Route::post('reportsick/store', [EmployeeController::class, 'storeReportSick'])->name('reportsick.store');
    Route::post('newabsence/store', [EmployeeController::class, 'storeNewAbsence'])->name('newabsence.store');
    Route::get('tasks', [TaskController::class, 'tasks'])->name('tasks');
    Route::get('task-board', [TaskController::class, 'taskBoard'])->name('task-board');
    
    // Support Tickets routes
    Route::get('support-tickets', [SupportTicketController::class, 'dashboardStatistics'])->name('support-tickets.dashboard');

    Route::get('support-tickets/all', [SupportTicketController::class, 'index'])->name('support-tickets.index');

    // Support Tickets Report routes
    Route::get('reports/support-tickets', [SupportTicketReportController::class, 'index'])->name('reports.support-tickets');
    Route::post('reports/support-tickets/generate', [SupportTicketReportController::class, 'generateReport'])->name('reports.support-tickets.generate');
    Route::get('reports/support-tickets/download', [SupportTicketReportController::class, 'downloadReport'])->name('reports.support-tickets.download');
    Route::get('support-tickets/create', [SupportTicketController::class, 'create'])->name('support-tickets.create');
    Route::post('support-tickets', [SupportTicketController::class, 'store'])->name('support-tickets.store');
    Route::get('support-tickets/{id}', [SupportTicketController::class, 'show'])->name('support-tickets.show');
    Route::patch('support-tickets/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('support-tickets.update-status');
    Route::post('support-tickets/{id}/assign', [SupportTicketController::class, 'assign'])->name('support-tickets.assign');
    Route::post('support-tickets/{id}/comment', [SupportTicketController::class, 'addComment'])->name('support-tickets.add-comment');
    Route::post('support-tickets/{id}/rating', [SupportTicketController::class, 'submitRating'])->name('support-tickets.submit-rating');
    Route::post('support-tickets/{id}/internal-note', [SupportTicketController::class, 'addInternalNote'])->name('support-tickets.add-internal-note');
    Route::patch('support-tickets/{id}/internal-note', [SupportTicketController::class, 'updateInternalNote'])->name('support-tickets.update-internal-note');

    // Employee management routes for staff
    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
    Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
    Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    
    // Agent management routes for staff
    Route::get('agent', [AgentController::class, 'index'])->name('agents');
    Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
    Route::post('agent/update/{id}', [AgentController::class, 'update'])->name('agent.general.update');
    Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
    Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
    Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
    Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
    Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
    Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
    Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
    Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
    Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
    Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
    Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
    Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
    Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
    Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');
    Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
    Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
    Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
    Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
    Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');
    
    // Airline management routes for staff
    Route::get('airlines-details', [AirlineDetailController::class, 'index'])->name('airlines-details');
    Route::post('airlines-details/store', [AirlineController::class, 'store'])->name('airlines-details.store');
    Route::patch('/airline-details/{airlineDetail}', [AirlineController::class, 'update'])->name('airlines-details.update');
    Route::delete('/airline-details/delete/{airlineDetail}', [AirlineController::class, 'delete'])->name('airlines-details.delete');
    Route::delete('/admin/airline-details/{airlineDetail}', [AirlineDetailController::class, 'destroy'])->name('airlines-details.destroy');
    Route::post('airline/target/store', [AirlineController::class, 'targetStore'])->name('airline.target.store');
    Route::post('airline/approvedStaff/store', [AirlineController::class, 'approvedStaffRightsStore'])->name('airline.approved-staff-rights.store');
    Route::post('airlines/aircraft/', [AirlineController::class, 'aircraftStore'])->name('airline.aircraft.store');
    Route::post('airlines/fleet/', [AirlineController::class, 'fleetStore'])->name('airline.fleet.store');
    Route::patch('airlines/aircraft/update/{id}', [AirlineController::class, 'aircraftUpdate'])->name('airline.aircraft.update');
    Route::delete('airlines/aircraft/delete/{id}', [AirlineController::class, 'aircraftDelete'])->name('airline.aircraft.destroy');
    Route::post('airlines/fleet/update/{id}', [AirlineController::class, 'fleetUpdate'])->name('airline.fleet.update');
    Route::delete('airlines/fleet/delete/{id}', [AirlineController::class, 'fleetDelete'])->name('airline.fleet.destroy');
    Route::post('airlines/approved-staff/', [AirlineController::class, 'approvedStaffStore'])->name('airline.approvedstaff.store');
    Route::post('airlines/approved-staff/upadte/{id}', [AirlineController::class, 'approvedStaffUpdate'])->name('airline.approvedstaff.update');
    Route::patch('airlines/specialfares/update/{id}', [AirlineController::class, 'specialfaresUpdate'])->name('airline.specialfares.update');
    Route::post('airlines/SLA/store', [AirlineController::class, 'slaStore'])->name('airline.sla.store');
    Route::patch('airlines/SLA/{id}/update', [AirlineController::class, 'slaUpdate'])->name('airline.sla.update');
    Route::delete('airlines/SLA/{id}/destroy', [AirlineController::class, 'slaDestroy'])->name('airline.sla.destroy');
    Route::post('airlines/head_office/store', [AirlineController::class, 'headOfficeStore'])->name('airline.head_office.store');
    Route::patch('airlines/head_office/{id}/update', [AirlineController::class, 'headOfficeUpdate'])->name('airline.head_office.update');
    Route::delete('airlines/head_office/{id}/destroy', [AirlineController::class, 'headOfficeDestroy'])->name('airline.head_office.destroy');
    Route::patch('airline/sla/{id}/statusupdate', [AirlineController::class, 'slaUpdateStatus'])->name('airline.sla.statusupdate');
    Route::patch('airline/headOffice/toggle-status/{id}', [AirlineController::class, 'headOfficeUpdateStatus'])->name('airline.headOffice.statusupdate');
    Route::patch('airline/fleet/toggle-status/{id}', [AirlineController::class, 'fleetUpdateStatus'])->name('airline.fleet.statusupdate');
    Route::patch('airline/schedule/statusupdate/{id}', [AirlineController::class, 'scheduleUpdateStatus'])->name('airline.schedule.statusupdate');
    Route::patch('airline/library/statusupdate/{id}', [AirlineController::class, 'librarystatusUpdate'])->name('airline.library.statusupdate');
    Route::patch('airline/rules/statusupdate/{id}', [AirlineController::class, 'rulesupdateStatus'])->name('airline.rules.statusupdate');
    Route::patch('airline/specialfares/statusupdate/{id}', [AirlineController::class, 'specialfaresupdateStatus'])->name('airline.specialfares.statusupdate');
    Route::patch('admin/agreements/statusupdate/{id}', [AirlineController::class, 'agreemenstStatusUpdate'])->name('airline.agreements.statusupdate');
    Route::post('airlines/agreements/store', [AirlineController::class, 'agreementsStore'])->name('airline.agreements.store');
    Route::patch('airlines/agreements/{id}/update', [AirlineController::class, 'agreementsUpdate'])->name('airline.agreements.update');
    Route::patch('airlines/agreements/{id}/destroy', [AirlineController::class, 'agreementsDestroy'])->name('airline.agreements.destroy');
    Route::post('airlines/pli/store', [AirlineController::class, 'pliStore'])->name('airline.pli.store');
    Route::patch('airlines/library/{id}', [AirlineController::class, 'libraryupdate'])->name('airline.library.update');
    Route::delete('airlines/library/delete/{id}', [AirlineController::class, 'libraryDelete'])->name('airline.library.destroy');
    Route::post('library/store', [AirlineLibraryController::class, 'store'])->name('library.store');
    Route::post('library/airine/store', [AirlineLibraryController::class, 'viewstore'])->name('library.viewstore');
    Route::post('airlines/rules/store', [AirlineController::class, 'rulesStore'])->name('airline.rules.store');
    Route::patch('airlines/rules/update/{id}', [AirlineController::class, 'rulesUpdate'])->name('airline.rules.update');
    
    // Account dashboard for staff
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('booking', [AccountController::class, 'bookingIndex'])->name('booking.index');
    Route::get('booking/create', [AccountController::class, 'createBooking'])->name('booking.create');
    Route::get('booking/edit/{id}', [AccountController::class, 'editBooking'])->name('booking.edit');
    Route::post('booking/store', [AccountController::class, 'storeBooking'])->name('booking.store');
    Route::put('booking/update/{id}', [AccountController::class, 'updateBooking'])->name('booking.update');
    Route::post('booking/save-customer', [AccountController::class, 'saveCustomer'])->name('booking.save-customer');
    Route::get('booking/drop-tables', [AccountController::class, 'dropBookingTables'])->name('booking.drop-tables');
    Route::get('booking/invoice/{id}', [AccountController::class, 'generateInvoice'])->name('booking.invoice');
    Route::patch('support-tickets/{id}/company-name', [SupportTicketController::class, 'updateCompanyName'])->name('support-tickets.update-company-name');
    Route::delete('support-tickets/{id}', [SupportTicketController::class, 'destroy'])->name('support-tickets.destroy');

    // Get staff by department for SuperAdmin
    Route::get('get-staff-by-department', [SupportTicketController::class, 'getStaffByDepartment'])->name('get-staff-by-department');
    
    Route::get('leads', [LeadController::class, 'index'])->name('leads');
    Route::get('events/status', [EventStatusController:: class, 'index'])->name('events.status');
    Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');
    Route::patch('events/status/update/{id}', [EventStatusController::class, 'update'])->name('events.status.update');
    Route::delete('events/status/delete/{id}', [EventStatusController::class, 'delete'])->name('events.status.delete');
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('estimates', [SalesController::class, 'estimates'])->name('estimates');
    Route::get('invoices', [SalesController::class, 'invoices'])->name('invoices');
    Route::get('payments', [SalesController::class, 'payments'])->name('payments');
    Route::get('expenses', [SalesController::class, 'expenses'])->name('expenses');
    Route::get('provident-fund', [SalesController::class, 'providentFund'])->name('provident-fund');
    Route::get('taxes', [SalesController::class, 'taxes'])->name('taxes');
    Route::get('categories', [AccountingController::class, 'categories'])->name('categories');
    Route::get('budgets', [AccountingController::class, 'budgets'])->name('budgets');
    Route::get('budget-expenses', [AccountingController::class, 'budgetExpenses'])->name('budget-expenses');
    Route::get('budget-revenues', [AccountingController::class, 'budgetRevenues'])->name('budget-revenues');

    Route::get('customer/accounts/view', [AccountController::class, 'indexCustomerAccount'])->name('customer.accounts.view');
    Route::get('customer/accounts/all', [AccountController::class, 'viewCustomerAccount'])->name('customer.accounts.all');
    Route::get('customer/accounts/invoice/{id}', [AccountController::class, 'viewCustomerInvoice'])->name('customer.account.invoice');
    Route::post('customer/account/store', [AccountController::class, 'storeCustomerAccount'])->name('customer.account.store');
    Route::get('customer/account/edit/{id}', [AccountController::class, 'editCustomerAccount'])->name('customer.account.edit');
    Route::put('customer/account/update/{id}', [AccountController::class, 'updateCustomerAccount'])->name('customer.account.update');
    Route::post('customer/update-account-status', [AccountController::class, 'updateCustomerAccountStatus'])->name('customer.account.updateStatus');
    Route::post('customer/transaction/store', [CustomerController::class, 'transactionStore'])->name('customer.transaction.store');
    Route::get('customer/ledger', [AccountController::class, 'customerLedger'])->name('customer.ledger');
    Route::get('general-ledger', [AccountController::class, 'generalLedger'])->name('general-ledger');
    Route::get('supplier-ledger', [AccountController::class, 'supplierLedger'])->name('supplier-ledger');
    Route::get('expense-entry', [AccountController::class, 'expenseEntry'])->name('expense-entry');
    
    // Payment Pool routes
    Route::get('payment-pool', [PaymentPoolController::class, 'index'])->name('payment-pool');
    Route::post('payment-pool/store', [PaymentPoolController::class, 'store'])->name('payment-pool.store');
    Route::post('payment-pool/allocate/{id}', [PaymentPoolController::class, 'allocate'])->name('payment-pool.allocate');
    Route::post('payment-pool/deallocate/{id}', [PaymentPoolController::class, 'deallocate'])->name('payment-pool.deallocate');
    Route::delete('payment-pool/destroy/{id}', [PaymentPoolController::class, 'destroy'])->name('payment-pool.destroy');
    Route::post('payment-pool/create-expense', [PaymentPoolController::class, 'createExpense'])->name('payment-pool.create-expense');
    Route::post('payment-pool/create-supplier-payment', [PaymentPoolController::class, 'createSupplierPayment'])->name('payment-pool.create-supplier-payment');
    Route::post('payment-pool/split-allocation', [PaymentPoolController::class, 'splitAllocation'])->name('payment-pool.split-allocation');
    
    Route::get('accounts/view', [AccountController::class, 'account'])->name('accounts.view');
    Route::get('accounts/all', [AccountController::class, 'viewAccount'])->name('accounts.all');
    Route::get('accounts/invoice/{id}', [AccountController::class, 'viewInvoice'])->name('account.invoice');
    Route::post('account/store', [AccountController::class, 'storeAccount'])->name('account.store');
    Route::get('account/edit/{id}', [AccountController::class, 'editAccount'])->name('account.edit');
    Route::put('account/update/{id}', [AccountController::class, 'updateAccount'])->name('account.update');
    Route::post('/update-account-status', [AccountController::class, 'updateStatus'])->name('account.updateStatus');
    Route::get('reservations/new-sale', [ReservationController::class, 'newSale'])->name('reservation.newsale');
    Route::post('reservations/store', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('sales-packages', [SalesPackageController::class, 'index'])->name('sales-packages.index');
    Route::get('sales-packages/create', [SalesPackageController::class, 'create'])->name('sales-packages.create');
    Route::post('sales-packages/store', [SalesPackageController::class, 'store'])->name('sales-packages.store');
    Route::get('sales-packages/edit/{id}', [SalesPackageController::class, 'edit'])->name('sales-packages.edit');
    Route::put('sales-packages/update/{id}', [SalesPackageController::class, 'update'])->name('sales-packages.update');
    Route::delete('sales-packages/destroy/{id}', [SalesPackageController::class, 'destroy'])->name('sales-packages.destroy');
    Route::get('sales-packages/toggle-status/{id}', [SalesPackageController::class, 'toggleStatus'])->name('sales-packages.toggle-status');
    Route::get('sales-packages/{id}', [SalesPackageController::class, 'getPackage'])->name('sales-packages.get');
    Route::get('sales-packages/{packageId}/permissions', [SalesPackageController::class, 'getPackagePermissions'])->name('sales-packages.get.permissions');
    Route::post('sales-packages/save-permissions', [SalesPackageController::class, 'savePackagePermissions'])->name('sales-packages.save.permissions');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('customer-subscriptions', [SubscriptionController::class, 'customerSubscriptions'])->name('customer.subscriptions');
    Route::post('customer-subscriptions/store', [SubscriptionController::class, 'storeCustomerSubscription'])->name('customer.subscriptions.store');
    Route::get('customer-subscriptions/get-permissions', [SubscriptionController::class, 'getSubscriptionPermissions'])->name('customer.subscriptions.get.permissions');
    Route::post('customer-subscriptions/save-permissions', [SubscriptionController::class, 'saveSubscriptionPermissions'])->name('customer.subscriptions.save.permissions');
    Route::get('customer-module-permissions/{id}', [SubscriptionController::class, 'getCustomerModulePermissions'])->name('module.permissions');
    Route::post('customer-update-module-access', [SubscriptionController::class, 'updateCustomerModuleAccess'])->name('update.module.access');

    // Bank Accounts routes
    Route::get('bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');
    Route::get('bank-accounts/create', [BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('bank-accounts/store', [BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::get('bank-accounts/edit/{id}', [BankAccountController::class, 'edit'])->name('bank-accounts.edit');
    Route::put('bank-accounts/update/{id}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
    Route::delete('bank-accounts/destroy/{id}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');
    Route::get('bank-accounts/toggle-status/{id}', [BankAccountController::class, 'toggleStatus'])->name('bank-accounts.toggle-status');
    
    Route::get('staff-reports', [StaffReportController::class, 'index'])->name('staff-reports');
    Route::get('airline-reports', [AirlineController::class, 'report'])->name('airline-reports');
    Route::get('agent-reports', [AgentReportController::class, 'airlineReport'])->name('agent-reports');
    Route::get('customer-reports', [CustomerReportController::class, 'customerReport'])->name('customer-reports');
    Route::get('salary', [PayrollController::class, 'employeeSalary'])->name('salary');
    Route::get('manage-staff', [EmployeeController::class, 'manageStaff'])->name('manage-staff');
    Route::get('/admin/manage-salary/{id}', [PayrollController::class, 'employeeSalaryId'])->name('manage-salary');
    Route::post('/admin/manage-salary/store', [PayrollController::class, 'employeeSalaryIdStore'])->name('manage-salary.store');
    Route::post('salary/store', [PayrollController::class, 'employeeSalaryStore'])->name('salary.store');
    Route::get('salary-view/{id}', [PayrollController::class, 'payslip'])->name('salary-view');
    Route::get('payroll-items', [PayrollController::class, 'payrollItems'])->name('payroll-items');
    Route::get('policies', [PolicyController::class, 'index'])->name('policies');
    Route::post('policies/store', [PolicyController::class, 'store'])->name('policies.store');
    Route::patch('policies/update', [PolicyController::class, 'update'])->name('policies.update');
    Route::patch('airline/sla/{id}/statusupdate', [AirlineController::class, 'slaUpdateStatus'])->name('airline.sla.statusupdate');
    Route::patch('airline/headOffice/toggle-status/{id}', [AirlineController::class, 'headOfficeUpdateStatus'])->name('airline.headOffice.statusupdate');
    Route::patch('airline/fleet/toggle-status/{id}', [AirlineController::class, 'fleetUpdateStatus'])->name('airline.fleet.statusupdate');
    Route::patch('airline/schedule/statusupdate/{id}', [AirlineController::class, 'scheduleUpdateStatus'])->name('airline.schedule.statusupdate');
    Route::patch('airline/library/statusupdate/{id}', [AirlineController::class, 'librarystatusUpdate'])->name('airline.library.statusupdate');
    Route::patch('airline/rules/statusupdate/{id}', [AirlineController::class, 'rulesupdateStatus'])->name('airline.rules.statusupdate');
    Route::patch('airline/specialfares/statusupdate/{id}', [AirlineController::class, 'specialfaresupdateStatus'])->name('airline.specialfares.statusupdate');
    Route::patch('admin/agreements/statusupdate/{id}', [AirlineController::class, 'agreemenstStatusUpdate'])->name('airline.agreements.statusupdate');
    Route::post('airlines/agreements/store', [AirlineController::class, 'agreementsStore'])->name('airline.agreements.store');
    Route::patch('airlines/agreements/{id}/update', [AirlineController::class, 'agreementsUpdate'])->name('airline.agreements.update');
    Route::patch('airlines/agreements/{id}/destroy', [AirlineController::class, 'agreementsDestroy'])->name('airline.agreements.destroy');
    Route::post('airlines/pli/store', [AirlineController::class, 'pliStore'])->name('airline.pli.store');
    Route::patch('airlines/library/{id}', [AirlineController::class, 'libraryupdate'])->name('airline.library.update');
    Route::delete('airlines/library/delete/{id}', [AirlineController::class, 'libraryDelete'])->name('airline.library.destroy');
    Route::post('airlines/rules/store', [AirlineController::class, 'rulesStore'])->name('airline.rules.store');
    Route::patch('airlines/rules/update/{id}', [AirlineController::class, 'rulesUpdate'])->name('airline.rules.update');
    Route::get('expense-reports', [ReportController::class, 'expenseReport'])->name('expense-reports');
    Route::get('invoice-reports', [ReportController::class, 'invoiceReport'])->name('invoice-reports');
    Route::get('payments-reports', [ReportController::class, 'paymentsReport'])->name('payments-reports');
    Route::get('project-reports', [ReportController::class, 'projectReport'])->name('project-reports');
    Route::get('task-reports', [ReportController::class, 'taskReport'])->name('task-reports');
    Route::get('user-reports', [ReportController::class, 'userReport'])->name('user-reports');
    Route::get('employee-reports', [ReportController::class, 'employeeReport'])->name('employee-reports');
    Route::get('payslip-reports', [ReportController::class, 'payslipReport'])->name('payslip-reports');
    Route::get('attendance-reports', [ReportController::class, 'attendanceReport'])->name('attendance-reports');
    Route::get('leave-reports', [ReportController::class, 'leaveReport'])->name('leave-reports');
    Route::get('daily-reports', [ReportController::class, 'dailyReport'])->name('daily-reports');
    Route::get('performance-indicator', [PerformanceController::class, 'performanceIndicator'])->name('performance-indicator');
    Route::get('performance-review', [PerformanceController::class, 'performanceReview'])->name('performance-review');
    Route::get('performance-appraisal', [PerformanceController::class, 'performanceAppraisal'])->name('performance-appraisal');
    Route::get('goal-tracking', [GoalController::class, 'goalList'])->name('goal-tracking');
    Route::get('goal-type', [GoalController::class, 'goalType'])->name('goal-type');
    Route::get('training', [TrainingController::class, 'trainingList'])->name('training');
    Route::get('trainers', [TrainingController::class, 'trainers'])->name('trainers');
    Route::get('training-type', [TrainingController::class, 'trainingType'])->name('training-type');
    Route::get('promotion', [HRController::class, 'promotion'])->name('promotion');
    Route::get('resignation', [HRController::class, 'resignation'])->name('resignation');
    Route::get('termination', [HRController::class, 'termination'])->name('termination');
    Route::post('termination/store', [HRController::class, 'terminationStore'])->name('termination.store');
    Route::post('termination/update', [HRController::class, 'terminationUpdate'])->name('termination.update');
    Route::post('resignation/store', [HRController::class, 'resignationStore'])->name('resignation.store');
    Route::patch('resignation/update', [HRController::class, 'resignationUpdate'])->name('resignation.update');
    Route::get('assets', [AdministrationController::class, 'assets'])->name('assets');
    Route::get('user-dashboard', [JobController::class, 'userDashboard'])->name('user-dashboard');
    Route::get('jobs-dashboard', [JobController::class, 'jobsDashboard'])->name('jobs-dashboard');
    Route::get('jobs', [JobController::class, 'manageJobs'])->name('jobs');
    Route::get('manage-resumes', [JobController::class, 'manageResumes'])->name('manage-resumes');
    Route::get('shortlist-candidates', [JobController::class, 'shortlistCandidates'])->name('shortlist-candidates');
    Route::get('interview-questions', [JobController::class, 'interviewQuestions'])->name('interview-questions');
    Route::get('offer-approvals', [JobController::class, 'offerApprovals'])->name('offer-approvals');
    Route::get('experience-level', [JobController::class, 'experienceLevel'])->name('experience-level');
    Route::get('candidates', [JobController::class, 'candidatesList'])->name('candidates');
    Route::get('schedule-timing', [JobController::class, 'scheduleTiming'])->name('schedule-timing');
    Route::get('apptitude-result', [JobController::class, 'aptitudeResults'])->name('apptitude-result');
    Route::get('knowledgebase', [KnowledgebaseController::class, 'index'])->name('knowledgebase');
    Route::get('activities', [ActivityController::class, 'index'])->name('activities');
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::get('profile', [ProfileController::class, 'employeeProfile'])->name('profile');
    Route::get('client-profile', [ProfileController::class, 'clientProfile'])->name('client-profile');
    Route::get('admin-profile', [ProfileController::class, 'adminProfile'])->name('admin-profile');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/timezone', [ProfileController::class, 'updateTimezone'])->name('profile.timezone');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('roles-permissions', [ModuleController::class, 'index'])->name('roles-permissions.index');
    Route::post('modules/update', [ModuleController::class, 'update'])->name('modules.update');
    Route::post('modules/toggle-status', [ModuleController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::get('fare_conditions', [FareConditionController::class, 'index'])->name('fare_conditions.index');
    Route::get('fare_conditions/create', [FareConditionController::class, 'create'])->name('fare_conditions.create');
    Route::post('fare_conditions', [FareConditionController::class, 'store'])->name('fare_conditions.store');
    Route::get('fare_conditions/{fare_condition}', [FareConditionController::class, 'show'])->name('fare_conditions.show');
    Route::get('fare_conditions/{fare_condition}/edit', [FareConditionController::class, 'edit'])->name('fare_conditions.edit');
    Route::put('fare_conditions/{fare_condition}', [FareConditionController::class, 'update'])->name('fare_conditions.update');
    Route::delete('fare_conditions/{fare_condition}', [FareConditionController::class, 'destroy'])->name('fare_conditions.destroy');
    Route::put('/airtickets/{id}/update-status', 'AirTicketController@updateStatus')->name('airtickets.update_status');
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
});

// Staff routes - accessible by staff users (users table)
Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
    // Support Tickets routes for staff
    Route::middleware(['module.access:support-tickets'])->group(function () {
        Route::get('support-tickets/dashboard', [SupportTicketController::class, 'ticketDashboard'])->name('support-tickets.dashboard');
        Route::get('support-tickets/all', [SupportTicketController::class, 'dashboardStatistics'])->name('support-tickets.all');
        Route::get('support-tickets', [SupportTicketController::class, 'index'])->name('support-tickets.index');
        Route::get('support-tickets/my-created', [SupportTicketController::class, 'myCreatedTickets'])->name('support-tickets.my-created');
        Route::get('support-tickets/assigned', [SupportTicketController::class, 'assignedTickets'])->name('support-tickets.assigned');
        Route::get('support-tickets/unassigned', [SupportTicketController::class, 'unassignedTickets'])->name('support-tickets.unassigned');
        Route::get('support-tickets/create', [SupportTicketController::class, 'create'])->name('support-tickets.create');
        Route::post('support-tickets', [SupportTicketController::class, 'store'])->name('support-tickets.store');
        Route::get('support-tickets/{id}', [SupportTicketController::class, 'show'])->name('support-tickets.show');
        Route::post('support-tickets/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('support-tickets.update-status');
        Route::post('support-tickets/{id}/comment', [SupportTicketController::class, 'addComment'])->name('support-tickets.add-comment');
        Route::post('support-tickets/{id}/rating', [SupportTicketController::class, 'submitRating'])->name('support-tickets.submit-rating');
        Route::post('support-tickets/{id}/internal-note', [SupportTicketController::class, 'addInternalNote'])->name('support-tickets.add-internal-note');
        Route::patch('support-tickets/{id}/internal-note', [SupportTicketController::class, 'updateInternalNote'])->name('support-tickets.update-internal-note');
    });
    
    // Get staff by department for staff users
    Route::get('get-staff-by-department', [SupportTicketController::class, 'getStaffByDepartment'])->name('get-staff-by-department');
    
    // Employee management routes for staff
    Route::middleware(['module.access:hr'])->group(function () {
        Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
        Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
        Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
        Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
        Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    });
    
    // Agent management routes for staff
    Route::middleware(['module.access:travel-agent'])->group(function () {
        Route::get('agent', [AgentController::class, 'index'])->name('agents');
        Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
        Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
        Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
        Route::post('agent/update/{id}', [AgentController::class, 'update'])->name('agent.general.update');
        Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
        Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
        Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
        Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
        Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
        Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
        Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
        Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
        Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
        Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
        Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
        Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
        Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
        Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');
        Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
        Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
        Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
        Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
        Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');
    });
});

// Customer routes - accessible by users with customer role (non-SuperAdmin)
Route::prefix('customer')->name('customer.')->middleware(['customer'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'staffLogout'])->name('logout');
    Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');

    // Module access routes for customers
    Route::post('/update-module-access', [EmployeeController::class, 'updateModuleAccess'])->name('employee.update.module.access');
    Route::get('/employee-module-permissions/{id}', [EmployeeController::class, 'getEmployeeModulePermissions'])->name('employee.module.permissions');
    Route::get('/available-modules', [EmployeeController::class, 'getAvailableModules'])->name('available.modules');

    // Include customer-accessible routes here
    Route::get('customer/case-history', [CustomerController::class, 'caseHistorySearch'])->name('case-history');
    Route::post('customer/casehistory/store', [CustomerController::class, 'caseStore'])->name('case.store');
    Route::patch('customer/casehistory/update/{id}', [CustomerController::class, 'caseUpdate'])->name('cases.update');
    Route::post('customer/casehistory/close/{id}', [CustomerController::class, 'caseClose'])->name('cases.close');

    Route::post('customer/conversation/store', [CustomerController::class, 'conversationStore'])->name('conversation.store');
    Route::post('customer/address/store', [CustomerController::class, 'AddressStore'])->name('address.store');
    Route::post('customer/contact/store', [CustomerController::class, 'ContactStore'])->name('contact.store');
    Route::post('customer/contact/update/{id}', [CustomerController::class, 'contactUpdate'])->name('contact.update');
    Route::delete('customer/contact/delete/{id}', [CustomerController::class, 'contactDelete'])->name('contact.delete');
    Route::post('customer/address/update/{id}', [CustomerController::class, 'addressUpdate'])->name('address.update');

    Route::get('customer/accounts/view', [AccountController::class, 'indexCustomerAccount'])->name('accounts.view');
    Route::get('customer/accounts/all', [AccountController::class, 'viewCustomerAccount'])->name('accounts.all');
    Route::get('customer/accounts/invoice/{id}', [AccountController::class, 'viewCustomerInvoice'])->name('account.invoice');
    Route::post('customer/account/store', [AccountController::class, 'storeCustomerAccount'])->name('account.store');
    Route::get('customer/account/edit/{id}', [AccountController::class, 'editCustomerAccount'])->name('account.edit');
    Route::put('customer/account/update/{id}', [AccountController::class, 'updateCustomerAccount'])->name('account.update');
    Route::post('customer/update-account-status', [AccountController::class, 'updateCustomerAccountStatus'])->name('account.updateStatus');
    Route::post('customer/transaction/store', [CustomerController::class, 'transactionStore'])->name('transaction.store');
    Route::get('customer/ledger', [AccountController::class, 'customerLedger'])->name('ledger');
    Route::get('general-ledger', [AccountController::class, 'generalLedger'])->name('general-ledger');
    Route::get('supplier-ledger', [AccountController::class, 'supplierLedger'])->name('supplier-ledger');
    Route::get('expense-entry', [AccountController::class, 'expenseEntry'])->name('expense-entry');
    
    // Account dashboard for customers
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('booking', [AccountController::class, 'bookingIndex'])->name('booking.index');
    Route::get('booking/create', [AccountController::class, 'createBooking'])->name('booking.create');
    Route::get('booking/edit/{id}', [AccountController::class, 'editBooking'])->name('booking.edit');
    Route::post('booking/store', [AccountController::class, 'storeBooking'])->name('booking.store');
    Route::put('booking/update/{id}', [AccountController::class, 'updateBooking'])->name('booking.update');
    Route::post('booking/save-customer', [AccountController::class, 'saveCustomer'])->name('booking.save-customer');
    Route::get('booking/drop-tables', [AccountController::class, 'dropBookingTables'])->name('booking.drop-tables');
    Route::get('booking/invoice/{id}', [AccountController::class, 'generateInvoice'])->name('booking.invoice');

    Route::get('profile', [ProfileController::class, 'clientProfile'])->name('profile');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/timezone', [ProfileController::class, 'updateTimezone'])->name('profile.timezone');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');

    // B2B Partners routes for customers
    Route::get('b2b-partners', [B2BPartnerController::class, 'index'])->name('b2b-partners');
    Route::get('b2b-partners/create', [B2BPartnerController::class, 'create'])->name('b2b-partners.create');
    Route::post('b2b-partners', [B2BPartnerController::class, 'store'])->name('b2b-partners.store');
    Route::get('b2b-partners/{id}', [B2BPartnerController::class, 'show'])->name('b2b-partners.show');
    Route::get('b2b-partners/{id}/edit', [B2BPartnerController::class, 'edit'])->name('b2b-partners.edit');
    Route::put('b2b-partners/{id}', [B2BPartnerController::class, 'update'])->name('b2b-partners.update');
    Route::delete('b2b-partners/{id}', [B2BPartnerController::class, 'destroy'])->name('b2b-partners.destroy');
    Route::post('b2b-partners/{partnerId}/contacts', [B2BPartnerController::class, 'storeContact'])->name('b2b-partners.contacts.store');
    Route::put('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'updateContact'])->name('b2b-partners.contacts.update');
    Route::delete('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'deleteContact'])->name('b2b-partners.contacts.destroy');
    Route::post('b2b-partners/{partnerId}/documents', [B2BPartnerController::class, 'storeDocument'])->name('b2b-partners.documents.store');
    Route::delete('b2b-partners/documents/{id}', [B2BPartnerController::class, 'deleteDocument'])->name('b2b-partners.documents.destroy');
    Route::post('b2b-partners/{partnerId}/notes', [B2BPartnerController::class, 'storeNote'])->name('b2b-partners.notes.store');
    Route::delete('b2b-partners/notes/{id}', [B2BPartnerController::class, 'deleteNote'])->name('b2b-partners.notes.destroy');
    Route::get('b2b-partners/search', [B2BPartnerController::class, 'search'])->name('b2b-partners.search');

    // B2C Customers routes for customers
    Route::get('b2c-customers', [B2CCustomerController::class, 'index'])->name('b2c-customers.index');
    Route::get('b2c-customers/create', [B2CCustomerController::class, 'create'])->name('b2c-customers.create');
    Route::post('b2c-customers', [B2CCustomerController::class, 'store'])->name('b2c-customers.store');
    Route::get('b2c-customers/{id}', [B2CCustomerController::class, 'show'])->name('b2c-customers.show');
    Route::get('b2c-customers/{id}/edit', [B2CCustomerController::class, 'edit'])->name('b2c-customers.edit');
    Route::put('b2c-customers/{id}', [B2CCustomerController::class, 'update'])->name('b2c-customers.update');
    Route::delete('b2c-customers/{id}', [B2CCustomerController::class, 'destroy'])->name('b2c-customers.destroy');
    Route::patch('b2c-customers/{id}/toggle-status', [B2CCustomerController::class, 'toggleStatus'])->name('b2c-customers.toggle-status');
    
    // B2C Passenger routes for customers
    Route::get('b2c-customers/{customerId}/passengers/create', [B2CCustomerController::class, 'addPassenger'])->name('b2c-customers.passengers.create');
    Route::post('b2c-customers/{customerId}/passengers', [B2CCustomerController::class, 'storePassenger'])->name('b2c-customers.passengers.store');
    Route::get('b2c-customers/{customerId}/passengers/{passengerId}/edit', [B2CCustomerController::class, 'editPassenger'])->name('b2c-customers.passengers.edit');
    Route::put('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'updatePassenger'])->name('b2c-customers.passengers.update');
    Route::delete('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'deletePassenger'])->name('b2c-customers.passengers.delete');
    
    // B2C Notes routes for customers
    Route::post('b2c-customers/{customerId}/notes', [B2CCustomerController::class, 'storeNote'])->name('b2c-customers.notes.store');
    Route::delete('b2c-customers/{customerId}/notes/{noteId}', [B2CCustomerController::class, 'deleteNote'])->name('b2c-customers.notes.delete');
    Route::get('b2c-customers/search', [B2CCustomerController::class, 'search'])->name('b2c-customers.search');
    
    // B2C Documents routes for customers
    Route::post('b2c-customers/{customerId}/documents', [B2CCustomerController::class, 'storeDocument'])->name('b2c-customers.documents.store');
    Route::delete('b2c-customers/{customerId}/documents/{documentId}', [B2CCustomerController::class, 'deleteDocument'])->name('b2c-customers.documents.delete');

    // Support Tickets routes for customers
    Route::get('support-tickets', [SupportTicketController::class, 'ticketDashboard'])->name('support-tickets.dashboard');
    Route::get('support-tickets/all', [SupportTicketController::class, 'dashboardStatistics'])->name('support-tickets.index');
    Route::get('support-tickets/create', [SupportTicketController::class, 'create'])->name('support-tickets.create');
    Route::post('support-tickets', [SupportTicketController::class, 'store'])->name('support-tickets.store');
    Route::get('support-tickets/{id}', [SupportTicketController::class, 'show'])->name('support-tickets.show');
    Route::patch('support-tickets/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('support-tickets.update-status');
    Route::post('support-tickets/{id}/assign', [SupportTicketController::class, 'assign'])->name('support-tickets.assign');
    Route::post('support-tickets/{id}/comment', [SupportTicketController::class, 'addComment'])->name('support-tickets.add-comment');
    Route::post('support-tickets/{id}/rating', [SupportTicketController::class, 'submitRating'])->name('support-tickets.submit-rating');

    // Get staff by department for customers
    Route::get('get-staff-by-department', [SupportTicketController::class, 'getStaffByDepartment'])->name('get-staff-by-department');

    // Employee management routes for customers
    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
    Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
    Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    
    // Agent management routes for customers
    Route::get('agent', [AgentController::class, 'index'])->name('agents');
    Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
    Route::post('agent/update/{id}', [AgentController::class, 'update'])->name('agent.general.update');
    Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
    Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
    Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
    Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
    Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
    Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
    Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
    Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
    Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
    Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
    Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
    Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
    Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
    Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');
    Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
    Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
    Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
    Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
    Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');

    // B2B Partners routes for customers
    Route::get('b2b-partners', [B2BPartnerController::class, 'index'])->name('b2b-partners');
    Route::get('b2b-partners/create', [B2BPartnerController::class, 'create'])->name('b2b-partners.create');
    Route::post('b2b-partners', [B2BPartnerController::class, 'store'])->name('b2b-partners.store');
    Route::get('b2b-partners/{id}', [B2BPartnerController::class, 'show'])->name('b2b-partners.show');
    Route::get('b2b-partners/{id}/edit', [B2BPartnerController::class, 'edit'])->name('b2b-partners.edit');
    Route::put('b2b-partners/{id}', [B2BPartnerController::class, 'update'])->name('b2b-partners.update');
    Route::delete('b2b-partners/{id}', [B2BPartnerController::class, 'destroy'])->name('b2b-partners.destroy');
    Route::post('b2b-partners/{partnerId}/contacts', [B2BPartnerController::class, 'storeContact'])->name('b2b-partners.contacts.store');
    Route::put('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'updateContact'])->name('b2b-partners.contacts.update');
    Route::delete('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'deleteContact'])->name('b2b-partners.contacts.destroy');
    Route::post('b2b-partners/{partnerId}/documents', [B2BPartnerController::class, 'storeDocument'])->name('b2b-partners.documents.store');
    Route::delete('b2b-partners/documents/{id}', [B2BPartnerController::class, 'deleteDocument'])->name('b2b-partners.documents.destroy');
    Route::post('b2b-partners/{partnerId}/notes', [B2BPartnerController::class, 'storeNote'])->name('b2b-partners.notes.store');
    Route::delete('b2b-partners/notes/{id}', [B2BPartnerController::class, 'deleteNote'])->name('b2b-partners.notes.destroy');
    Route::get('b2b-partners/search', [B2BPartnerController::class, 'search'])->name('b2b-partners.search');

    // Airline management routes for customers
    Route::get('airlines-details', [AirlineDetailController::class, 'index'])->name('airlines-details');
    Route::post('airlines-details/store', [AirlineController::class, 'store'])->name('airlines-details.store');
    Route::patch('/airline-details/{airlineDetail}', [AirlineController::class, 'update'])->name('airlines-details.update');
    Route::delete('/airline-details/delete/{airlineDetail}', [AirlineController::class, 'delete'])->name('airlines-details.delete');
    Route::delete('/admin/airline-details/{airlineDetail}', [AirlineDetailController::class, 'destroy'])->name('airlines-details.destroy');
    Route::post('airline/target/store', [AirlineController::class, 'targetStore'])->name('airline.target.store');
    Route::post('airline/approvedStaff/store', [AirlineController::class, 'approvedStaffRightsStore'])->name('airline.approved-staff-rights.store');
    Route::post('airlines/aircraft/', [AirlineController::class, 'aircraftStore'])->name('airline.aircraft.store');
    Route::post('airlines/fleet/', [AirlineController::class, 'fleetStore'])->name('airline.fleet.store');
    Route::patch('airlines/aircraft/update/{id}', [AirlineController::class, 'aircraftUpdate'])->name('airline.aircraft.update');
    Route::delete('airlines/aircraft/delete/{id}', [AirlineController::class, 'aircraftDelete'])->name('airline.aircraft.destroy');
    Route::post('airlines/fleet/update/{id}', [AirlineController::class, 'fleetUpdate'])->name('airline.fleet.update');
    Route::delete('airlines/fleet/delete/{id}', [AirlineController::class, 'fleetDelete'])->name('airline.fleet.destroy');
    Route::post('airlines/approved-staff/', [AirlineController::class, 'approvedStaffStore'])->name('airline.approvedstaff.store');
    Route::post('airlines/approved-staff/upadte/{id}', [AirlineController::class, 'approvedStaffUpdate'])->name('airline.approvedstaff.update');
    Route::patch('airlines/specialfares/update/{id}', [AirlineController::class, 'specialfaresUpdate'])->name('airline.specialfares.update');
    Route::post('airlines/SLA/store', [AirlineController::class, 'slaStore'])->name('airline.sla.store');
    Route::patch('airlines/SLA/{id}/update', [AirlineController::class, 'slaUpdate'])->name('airline.sla.update');
    Route::delete('airlines/SLA/{id}/destroy', [AirlineController::class, 'slaDestroy'])->name('airline.sla.destroy');
    Route::post('airlines/head_office/store', [AirlineController::class, 'headOfficeStore'])->name('airline.head_office.store');
    Route::patch('airlines/head_office/{id}/update', [AirlineController::class, 'headOfficeUpdate'])->name('airline.head_office.update');
    Route::delete('airlines/head_office/{id}/destroy', [AirlineController::class, 'headOfficeDestroy'])->name('airline.head_office.destroy');
    Route::patch('airline/sla/{id}/statusupdate', [AirlineController::class, 'slaUpdateStatus'])->name('airline.sla.statusupdate');
    Route::patch('airline/headOffice/toggle-status/{id}', [AirlineController::class, 'headOfficeUpdateStatus'])->name('airline.headOffice.statusupdate');
    Route::patch('airline/fleet/toggle-status/{id}', [AirlineController::class, 'fleetUpdateStatus'])->name('airline.fleet.statusupdate');
    Route::patch('airline/schedule/statusupdate/{id}', [AirlineController::class, 'scheduleUpdateStatus'])->name('airline.schedule.statusupdate');
    Route::patch('airline/library/statusupdate/{id}', [AirlineController::class, 'librarystatusUpdate'])->name('airline.library.statusupdate');
    Route::patch('airline/rules/statusupdate/{id}', [AirlineController::class, 'rulesupdateStatus'])->name('airline.rules.statusupdate');
    Route::patch('airline/specialfares/statusupdate/{id}', [AirlineController::class, 'specialfaresupdateStatus'])->name('airline.specialfares.statusupdate');
    Route::patch('admin/agreements/statusupdate/{id}', [AirlineController::class, 'agreemenstStatusUpdate'])->name('airline.agreements.statusupdate');
    Route::post('airlines/agreements/store', [AirlineController::class, 'agreementsStore'])->name('airline.agreements.store');
    Route::patch('airlines/agreements/{id}/update', [AirlineController::class, 'agreementsUpdate'])->name('airline.agreements.update');
    Route::patch('airlines/agreements/{id}/destroy', [AirlineController::class, 'agreementsDestroy'])->name('airline.agreements.destroy');
    Route::post('airlines/pli/store', [AirlineController::class, 'pliStore'])->name('airline.pli.store');
    Route::patch('airlines/library/{id}', [AirlineController::class, 'libraryupdate'])->name('airline.library.update');
    Route::delete('airlines/library/delete/{id}', [AirlineController::class, 'libraryDelete'])->name('airline.library.destroy');
    Route::post('library/store', [AirlineLibraryController::class, 'store'])->name('library.store');
    Route::post('library/airine/store', [AirlineLibraryController::class, 'viewstore'])->name('library.viewstore');
    Route::post('airlines/rules/store', [AirlineController::class, 'rulesStore'])->name('airline.rules.store');
    Route::patch('airlines/rules/update/{id}', [AirlineController::class, 'rulesUpdate'])->name('airline.rules.update');
    
    Route::get('/get-departments', [EmployeeController::class, 'getDepartments']);
    Route::get('/get-employees/{department}', [EmployeeController::class, 'getEmployeesByDepartment']);
    Route::get('/get-employees/{user_id}', [EmployeeController::class, 'getEmployeesByUsers']);

    // Accounting routes
    Route::get('categories/view', [CategoryController::class, 'categoriesIndex'])->name('categories.view');
    Route::post('categories/store', [CategoryController::class, 'storeCategory'])->name('categories.store');
    Route::put('categories/update/{id}', [CategoryController::class, 'updateCategory'])->name('categories.update');
    Route::post('/update-category-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');

    //Duties routes
    Route::get('duties', [DutyController::class, 'duties'])->name('duties');
    Route::post('duties/store', [DutyController::class, 'storeDuty'])->name('duties.store');
    Route::put('duties/update/{id}', [DutyController::class, 'updateDuty'])->name('duties.update');
    Route::post('/update-duty-status', [DutyController::class, 'updateStatus'])->name('duties.updateStatus');

    Route::get('fare-types', [FareTypeController::class, 'index'])->name('faretypes');
    Route::post('fare-types/store', [FareTypeController::class, 'store'])->name('faretypes.store');
    Route::put('fare-types/update/{id}', [FareTypeController::class, 'update'])->name('faretypes.update');
    Route::delete('fare-types/delete/{id}', [FareTypeController::class, 'delete'])->name('faretypes.delete');
    Route::get('discounts', [DiscountController::class, 'index'])->name('discounts');
    Route::post('discounts/store', [DiscountController::class, 'discountStore'])->name('discounts.store');
    Route::put('discounts/update/{id}', [DiscountController::class, 'discountUpdate'])->name('discounts.update');
    Route::delete('discounts/delete/{id}', [DiscountController::class, 'discountDelete'])->name('discounts.delete');

    //LeaveType rotes
    Route::get('leavetypes', [LeaveTypeController::class, 'leaveType'])->name('leave-type');
    Route::post('leavetypes/store', [LeaveTypeController::class, 'storeLeaveType'])->name('leave-type.store');
    Route::put('leavetypes/update/{id}', [LeaveTypeController::class, 'updateLeaveType'])->name('leave-type.update');
    Route::delete('leavetypes/delete/{id}', [LeaveTypeController::class, 'deleteLeaveType'])->name('leave-type.delete');
    Route::post('/update-leavetype-status', [LeaveTypeController::class, 'updateStatus'])->name('leave-type.updateStatus');

    Route::get('coming-soon', [DashboardController::class, 'comingSoon'])->name('comingSoon');

    //Project Routes
    Route::get('project-view', function(){
        return view('admin.project-view');
    })->name('project-view');

    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
    Route::get('employees-list', [EmployeeController::class, 'Employeeslist'])->name('employees-list');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::delete('/admin/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('employee/view', [EmployeeController::class, 'viewUserProfile'])->name('employee.view-profile');
    Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
    Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    Route::get('employee/rights', [EmployeeController::class, 'viewUserRights'])->name('employee.rights');
    Route::post('employee/rights/store', [EmployeeController::class, 'storeUserRights'])->name('employee.rights.store');
    Route::patch('employee/rights/update/{id}', [EmployeeController::class, 'updateUserRights'])->name('employee.rights.update');
    Route::get('employee/view/{id}', [EmployeeController::class, 'PemployeeProfile'])->name('employee.list-profile');
    Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
    Route::post('view-staff/leaves/store', [EmployeeController::class, 'leavesEmployeeViewStore'])->name('view-staff.leaves.store');
    Route::patch('view-staff/leaves/edit/{id}', [EmployeeController::class, 'leavesEmployeeViewUpdate'])->name('view-staff.leaves.update');
    Route::post('view-staff/read-doc/store', [EmployeeController::class, 'EmployeeReadSignStore'])->name('view-staff.readsign.store');
    Route::patch('view-staff/read-doc/edit/{id}', [EmployeeController::class, 'EmployeeReadSignUpdate'])->name('view-staff.readsign.update');
    Route::post('view-staff/library', [EmployeeController::class, 'storeLibrary'])->name('view-staff.library.store');
    Route::patch('view-staff/library/{id}', [EmployeeController::class, 'libraryupdate'])->name('view-staff.library.update');
    Route::delete('view-staff/library/delete/{id}', [EmployeeController::class, 'libraryDelete'])->name('view-staff.library.destroy');
    Route::post('view-staff/store', [EmployeeController::class, 'leavesStaffStore'])->name('view-staff.store');
    Route::get('holidays', [EmployeeController::class, 'holidays'])->name('holidays');
    Route::post('holidays/store', [EmployeeController::class, 'holidayStore'])->name('holidays.store');
    Route::patch('holidays/edit/{id}', [EmployeeController::class, 'holidayUpdate'])->name('holidays.update');
    Route::get('leaves', [EmployeeController::class, 'leavesAdmin'])->name('leaves');
    Route::get('/get-holidays', [EmployeeController::class, 'getHolidays']);
    Route::post('leaves/store', [EmployeeController::class, 'leavesAdminStore'])->name('leaves.store');
    Route::patch('leaves/edit/{id}', [EmployeeController::class, 'leavesAdminUpdate'])->name('leaves.update');
    Route::get('leave-settings', [EmployeeController::class, 'leaveSettings'])->name('leave-settings');
    Route::get('attendance', [EmployeeController::class, 'attendanceAdmin'])->name('attendance');
    Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
    Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
    Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
    Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
    Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');

    // Department Module Management routes
    Route::get('department-modules', [DepartmentModuleController::class, 'index'])->name('department-modules.index');
    Route::post('department-modules/store', [DepartmentModuleController::class, 'store'])->name('department-modules.store');
    Route::post('department-modules/destroy', [DepartmentModuleController::class, 'destroy'])->name('department-modules.destroy');
    Route::post('department-modules/toggle', [DepartmentModuleController::class, 'toggle'])->name('department-modules.toggle');
    Route::get('department-modules/{departmentName}/modules', [DepartmentModuleController::class, 'getModulesByDepartment'])->name('department-modules.get-modules');

    // App routes
    Route::get('case-history', [AgentController::class, 'caseHistorySearch'])->name('view.case-history');
    Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
    Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
    Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');

    Route::get('customer/case-history', [CustomerController::class, 'caseHistorySearch'])->name('customer.case-history');
    Route::post('customer/casehistory/store', [CustomerController::class, 'caseStore'])->name('customer.case.store');
    Route::patch('customer/casehistory/update/{id}', [CustomerController::class, 'caseUpdate'])->name('customer.cases.update');
    Route::post('customer/casehistory/close/{id}', [CustomerController::class, 'caseClose'])->name('customer.cases.close');

    Route::post('customer/conversation/store', [CustomerController::class, 'conversationStore'])->name('customer.conversation.store');
    Route::post('customer/address/store', [CustomerController::class, 'AddressStore'])->name('customer.address.store');
    Route::post('customer/contact/store', [CustomerController::class, 'ContactStore'])->name('customer.contact.store');
    Route::post('customer/contact/update/{id}', [CustomerController::class, 'contactUpdate'])->name('customer.contact.update');
    Route::delete('customer/contact/delete/{id}', [CustomerController::class, 'contactDelete'])->name('customer.contact.delete');
    Route::post('customer/address/update/{id}', [CustomerController::class, 'addressUpdate'])->name('customer.address.update');

    Route::get('airlines-details', [AirlineDetailController::class, 'index'])->name('airlines-details');
    Route::post('airlines-details/store', [AirlineController::class, 'store'])->name('airlines-details.store');
    Route::patch('/airline-details/{airlineDetail}', [AirlineController::class, 'update'])->name('airlines-details.update');
    Route::delete('/airline-details/delete/{airlineDetail}', [AirlineController::class, 'delete'])->name('airlines-details.delete');
    Route::delete('/admin/airline-details/{airlineDetail}', [AirlineDetailController::class, 'destroy'])->name('airlines-details.destroy');

    Route::get('/delay-code', [DelaycodeController::class, 'delay'])->name('delay.code');
    Route::get('/delay-code-category', [CategoryController::class, 'delaycategory'])->name('delay.code.category');
    Route::get('/origin', [CategoryController::class, 'origin'])->name('origin');
    Route::post('origin/store', [CategoryController::class, 'originstore'])->name('origins.store');
    Route::put('origin/{origin}/update', [CategoryController::class, 'originupdate'])->name('origins.update');
    Route::delete('origin/{origin}', [CategoryController::class, 'origindestroy'])->name('origins.destroy');
    Route::get('/destination', [CategoryController::class, 'destination'])->name('destination');
    Route::post('destination/store', [CategoryController::class, 'destinationstore'])->name('destinations.store');
    Route::put('destination/{destination}/update', [CategoryController::class, 'destinationupdate'])->name('destinations.update');
    Route::delete('destination/{destination}', [CategoryController::class, 'destinationdestroy'])->name('destinations.destroy');
    Route::post('delaycategories/store', [CategoryController::class, 'store'])->name('delay_code_categories.store');
    Route::put('delaycategories/{id}/update', [CategoryController::class, 'update'])->name('delay_code_categories.update');
    Route::delete('delaycategories/{id}/destroy', [CategoryController::class, 'destroy'])->name('delay_code_categories.destroy');
    Route::post('delay-code/store', [DelaycodeController::class, 'store'])->name('delaycodes.store');
    Route::put('delay-code/{id}/update', [DelaycodeController::class, 'update'])->name('delaycodes.update');
    Route::delete('delay-code/{id}/destroy', [DelaycodeController::class, 'destroy'])->name('delaycodes.destroy');

    Route::get('/agent/library', [AgentLibraryController::class, 'index'])->name('agent-library');
    Route::post('agent/library/store', [AgentLibraryController::class, 'store'])->name('agent.library.store');

    Route::get('library', [AirlineLibraryController::class, 'library'])->name('airline-library');
    Route::post('library/store', [AirlineLibraryController::class, 'store'])->name('library.store');
    Route::post('library/airine/store', [AirlineLibraryController::class, 'viewstore'])->name('library.viewstore');
    Route::get('library/{library}/documents', [AirlineLibraryController::class, 'viewDocuments'])->name('library.documents');

    Route::get('license', [LicenseApprovalController::class, 'index'])->name('license');
    Route::post('license/store', [LicenseApprovalController::class, 'store'])->name('license.store');
    Route::patch('license_approvals/{licenseApproval}/status', [LicenseApprovalController::class, 'updateStatus'])->name('license_approvals.updateStatus');
    Route::delete('license_approvals/{licenseApproval}', [LicenseApprovalController::class, 'destroy'])->name('license_approvals.destroy');
    Route::get('flights', [FlightController::class, 'index'])->name('flights');
    Route::get('flights/create', [FlightController::class, 'create'])->name('flights.create');
    Route::post('flights', [FlightController::class, 'store'])->name('flights.store');
    Route::get('flights/{flight}', [FlightController::class, 'show'])->name('flights.show');
    Route::get('flights/{flight}/edit', [FlightController::class, 'edit'])->name('flights.edit');
    Route::put('flights/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::patch('flights/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::delete('flights/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');

    Route::get('wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('wallet/store', [WalletController::class, 'store'])->name('wallet.store');
    Route::put('wallets/edit/{id}', [WalletController::class, 'update'])->name('wallet.update');
    Route::delete('wallets/{id}', [WalletController::class, 'destroy'])->name('wallet.destroy');

    Route::get('walletrequest', [WalletRequestController::class, 'index'])->name('walletrequest');

    Route::get('sectors', [SectorController::class, 'index'])->name('sectors');
    Route::post('store-sector', [SectorController::class, 'store'])->name('sector.store');
    Route::put('update-sector/{id}', [SectorController::class, 'update'])->name('sector.update');
    Route::delete('delete-sector/{id}', [SectorController::class, 'destroy'])->name('sector.delete');

    Route::get('inventories', [InventoryController::class, 'index'])->name('inventories');
    Route::get('inventories/expiry', [InventoryController::class, 'expiryinventory'])->name('expiry.inventories');
    Route::post('inventories/store', [InventoryController::class, 'store'])->name('inventory.store');

    Route::get('admin-holds', [AdminHoldController::class, 'index'])->name('adminholds');
    Route::get('/view-holds/{id}', [HoldController::class, 'view'])->name('view-holds');
    Route::get('/edit-hold/{id}', [HoldController::class, 'edit'])->name('edit-hold');
    Route::post('/edit-hold/{id}', [HoldController::class, 'update'])->name('edit-hold');
    Route::get('holds-confirm/', [HoldController::class, 'confirmHold'])->name('holdsconfirm');

    Route::delete('wallet/delete', [AgentController::class, 'deleteWallet'])->name('wallet.delete');
    Route::post('store-wallet', [AgentController::class, 'storeWallet'])->name('store.wallet');
    Route::post('agentgroups/store', [AgentController::class, 'groupstore'])->name('agentgroups.store');
    Route::put('agentgroups/update/{id}', [AgentController::class, 'groupupdate'])->name('agentgroups.update');
    Route::delete('wallet/requests/{id}', [AgentController::class, 'deleteWalletRequest'])->name('wallet.requests.delete');
    Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
    Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
    Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
    Route::post('airline/target/store', [AirlineController::class, 'targetStore'])->name('airline.target.store');
    Route::post('staff/approvedStaff/store', [EmployeeController::class, 'approvedStaffRightsStore'])->name('staff.approved-staff-rights.store');
    Route::post('airline/approvedStaff/store', [AirlineController::class, 'approvedStaffRightsStore'])->name('airline.approved-staff-rights.store');
    Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
    Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
    Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
    Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
    Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
    Route::get('agent/update/{id}', [AgentController::class, 'update'])->name('agent.update');
    Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
    Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
    Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
    Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');
    Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
    Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
    Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
    Route::post('agent/general/update/{id}', [AgentController::class, 'generalUpdate'])->name('agent.general.update');
    Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
    Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
    Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::get('events', [AppController::class, 'calendar'])->name('events');
    Route::post('events/store', [AppController::class, 'store'])->name('events.store');
    Route::patch('events/update/{id}', [AppController::class, 'update'])->name('events.update');
    Route::get('airlines', [AirlineController::class, 'index'])->name('airlines');
    Route::post('airlines/store', [AirlineController::class, 'store'])->name('airlines.store');
    Route::patch('airlines/edit/{id}', [AirlineController::class, 'update'])->name('airlines.update');
    Route::get('airlines/view/{id}', [AirlineController::class, 'view'])->name('airlines.view');
    Route::get('airlines/get-special-fare/{id}', [AirlineController::class, 'searchSpecialFare'])->name('airlines.special.fare');
    Route::post('airlines/aircraft/', [AirlineController::class, 'aircraftStore'])->name('airline.aircraft.store');
    Route::post('airlines/fleet/', [AirlineController::class, 'fleetStore'])->name('airline.fleet.store');
    Route::patch('airlines/aircraft/update/{id}', [AirlineController::class, 'aircraftUpdate'])->name('airline.aircraft.update');
    Route::delete('airlines/aircraft/delete/{id}', [AirlineController::class, 'aircraftDelete'])->name('airline.aircraft.destroy');
    Route::post('airlines/fleet/update/{id}', [AirlineController::class, 'fleetUpdate'])->name('airline.fleet.update');
    Route::delete('airlines/fleet/delete/{id}', [AirlineController::class, 'fleetDelete'])->name('airline.fleet.destroy');
    Route::post('airlines/approved-staff/', [AirlineController::class, 'approvedStaffStore'])->name('airline.approvedstaff.store');
    Route::post('airlines/approved-staff/upadte/{id}', [AirlineController::class, 'approvedStaffUpdate'])->name('airline.approvedstaff.update');
    Route::get('agent', [AgentController::class, 'index'])->name('agents');
    Route::get('deleted/agent', [AgentController::class, 'deletedAgent'])->name('deleted.agents');

    // B2B Partners routes
        Route::get('b2b-partners', [B2BPartnerController::class, 'index'])->name('b2b-partners');
        Route::get('b2b-partners/create', [B2BPartnerController::class, 'create'])->name('b2b-partners.create');
        Route::post('b2b-partners', [B2BPartnerController::class, 'store'])->name('b2b-partners.store');
        Route::get('b2b-partners/{id}', [B2BPartnerController::class, 'show'])->name('b2b-partners.show');
        Route::get('b2b-partners/{id}/edit', [B2BPartnerController::class, 'edit'])->name('b2b-partners.edit');
        Route::put('b2b-partners/{id}', [B2BPartnerController::class, 'update'])->name('b2b-partners.update');
        Route::delete('b2b-partners/{id}', [B2BPartnerController::class, 'destroy'])->name('b2b-partners.destroy');
        Route::post('b2b-partners/{partnerId}/contacts', [B2BPartnerController::class, 'storeContact'])->name('b2b-partners.contacts.store');
        Route::put('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'updateContact'])->name('b2b-partners.contacts.update');
        Route::delete('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'deleteContact'])->name('b2b-partners.contacts.destroy');
        Route::post('b2b-partners/{partnerId}/documents', [B2BPartnerController::class, 'storeDocument'])->name('b2b-partners.documents.store');
        Route::delete('b2b-partners/documents/{id}', [B2BPartnerController::class, 'deleteDocument'])->name('b2b-partners.documents.destroy');
        Route::post('b2b-partners/{partnerId}/notes', [B2BPartnerController::class, 'storeNote'])->name('b2b-partners.notes.store');
        Route::delete('b2b-partners/notes/{id}', [B2BPartnerController::class, 'deleteNote'])->name('b2b-partners.notes.destroy');
        Route::delete('b2b-partners/airlines/{id}', [B2BPartnerController::class, 'deleteAirline'])->name('b2b-partners.airlines.destroy');
        Route::delete('b2b-partners/products/{id}', [B2BPartnerController::class, 'deleteProduct'])->name('b2b-partners.products.destroy');
        Route::get('b2b-partners/reports', [B2BPartnerController::class, 'reports'])->name('b2b-partners.reports');
        Route::post('b2b-partners/generate-report', [B2BPartnerController::class, 'generateReport'])->name('b2b-partners.generate-report');
        Route::get('b2b-partners/search', [B2BPartnerController::class, 'search'])->name('b2b-partners.search');

    // B2C Customers routes for staff
        Route::get('b2c-customers', [B2CCustomerController::class, 'index'])->name('b2c-customers.index');
        Route::get('b2c-customers/create', [B2CCustomerController::class, 'create'])->name('b2c-customers.create');
        Route::post('b2c-customers', [B2CCustomerController::class, 'store'])->name('b2c-customers.store');
        Route::get('b2c-customers/{id}', [B2CCustomerController::class, 'show'])->name('b2c-customers.show');
        Route::get('b2c-customers/{id}/edit', [B2CCustomerController::class, 'edit'])->name('b2c-customers.edit');
        Route::put('b2c-customers/{id}', [B2CCustomerController::class, 'update'])->name('b2c-customers.update');
        Route::delete('b2c-customers/{id}', [B2CCustomerController::class, 'destroy'])->name('b2c-customers.destroy');
        Route::patch('b2c-customers/{id}/toggle-status', [B2CCustomerController::class, 'toggleStatus'])->name('b2c-customers.toggle-status');

        // B2C Passenger routes for staff
        Route::get('b2c-customers/{customerId}/passengers/create', [B2CCustomerController::class, 'addPassenger'])->name('b2c-customers.passengers.create');
        Route::post('b2c-customers/{customerId}/passengers', [B2CCustomerController::class, 'storePassenger'])->name('b2c-customers.passengers.store');
        Route::get('b2c-customers/{customerId}/passengers/{passengerId}/edit', [B2CCustomerController::class, 'editPassenger'])->name('b2c-customers.passengers.edit');
        Route::put('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'updatePassenger'])->name('b2c-customers.passengers.update');
        Route::delete('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'deletePassenger'])->name('b2c-customers.passengers.delete');

        // B2C Notes routes for staff
        Route::post('b2c-customers/{customerId}/notes', [B2CCustomerController::class, 'storeNote'])->name('b2c-customers.notes.store');
        Route::delete('b2c-customers/{customerId}/notes/{noteId}', [B2CCustomerController::class, 'deleteNote'])->name('b2c-customers.notes.delete');
        Route::get('b2c-customers/search', [B2CCustomerController::class, 'search'])->name('b2c-customers.search');

        // B2C Documents routes for staff
        Route::post('b2c-customers/{customerId}/documents', [B2CCustomerController::class, 'storeDocument'])->name('b2c-customers.documents.store');
        Route::delete('b2c-customers/{customerId}/documents/{documentId}', [B2CCustomerController::class, 'deleteDocument'])->name('b2c-customers.documents.delete');

    Route::patch('airlines/specialfares/update/{id}', [AirlineController::class, 'specialfaresUpdate'])->name('airline.specialfares.update');
    Route::get('deleted/airlines', [AirlineController::class, 'deletedAirline'])->name('deleted.airlines');
    Route::post('airlines/SLA/store', [AirlineController::class, 'slaStore'])->name('airline.sla.store');
    Route::patch('airlines/SLA/{id}/update', [AirlineController::class, 'slaUpdate'])->name('airline.sla.update');
    Route::patch('airline/sla/toggle-status/{id}', [AirlineController::class, 'slaUpdateStatus']);
    Route::delete('airlines/SLA/{id}/destroy', [AirlineController::class, 'slaDestroy'])->name('airline.sla.destroy');
    Route::post('airlines/approved-staff/update-status', [AirlineController::class, 'approvedStaffUpdateStatus'])->name('airline.approvedstaff.updatestatus');
    Route::post('airlines/head_office/store', [AirlineController::class, 'headOfficeStore'])->name('airline.head_office.store');
    Route::patch('airlines/head_office/{id}/update', [AirlineController::class, 'headOfficeUpdate'])->name('airline.head_office.update');
    Route::delete('airlines/head_office/{id}/destroy', [AirlineController::class, 'headOfficeDestroy'])->name('airline.head_office.destroy');
    Route::get('sales-lead', [SalesLeadController::class, 'index'])->name('saleslead');
    Route::post('sales-lead/store', [SalesLeadController::class, 'store'])->name('saleslead.store');
    Route::post('sales-lead/staff/store', [SalesLeadController::class, 'assignStaff'])->name('saleslead.staff.store');
    Route::patch('sales-lead/edit/{id}', [SalesLeadController::class, 'update'])->name('saleslead.update');
    Route::get('air-tickets', [AirTicketController::class, 'index'])->name('air-tickets');
    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');
    Route::patch('groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
    
    
    // Ticket Status routes
    Route::get('ticket-status', [TicketStatusController::class, 'index'])->name('ticket-status.index');
    Route::get('ticket-status/create', [TicketStatusController::class, 'create'])->name('ticket-status.create');
    Route::post('ticket-status', [TicketStatusController::class, 'store'])->name('ticket-status.store');
    Route::get('ticket-status/{ticketStatus}/edit', [TicketStatusController::class, 'edit'])->name('ticket-status.edit');
    Route::patch('ticket-status/{ticketStatus}', [TicketStatusController::class, 'update'])->name('ticket-status.update');
    Route::delete('ticket-status/{ticketStatus}', [TicketStatusController::class, 'destroy'])->name('ticket-status.destroy');
    Route::get('timesheet', [EmployeeController::class, 'timesheet'])->name('timesheet');
    Route::get('shift-scheduling', [EmployeeController::class, 'shiftScheduling'])->name('shift-scheduling');
    Route::get('overtime', [EmployeeController::class, 'overtime'])->name('overtime');
    Route::post('reportsick/store', [EmployeeController::class, 'storeReportSick'])->name('reportsick.store');
    Route::post('newabsence/store', [EmployeeController::class, 'storeNewAbsence'])->name('newabsence.store');
    Route::get('tasks', [TaskController::class, 'tasks'])->name('tasks');
    Route::get('task-board', [TaskController::class, 'taskBoard'])->name('task-board');
    
    // Get staff by department for SuperAdmin
    Route::get('get-staff-by-department', [SupportTicketController::class, 'getStaffByDepartment'])->name('get-staff-by-department');
    
    Route::get('leads', [LeadController::class, 'index'])->name('leads');
    Route::get('events/status', [EventStatusController:: class, 'index'])->name('events.status');
    Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');
    Route::patch('events/status/update/{id}', [EventStatusController::class, 'update'])->name('events.status.update');
    Route::delete('events/status/delete/{id}', [EventStatusController::class, 'delete'])->name('events.status.delete');
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('estimates', [SalesController::class, 'estimates'])->name('estimates');
    Route::get('invoices', [SalesController::class, 'invoices'])->name('invoices');
    Route::get('payments', [SalesController::class, 'payments'])->name('payments');
    Route::get('expenses', [SalesController::class, 'expenses'])->name('expenses');
    Route::get('provident-fund', [SalesController::class, 'providentFund'])->name('provident-fund');
    Route::get('taxes', [SalesController::class, 'taxes'])->name('taxes');
    Route::get('categories', [AccountingController::class, 'categories'])->name('categories');
    Route::get('budgets', [AccountingController::class, 'budgets'])->name('budgets');
    Route::get('budget-expenses', [AccountingController::class, 'budgetExpenses'])->name('budget-expenses');
    Route::get('budget-revenues', [AccountingController::class, 'budgetRevenues'])->name('budget-revenues');

    Route::get('customer/accounts/view', [AccountController::class, 'indexCustomerAccount'])->name('customer.accounts.view');
    Route::get('customer/accounts/all', [AccountController::class, 'viewCustomerAccount'])->name('customer.accounts.all');
    Route::get('customer/accounts/invoice/{id}', [AccountController::class, 'viewCustomerInvoice'])->name('customer.account.invoice');
    Route::post('customer/account/store', [AccountController::class, 'storeCustomerAccount'])->name('customer.account.store');
    Route::get('customer/account/edit/{id}', [AccountController::class, 'editCustomerAccount'])->name('customer.account.edit');
    Route::put('customer/account/update/{id}', [AccountController::class, 'updateCustomerAccount'])->name('customer.account.update');
    Route::post('customer/update-account-status', [AccountController::class, 'updateCustomerAccountStatus'])->name('customer.account.updateStatus');
    Route::post('customer/transaction/store', [CustomerController::class, 'transactionStore'])->name('customer.transaction.store');
    Route::get('customer/ledger', [AccountController::class, 'customerLedger'])->name('customer.ledger');
    Route::get('general-ledger', [AccountController::class, 'generalLedger'])->name('general-ledger');
    Route::get('supplier-ledger', [AccountController::class, 'supplierLedger'])->name('supplier-ledger');
    Route::get('expense-entry', [AccountController::class, 'expenseEntry'])->name('expense-entry');
    
    // Payment Pool routes
    Route::get('payment-pool', [PaymentPoolController::class, 'index'])->name('payment-pool');
    Route::post('payment-pool/store', [PaymentPoolController::class, 'store'])->name('payment-pool.store');
    Route::post('payment-pool/allocate/{id}', [PaymentPoolController::class, 'allocate'])->name('payment-pool.allocate');
    Route::post('payment-pool/deallocate/{id}', [PaymentPoolController::class, 'deallocate'])->name('payment-pool.deallocate');
    Route::delete('payment-pool/destroy/{id}', [PaymentPoolController::class, 'destroy'])->name('payment-pool.destroy');
    Route::post('payment-pool/create-expense', [PaymentPoolController::class, 'createExpense'])->name('payment-pool.create-expense');
    Route::post('payment-pool/create-supplier-payment', [PaymentPoolController::class, 'createSupplierPayment'])->name('payment-pool.create-supplier-payment');
    Route::post('payment-pool/split-allocation', [PaymentPoolController::class, 'splitAllocation'])->name('payment-pool.split-allocation');
    
    Route::get('accounts/view', [AccountController::class, 'account'])->name('accounts.view');
    Route::get('accounts/all', [AccountController::class, 'viewAccount'])->name('accounts.all');
    Route::get('accounts/invoice/{id}', [AccountController::class, 'viewInvoice'])->name('account.invoice');
    Route::post('account/store', [AccountController::class, 'storeAccount'])->name('account.store');
    Route::get('account/edit/{id}', [AccountController::class, 'editAccount'])->name('account.edit');
    Route::put('account/update/{id}', [AccountController::class, 'updateAccount'])->name('account.update');
    Route::post('/update-account-status', [AccountController::class, 'updateStatus'])->name('account.updateStatus');
    Route::get('reservations/new-sale', [ReservationController::class, 'newSale'])->name('reservation.newsale');
    Route::post('reservations/store', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('sales-packages', [SalesPackageController::class, 'index'])->name('sales-packages.index');
    Route::get('sales-packages/create', [SalesPackageController::class, 'create'])->name('sales-packages.create');
    Route::post('sales-packages/store', [SalesPackageController::class, 'store'])->name('sales-packages.store');
    Route::get('sales-packages/edit/{id}', [SalesPackageController::class, 'edit'])->name('sales-packages.edit');
    Route::put('sales-packages/update/{id}', [SalesPackageController::class, 'update'])->name('sales-packages.update');
    Route::delete('sales-packages/destroy/{id}', [SalesPackageController::class, 'destroy'])->name('sales-packages.destroy');
    Route::get('sales-packages/toggle-status/{id}', [SalesPackageController::class, 'toggleStatus'])->name('sales-packages.toggle-status');
    Route::get('sales-packages/{id}', [SalesPackageController::class, 'getPackage'])->name('sales-packages.get');
    Route::get('sales-packages/{packageId}/permissions', [SalesPackageController::class, 'getPackagePermissions'])->name('sales-packages.get.permissions');
    Route::post('sales-packages/save-permissions', [SalesPackageController::class, 'savePackagePermissions'])->name('sales-packages.save.permissions');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('customer-subscriptions', [SubscriptionController::class, 'customerSubscriptions'])->name('customer.subscriptions');
    Route::post('customer-subscriptions/store', [SubscriptionController::class, 'storeCustomerSubscription'])->name('customer.subscriptions.store');
    Route::get('customer-subscriptions/get-permissions', [SubscriptionController::class, 'getSubscriptionPermissions'])->name('customer.subscriptions.get.permissions');
    Route::post('customer-subscriptions/save-permissions', [SubscriptionController::class, 'saveSubscriptionPermissions'])->name('customer.subscriptions.save.permissions');
    Route::get('customer-module-permissions/{id}', [SubscriptionController::class, 'getCustomerModulePermissions'])->name('module.permissions');
    Route::post('customer-update-module-access', [SubscriptionController::class, 'updateCustomerModuleAccess'])->name('update.module.access');

    // Bank Accounts routes
    Route::get('bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');
    Route::get('bank-accounts/create', [BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('bank-accounts/store', [BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::get('bank-accounts/edit/{id}', [BankAccountController::class, 'edit'])->name('bank-accounts.edit');
    Route::put('bank-accounts/update/{id}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
    Route::delete('bank-accounts/destroy/{id}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');
    Route::get('bank-accounts/toggle-status/{id}', [BankAccountController::class, 'toggleStatus'])->name('bank-accounts.toggle-status');
    
    Route::get('staff-reports', [StaffReportController::class, 'index'])->name('staff-reports');
    Route::get('airline-reports', [AirlineController::class, 'report'])->name('airline-reports');
    Route::get('agent-reports', [AgentReportController::class, 'airlineReport'])->name('agent-reports');
    Route::get('customer-reports', [CustomerReportController::class, 'customerReport'])->name('customer-reports');
    Route::get('salary', [PayrollController::class, 'employeeSalary'])->name('salary');
    Route::get('manage-staff', [EmployeeController::class, 'manageStaff'])->name('manage-staff');
    Route::get('/admin/manage-salary/{id}', [PayrollController::class, 'employeeSalaryId'])->name('manage-salary');
    Route::post('/admin/manage-salary/store', [PayrollController::class, 'employeeSalaryIdStore'])->name('manage-salary.store');
    Route::post('salary/store', [PayrollController::class, 'employeeSalaryStore'])->name('salary.store');
    Route::get('salary-view/{id}', [PayrollController::class, 'payslip'])->name('salary-view');
    Route::get('payroll-items', [PayrollController::class, 'payrollItems'])->name('payroll-items');
    Route::get('policies', [PolicyController::class, 'index'])->name('policies');
    Route::post('policies/store', [PolicyController::class, 'store'])->name('policies.store');
    Route::patch('policies/update', [PolicyController::class, 'update'])->name('policies.update');
    Route::patch('airline/sla/{id}/statusupdate', [AirlineController::class, 'slaUpdateStatus'])->name('airline.sla.statusupdate');
    Route::patch('airline/headOffice/toggle-status/{id}', [AirlineController::class, 'headOfficeUpdateStatus'])->name('airline.headOffice.statusupdate');
    Route::patch('airline/fleet/toggle-status/{id}', [AirlineController::class, 'fleetUpdateStatus'])->name('airline.fleet.statusupdate');
    Route::patch('airline/schedule/statusupdate/{id}', [AirlineController::class, 'scheduleUpdateStatus'])->name('airline.schedule.statusupdate');
    Route::patch('airline/library/statusupdate/{id}', [AirlineController::class, 'librarystatusUpdate'])->name('airline.library.statusupdate');
    Route::patch('airline/rules/statusupdate/{id}', [AirlineController::class, 'rulesupdateStatus'])->name('airline.rules.statusupdate');
    Route::patch('airline/specialfares/statusupdate/{id}', [AirlineController::class, 'specialfaresupdateStatus'])->name('airline.specialfares.statusupdate');
    Route::patch('admin/agreements/statusupdate/{id}', [AirlineController::class, 'agreemenstStatusUpdate'])->name('airline.agreements.statusupdate');
    Route::post('airlines/agreements/store', [AirlineController::class, 'agreementsStore'])->name('airline.agreements.store');
    Route::patch('airlines/agreements/{id}/update', [AirlineController::class, 'agreementsUpdate'])->name('airline.agreements.update');
    Route::patch('airlines/agreements/{id}/destroy', [AirlineController::class, 'agreementsDestroy'])->name('airline.agreements.destroy');
    Route::post('airlines/pli/store', [AirlineController::class, 'pliStore'])->name('airline.pli.store');
    Route::patch('airlines/library/{id}', [AirlineController::class, 'libraryupdate'])->name('airline.library.update');
    Route::delete('airlines/library/delete/{id}', [AirlineController::class, 'libraryDelete'])->name('airline.library.destroy');
    Route::post('airlines/rules/store', [AirlineController::class, 'rulesStore'])->name('airline.rules.store');
    Route::patch('airlines/rules/update/{id}', [AirlineController::class, 'rulesUpdate'])->name('airline.rules.update');
    Route::get('expense-reports', [ReportController::class, 'expenseReport'])->name('expense-reports');
    Route::get('invoice-reports', [ReportController::class, 'invoiceReport'])->name('invoice-reports');
    Route::get('payments-reports', [ReportController::class, 'paymentsReport'])->name('payments-reports');
    Route::get('project-reports', [ReportController::class, 'projectReport'])->name('project-reports');
    Route::get('task-reports', [ReportController::class, 'taskReport'])->name('task-reports');
    Route::get('user-reports', [ReportController::class, 'userReport'])->name('user-reports');
    Route::get('employee-reports', [ReportController::class, 'employeeReport'])->name('employee-reports');
    Route::get('payslip-reports', [ReportController::class, 'payslipReport'])->name('payslip-reports');
    Route::get('attendance-reports', [ReportController::class, 'attendanceReport'])->name('attendance-reports');
    Route::get('leave-reports', [ReportController::class, 'leaveReport'])->name('leave-reports');
    Route::get('daily-reports', [ReportController::class, 'dailyReport'])->name('daily-reports');
    Route::get('performance-indicator', [PerformanceController::class, 'performanceIndicator'])->name('performance-indicator');
    Route::get('performance-review', [PerformanceController::class, 'performanceReview'])->name('performance-review');
    Route::get('performance-appraisal', [PerformanceController::class, 'performanceAppraisal'])->name('performance-appraisal');
    Route::get('goal-tracking', [GoalController::class, 'goalList'])->name('goal-tracking');
    Route::get('goal-type', [GoalController::class, 'goalType'])->name('goal-type');
    Route::get('training', [TrainingController::class, 'trainingList'])->name('training');
    Route::get('trainers', [TrainingController::class, 'trainers'])->name('trainers');
    Route::get('training-type', [TrainingController::class, 'trainingType'])->name('training-type');
    Route::get('promotion', [HRController::class, 'promotion'])->name('promotion');
    Route::get('resignation', [HRController::class, 'resignation'])->name('resignation');
    Route::get('termination', [HRController::class, 'termination'])->name('termination');
    Route::post('termination/store', [HRController::class, 'terminationStore'])->name('termination.store');
    Route::post('termination/update', [HRController::class, 'terminationUpdate'])->name('termination.update');
    Route::post('resignation/store', [HRController::class, 'resignationStore'])->name('resignation.store');
    Route::patch('resignation/update', [HRController::class, 'resignationUpdate'])->name('resignation.update');
    Route::get('assets', [AdministrationController::class, 'assets'])->name('assets');
    Route::get('user-dashboard', [JobController::class, 'userDashboard'])->name('user-dashboard');
    Route::get('jobs-dashboard', [JobController::class, 'jobsDashboard'])->name('jobs-dashboard');
    Route::get('jobs', [JobController::class, 'manageJobs'])->name('jobs');
    Route::get('manage-resumes', [JobController::class, 'manageResumes'])->name('manage-resumes');
    Route::get('shortlist-candidates', [JobController::class, 'shortlistCandidates'])->name('shortlist-candidates');
    Route::get('interview-questions', [JobController::class, 'interviewQuestions'])->name('interview-questions');
    Route::get('offer-approvals', [JobController::class, 'offerApprovals'])->name('offer-approvals');
    Route::get('experience-level', [JobController::class, 'experienceLevel'])->name('experience-level');
    Route::get('candidates', [JobController::class, 'candidatesList'])->name('candidates');
    Route::get('schedule-timing', [JobController::class, 'scheduleTiming'])->name('schedule-timing');
    Route::get('apptitude-result', [JobController::class, 'aptitudeResults'])->name('apptitude-result');
    Route::get('knowledgebase', [KnowledgebaseController::class, 'index'])->name('knowledgebase');
    Route::get('activities', [ActivityController::class, 'index'])->name('activities');
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::get('client-profile', [ProfileController::class, 'clientProfile'])->name('client-profile');
    Route::get('admin-profile', [ProfileController::class, 'adminProfile'])->name('admin-profile');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/timezone', [ProfileController::class, 'updateTimezone'])->name('profile.timezone');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('roles-permissions', [ModuleController::class, 'index'])->name('roles-permissions.index');
    Route::post('modules/update', [ModuleController::class, 'update'])->name('modules.update');
    Route::post('modules/toggle-status', [ModuleController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::get('fare_conditions', [FareConditionController::class, 'index'])->name('fare_conditions.index');
    Route::get('fare_conditions/create', [FareConditionController::class, 'create'])->name('fare_conditions.create');
    Route::post('fare_conditions', [FareConditionController::class, 'store'])->name('fare_conditions.store');
    Route::get('fare_conditions/{fare_condition}', [FareConditionController::class, 'show'])->name('fare_conditions.show');
    Route::get('fare_conditions/{fare_condition}/edit', [FareConditionController::class, 'edit'])->name('fare_conditions.edit');
    Route::put('fare_conditions/{fare_condition}', [FareConditionController::class, 'update'])->name('fare_conditions.update');
    Route::delete('fare_conditions/{fare_condition}', [FareConditionController::class, 'destroy'])->name('fare_conditions.destroy');
    Route::put('/airtickets/{id}/update-status', 'AirTicketController@updateStatus')->name('airtickets.update_status');
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');

    // System Admin routes for customers
    Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
    Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
    Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
    Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
    Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');
    Route::get('department-modules', [DepartmentModuleController::class, 'index'])->name('department-modules.index');
    Route::post('department-modules/store', [DepartmentModuleController::class, 'store'])->name('department-modules.store');
    Route::post('department-modules/destroy', [DepartmentModuleController::class, 'destroy'])->name('department-modules.destroy');
    Route::post('department-modules/toggle', [DepartmentModuleController::class, 'toggle'])->name('department-modules.toggle');
    Route::get('categories/view', [CategoryController::class, 'category'])->name('categories.view');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
    Route::post('/update-category-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');
    Route::get('duties', [DutyController::class, 'duties'])->name('duties');
    Route::post('duties/store', [DutyController::class, 'storeDuty'])->name('duties.store');
    Route::put('duties/update/{id}', [DutyController::class, 'updateDuty'])->name('duties.update');
    Route::post('/update-duty-status', [DutyController::class, 'updateStatus'])->name('duties.updateStatus');
    Route::get('events/status', [EventStatusController::class, 'index'])->name('events.status');
    Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');
    Route::patch('events/status/update/{id}', [EventStatusController::class, 'update'])->name('events.status.update');
    Route::delete('events/status/delete/{id}', [EventStatusController::class, 'delete'])->name('events.status.delete');
    Route::get('ticket-status', [TicketStatusController::class, 'index'])->name('ticket-status.index');
    Route::get('ticket-status/create', [TicketStatusController::class, 'create'])->name('ticket-status.create');
    Route::post('ticket-status', [TicketStatusController::class, 'store'])->name('ticket-status.store');
    Route::get('ticket-status/{ticketStatus}/edit', [TicketStatusController::class, 'edit'])->name('ticket-status.edit');
    Route::patch('ticket-status/{ticketStatus}', [TicketStatusController::class, 'update'])->name('ticket-status.update');
    Route::delete('ticket-status/{ticketStatus}', [TicketStatusController::class, 'destroy'])->name('ticket-status.destroy');
    Route::get('leave-type', [LeaveTypeController::class, 'leaveType'])->name('leave-type');
    Route::post('leave-type/store', [LeaveTypeController::class, 'storeLeaveType'])->name('leave-type.store');
    Route::put('leave-type/update/{id}', [LeaveTypeController::class, 'updateLeaveType'])->name('leave-type.update');
    Route::delete('leave-type/delete/{id}', [LeaveTypeController::class, 'deleteLeaveType'])->name('leave-type.delete');
    Route::post('/update-leavetype-status', [LeaveTypeController::class, 'updateStatus'])->name('leave-type.updateStatus');
    Route::get('faretypes', [FareTypeController::class, 'index'])->name('faretypes');
    Route::post('faretypes/store', [FareTypeController::class, 'store'])->name('faretypes.store');
    Route::put('faretypes/update/{id}', [FareTypeController::class, 'update'])->name('faretypes.update');
    Route::delete('faretypes/delete/{id}', [FareTypeController::class, 'delete'])->name('faretypes.delete');
    Route::get('discounts', [DiscountController::class, 'index'])->name('discounts');
    Route::post('discounts/store', [DiscountController::class, 'discountStore'])->name('discounts.store');
    Route::put('discounts/update/{id}', [DiscountController::class, 'discountUpdate'])->name('discounts.update');
    Route::delete('discounts/delete/{id}', [DiscountController::class, 'discountDelete'])->name('discounts.delete');



    });

// Staff routes - accessible by users from users table
Route::prefix('staff')->name('staff.')->middleware(['staff'])->group(function () {
    Route::get('/logout', [StaffController::class, 'logout'])->name('logout');
    Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');

    // Search routes accessible to all authenticated staff (needed for booking form)
    Route::get('b2b-partners/search', [B2BPartnerController::class, 'search'])->name('b2b-partners.search');
    Route::get('b2c-customers/search', [B2CCustomerController::class, 'search'])->name('b2c-customers.search');

    // Staff dashboard and other routes can be added here
    Route::get('dashboard', [DashboardController::class, 'staffDashboard'])->name('dashboard');

    // Module access routes for staff
    Route::post('/update-module-access', [EmployeeController::class, 'updateModuleAccess'])->name('employee.update.module.access');
    Route::get('/employee-module-permissions/{id}', [EmployeeController::class, 'getEmployeeModulePermissions'])->name('employee.module.permissions');
    Route::get('/available-modules', [EmployeeController::class, 'getAvailableModules'])->name('available.modules');

    // Support Tickets routes for staff
    Route::middleware(['module.access:support-tickets'])->group(function () {
        Route::get('support-tickets', [SupportTicketController::class, 'ticketDashboard'])->name('support-tickets.dashboard');
        Route::get('support-tickets/all', [SupportTicketController::class, 'dashboardStatistics'])->name('support-tickets.index');

        Route::post('support-tickets', [SupportTicketController::class, 'store'])->name('support-tickets.store');
        Route::get('support-tickets/{id}', [SupportTicketController::class, 'show'])->name('support-tickets.show');
        Route::patch('support-tickets/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('support-tickets.update-status');
        Route::post('support-tickets/{id}/assign', [SupportTicketController::class, 'assign'])->name('support-tickets.assign');
        Route::post('support-tickets/{id}/comment', [SupportTicketController::class, 'addComment'])->name('support-tickets.add-comment');
        Route::post('support-tickets/{id}/internal-note', [SupportTicketController::class, 'addInternalNote'])->name('support-tickets.add-internal-note');
        Route::patch('support-tickets/{id}/internal-note', [SupportTicketController::class, 'updateInternalNote'])->name('support-tickets.update-internal-note');
        Route::post('support-tickets/{id}/rating', [SupportTicketController::class, 'submitRating'])->name('support-tickets.submit-rating');
    });

    // HR management routes for staff
    Route::middleware(['module.access:hr'])->group(function () {
        Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
        Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
        Route::get('employees-list', [EmployeeController::class, 'Employeeslist'])->name('employees-list');
        Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::delete('/admin/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('employee/view', [EmployeeController::class, 'viewUserProfile'])->name('employee.view-profile');
        Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
        Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
        Route::get('employee/rights', [EmployeeController::class, 'viewUserRights'])->name('employee.rights');
        Route::post('employee/rights/store', [EmployeeController::class, 'storeUserRights'])->name('employee.rights.store');
        Route::patch('employee/rights/update/{id}', [EmployeeController::class, 'updateUserRights'])->name('employee.rights.update');
        Route::get('employee/view/{id}', [EmployeeController::class, 'PemployeeProfile'])->name('employee.list-profile');
        Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
        Route::post('view-staff/leaves/store', [EmployeeController::class, 'leavesEmployeeViewStore'])->name('view-staff.leaves.store');
        Route::patch('view-staff/leaves/edit/{id}', [EmployeeController::class, 'leavesEmployeeViewUpdate'])->name('view-staff.leaves.update');
        Route::post('view-staff/read-doc/store', [EmployeeController::class, 'EmployeeReadSignStore'])->name('view-staff.readsign.store');
        Route::patch('view-staff/read-doc/edit/{id}', [EmployeeController::class, 'EmployeeReadSignUpdate'])->name('view-staff.readsign.update');
        Route::post('view-staff/library', [EmployeeController::class, 'storeLibrary'])->name('view-staff.library.store');
        Route::patch('view-staff/library/{id}', [EmployeeController::class, 'libraryupdate'])->name('view-staff.library.update');
        Route::delete('view-staff/library/delete/{id}', [EmployeeController::class, 'libraryDelete'])->name('view-staff.library.destroy');
        Route::post('view-staff/store', [EmployeeController::class, 'leavesStaffStore'])->name('view-staff.store');
        Route::get('holidays', [EmployeeController::class, 'holidays'])->name('holidays');
        Route::post('holidays/store', [EmployeeController::class, 'holidayStore'])->name('holidays.store');
        Route::patch('holidays/edit/{id}', [EmployeeController::class, 'holidayUpdate'])->name('holidays.update');
        Route::get('leaves', [EmployeeController::class, 'leavesAdmin'])->name('leaves');
        Route::get('/get-holidays', [EmployeeController::class, 'getHolidays']);
        Route::post('leaves/store', [EmployeeController::class, 'leavesAdminStore'])->name('leaves.store');
        Route::patch('leaves/edit/{id}', [EmployeeController::class, 'leavesAdminUpdate'])->name('leaves.update');
        Route::get('leave-settings', [EmployeeController::class, 'leaveSettings'])->name('leave-settings');
        Route::get('attendance', [EmployeeController::class, 'attendanceAdmin'])->name('attendance');
    });
    
    // System Admin routes for staff
    Route::middleware(['module.access:system-admin'])->group(function () {
        Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
        Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
        Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
        Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
        Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
        Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');

        // Department Module Management routes
        Route::get('department-modules', [DepartmentModuleController::class, 'index'])->name('department-modules.index');
        Route::post('department-modules/store', [DepartmentModuleController::class, 'store'])->name('department-modules.store');
        Route::post('department-modules/destroy', [DepartmentModuleController::class, 'destroy'])->name('department-modules.destroy');
        Route::post('department-modules/toggle', [DepartmentModuleController::class, 'toggle'])->name('department-modules.toggle');
        Route::get('department-modules/{departmentName}/modules', [DepartmentModuleController::class, 'getModulesByDepartment'])->name('department-modules.get-modules');

        // Accounting routes
        Route::get('categories/view', [CategoryController::class, 'categoriesIndex'])->name('categories.view');
        Route::post('categories/store', [CategoryController::class, 'storeCategory'])->name('categories.store');
        Route::put('categories/update/{id}', [CategoryController::class, 'updateCategory'])->name('categories.update');
        Route::post('/update-category-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');

        //Duties routes
        Route::get('duties', [DutyController::class, 'duties'])->name('duties');
        Route::post('duties/store', [DutyController::class, 'storeDuty'])->name('duties.store');
        Route::put('duties/update/{id}', [DutyController::class, 'updateDuty'])->name('duties.update');
        Route::post('/update-duty-status', [DutyController::class, 'updateStatus'])->name('duties.updateStatus');

        // Event Status routes
        Route::get('events/status', [EventStatusController::class, 'index'])->name('events.status');
        Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');
        Route::patch('events/status/update/{id}', [EventStatusController::class, 'update'])->name('events.status.update');
        Route::delete('events/status/delete/{id}', [EventStatusController::class, 'delete'])->name('events.status.delete');

        // Ticket Status routes
        Route::get('ticket-status', [TicketStatusController::class, 'index'])->name('ticket-status.index');
        Route::get('ticket-status/create', [TicketStatusController::class, 'create'])->name('ticket-status.create');
        Route::post('ticket-status', [TicketStatusController::class, 'store'])->name('ticket-status.store');
        Route::get('ticket-status/{ticketStatus}/edit', [TicketStatusController::class, 'edit'])->name('ticket-status.edit');
        Route::patch('ticket-status/{ticketStatus}', [TicketStatusController::class, 'update'])->name('ticket-status.update');
        Route::delete('ticket-status/{ticketStatus}', [TicketStatusController::class, 'destroy'])->name('ticket-status.destroy');

        Route::get('fare-types', [FareTypeController::class, 'index'])->name('faretypes');
        Route::post('fare-types/store', [FareTypeController::class, 'store'])->name('faretypes.store');
        Route::put('fare-types/update/{id}', [FareTypeController::class, 'update'])->name('faretypes.update');
        Route::delete('fare-types/delete/{id}', [FareTypeController::class, 'delete'])->name('faretypes.delete');
        Route::get('discounts', [DiscountController::class, 'index'])->name('discounts');
        Route::post('discounts/store', [DiscountController::class, 'discountStore'])->name('discounts.store');
        Route::put('discounts/update/{id}', [DiscountController::class, 'discountUpdate'])->name('discounts.update');
        Route::delete('discounts/delete/{id}', [DiscountController::class, 'discountDelete'])->name('discounts.delete');

        //LeaveType rotes
        Route::get('leavetypes', [LeaveTypeController::class, 'leaveType'])->name('leave-type');
        Route::post('leavetypes/store', [LeaveTypeController::class, 'storeLeaveType'])->name('leave-type.store');
        Route::put('leavetypes/update/{id}', [LeaveTypeController::class, 'updateLeaveType'])->name('leave-type.update');
        Route::delete('leavetypes/delete/{id}', [LeaveTypeController::class, 'deleteLeaveType'])->name('leave-type.delete');
        Route::post('/update-leavetype-status', [LeaveTypeController::class, 'updateStatus'])->name('leave-type.updateStatus');

        // Products & Services routes
        Route::get('products', [ProductController::class, 'index'])->name('products');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Deleted Data routes
        Route::get('deleted/agent', [AgentController::class, 'deletedAgent'])->name('deleted.agents');
        Route::get('deleted/airlines', [AirlineController::class, 'deletedAirline'])->name('deleted.airlines');

        Route::get('coming-soon', [DashboardController::class, 'comingSoon'])->name('comingSoon');

        //Project Routes
        Route::get('project-view', function(){
            return view('admin.project-view');
        })->name('project-view');
    });
    
    // Account dashboard for staff
    Route::middleware(['module.access:accounts'])->group(function () {
        Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('booking', [AccountController::class, 'bookingIndex'])->name('booking.index');
        Route::get('booking/create', [AccountController::class, 'createBooking'])->name('booking.create');
        Route::get('booking/edit/{id}', [AccountController::class, 'editBooking'])->name('booking.edit');
        Route::post('booking/store', [AccountController::class, 'storeBooking'])->name('booking.store');
        Route::put('booking/update/{id}', [AccountController::class, 'updateBooking'])->name('booking.update');
        Route::get('booking/invoice/{id}', [AccountController::class, 'generateInvoice'])->name('booking.invoice');
    });
    
    // Additional accounts routes for staff
    Route::middleware(['module.access:accounts'])->group(function () {
        Route::get('customer/accounts/view', [AccountController::class, 'indexCustomerAccount'])->name('customer.accounts.view');
        Route::get('customer/accounts/all', [AccountController::class, 'viewCustomerAccount'])->name('customer.accounts.all');
        Route::get('customer/accounts/invoice/{id}', [AccountController::class, 'viewCustomerInvoice'])->name('customer.account.invoice');
        Route::post('customer/account/store', [AccountController::class, 'storeCustomerAccount'])->name('customer.account.store');
        Route::get('customer/account/edit/{id}', [AccountController::class, 'editCustomerAccount'])->name('customer.account.edit');
        Route::put('customer/account/update/{id}', [AccountController::class, 'updateCustomerAccount'])->name('customer.account.update');
        Route::post('customer/update-account-status', [AccountController::class, 'updateCustomerAccountStatus'])->name('customer.account.updateStatus');
        Route::post('customer/transaction/store', [CustomerController::class, 'transactionStore'])->name('customer.transaction.store');
        Route::get('customer/ledger', [AccountController::class, 'customerLedger'])->name('customer.ledger');
        Route::get('general-ledger', [AccountController::class, 'generalLedger'])->name('general-ledger');
        Route::get('supplier-ledger', [AccountController::class, 'supplierLedger'])->name('supplier-ledger');
        Route::get('expense-entry', [AccountController::class, 'expenseEntry'])->name('expense-entry');
        
        // Payment Pool routes
        Route::get('payment-pool', [PaymentPoolController::class, 'index'])->name('payment-pool');
        Route::post('payment-pool/store', [PaymentPoolController::class, 'store'])->name('payment-pool.store');
        Route::post('payment-pool/allocate/{id}', [PaymentPoolController::class, 'allocate'])->name('payment-pool.allocate');
        Route::post('payment-pool/deallocate/{id}', [PaymentPoolController::class, 'deallocate'])->name('payment-pool.deallocate');
        Route::delete('payment-pool/destroy/{id}', [PaymentPoolController::class, 'destroy'])->name('payment-pool.destroy');
        Route::post('payment-pool/create-expense', [PaymentPoolController::class, 'createExpense'])->name('payment-pool.create-expense');
        Route::post('payment-pool/create-supplier-payment', [PaymentPoolController::class, 'createSupplierPayment'])->name('payment-pool.create-supplier-payment');
        Route::post('payment-pool/split-allocation', [PaymentPoolController::class, 'splitAllocation'])->name('payment-pool.split-allocation');
        
        // Bank Accounts routes
        Route::get('bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');
        Route::get('bank-accounts/create', [BankAccountController::class, 'create'])->name('bank-accounts.create');
        Route::post('bank-accounts/store', [BankAccountController::class, 'store'])->name('bank-accounts.store');
        Route::get('bank-accounts/edit/{id}', [BankAccountController::class, 'edit'])->name('bank-accounts.edit');
        Route::put('bank-accounts/update/{id}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
        Route::delete('bank-accounts/destroy/{id}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');
        Route::get('bank-accounts/toggle-status/{id}', [BankAccountController::class, 'toggleStatus'])->name('bank-accounts.toggle-status');
    });
    
    Route::get('profile', [ProfileController::class, 'employeeProfile'])->name('profile');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/timezone', [ProfileController::class, 'updateTimezone'])->name('profile.timezone');
    
    // Include all other admin routes here
    Route::get('/get-departments', [EmployeeController::class, 'getDepartments']);
    Route::get('/get-employees/{department}', [EmployeeController::class, 'getEmployeesByDepartment']);
    Route::get('/get-employees/{user_id}', [EmployeeController::class, 'getEmployeesByUsers']);

    // App routes
    Route::get('case-history', [AgentController::class, 'caseHistorySearch'])->name('view.case-history');
    Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
    Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
    Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');

    Route::get('customer/case-history', [CustomerController::class, 'caseHistorySearch'])->name('customer.case-history');
    Route::post('customer/casehistory/store', [CustomerController::class, 'caseStore'])->name('customer.case.store');
    Route::patch('customer/casehistory/update/{id}', [CustomerController::class, 'caseUpdate'])->name('customer.cases.update');
    Route::post('customer/casehistory/close/{id}', [CustomerController::class, 'caseClose'])->name('customer.cases.close');

    Route::post('customer/conversation/store', [CustomerController::class, 'conversationStore'])->name('customer.conversation.store');
    Route::post('customer/address/store', [CustomerController::class, 'AddressStore'])->name('customer.address.store');
    Route::post('customer/contact/store', [CustomerController::class, 'ContactStore'])->name('customer.contact.store');
    Route::post('customer/contact/update/{id}', [CustomerController::class, 'contactUpdate'])->name('customer.contact.update');
    Route::delete('customer/contact/delete/{id}', [CustomerController::class, 'contactDelete'])->name('customer.contact.delete');
    Route::post('customer/address/update/{id}', [CustomerController::class, 'addressUpdate'])->name('customer.address.update');

    Route::get('airlines-details', [AirlineDetailController::class, 'index'])->name('airlines-details');
    Route::post('airlines-details/store', [AirlineController::class, 'store'])->name('airlines-details.store');
    Route::patch('/airline-details/{airlineDetail}', [AirlineController::class, 'update'])->name('airlines-details.update');
    Route::delete('/airline-details/delete/{airlineDetail}', [AirlineController::class, 'delete'])->name('airlines-details.delete');
    Route::delete('/admin/airline-details/{airlineDetail}', [AirlineDetailController::class, 'destroy'])->name('airlines-details.destroy');

    Route::get('/delay-code', [DelaycodeController::class, 'delay'])->name('delay.code');
    Route::get('/delay-code-category', [CategoryController::class, 'delaycategory'])->name('delay.code.category');
    Route::get('/origin', [CategoryController::class, 'origin'])->name('origin');
    Route::post('origin/store', [CategoryController::class, 'originstore'])->name('origins.store');
    Route::put('origin/{origin}/update', [CategoryController::class, 'originupdate'])->name('origins.update');
    Route::delete('origin/{origin}', [CategoryController::class, 'origindestroy'])->name('origins.destroy');
    Route::get('/destination', [CategoryController::class, 'destination'])->name('destination');
    Route::post('destination/store', [CategoryController::class, 'destinationstore'])->name('destinations.store');
    Route::put('destination/{destination}/update', [CategoryController::class, 'destinationupdate'])->name('destinations.update');
    Route::delete('destination/{destination}', [CategoryController::class, 'destinationdestroy'])->name('destinations.destroy');
    Route::post('delaycategories/store', [CategoryController::class, 'store'])->name('delay_code_categories.store');
    Route::put('delaycategories/{id}/update', [CategoryController::class, 'update'])->name('delay_code_categories.update');
    Route::delete('delaycategories/{id}/destroy', [CategoryController::class, 'destroy'])->name('delay_code_categories.destroy');
    Route::post('delay-code/store', [DelaycodeController::class, 'store'])->name('delaycodes.store');
    Route::put('delay-code/{id}/update', [DelaycodeController::class, 'update'])->name('delaycodes.update');
    Route::delete('delay-code/{id}/destroy', [DelaycodeController::class, 'destroy'])->name('delaycodes.destroy');

    Route::get('/agent/library', [AgentLibraryController::class, 'index'])->name('agent-library');
    Route::post('agent/library/store', [AgentLibraryController::class, 'store'])->name('agent.library.store');

    Route::get('library', [AirlineLibraryController::class, 'library'])->name('airline-library');
    Route::post('library/store', [AirlineLibraryController::class, 'store'])->name('library.store');
    Route::post('library/airine/store', [AirlineLibraryController::class, 'viewstore'])->name('library.viewstore');
    Route::get('library/{library}/documents', [AirlineLibraryController::class, 'viewDocuments'])->name('library.documents');

    Route::get('license', [LicenseApprovalController::class, 'index'])->name('license');
    Route::post('license/store', [LicenseApprovalController::class, 'store'])->name('license.store');
    Route::patch('license_approvals/{licenseApproval}/status', [LicenseApprovalController::class, 'updateStatus'])->name('license_approvals.updateStatus');
    Route::delete('license_approvals/{licenseApproval}', [LicenseApprovalController::class, 'destroy'])->name('license_approvals.destroy');
    Route::get('flights', [FlightController::class, 'index'])->name('flights');
    Route::get('flights/create', [FlightController::class, 'create'])->name('flights.create');
    Route::post('flights', [FlightController::class, 'store'])->name('flights.store');
    Route::get('flights/{flight}', [FlightController::class, 'show'])->name('flights.show');
    Route::get('flights/{flight}/edit', [FlightController::class, 'edit'])->name('flights.edit');
    Route::put('flights/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::patch('flights/{flight}', [FlightController::class, 'update'])->name('flights.update');
    Route::delete('flights/{flight}', [FlightController::class, 'destroy'])->name('flights.destroy');

    Route::get('wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('wallet/store', [WalletController::class, 'store'])->name('wallet.store');
    Route::put('wallets/edit/{id}', [WalletController::class, 'update'])->name('wallet.update');
    Route::delete('wallets/{id}', [WalletController::class, 'destroy'])->name('wallet.destroy');

    Route::get('walletrequest', [WalletRequestController::class, 'index'])->name('walletrequest');

    Route::get('sectors', [SectorController::class, 'index'])->name('sectors');
    Route::post('store-sector', [SectorController::class, 'store'])->name('sector.store');
    Route::put('update-sector/{id}', [SectorController::class, 'update'])->name('sector.update');
    Route::delete('delete-sector/{id}', [SectorController::class, 'destroy'])->name('sector.delete');

    Route::get('inventories', [InventoryController::class, 'index'])->name('inventories');
    Route::get('inventories/expiry', [InventoryController::class, 'expiryinventory'])->name('expiry.inventories');
    Route::post('inventories/store', [InventoryController::class, 'store'])->name('inventory.store');

    Route::get('admin-holds', [AdminHoldController::class, 'index'])->name('adminholds');
    Route::get('/view-holds/{id}', [HoldController::class, 'view'])->name('view-holds');
    Route::get('/edit-hold/{id}', [HoldController::class, 'edit'])->name('edit-hold');
    Route::post('/edit-hold/{id}', [HoldController::class, 'update'])->name('edit-hold');
    Route::get('holds-confirm/', [HoldController::class, 'confirmHold'])->name('holdsconfirm');

    Route::delete('wallet/delete', [AgentController::class, 'deleteWallet'])->name('wallet.delete');
    Route::post('store-wallet', [AgentController::class, 'storeWallet'])->name('store.wallet');
    Route::post('agentgroups/store', [AgentController::class, 'groupstore'])->name('agentgroups.store');
    Route::put('agentgroups/update/{id}', [AgentController::class, 'groupupdate'])->name('agentgroups.update');
    Route::delete('wallet/requests/{id}', [AgentController::class, 'deleteWalletRequest'])->name('wallet.requests.delete');
    Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
    Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
    Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
    Route::post('airline/target/store', [AirlineController::class, 'targetStore'])->name('airline.target.store');
    Route::post('staff/approvedStaff/store', [EmployeeController::class, 'approvedStaffRightsStore'])->name('staff.approved-staff-rights.store');
    Route::post('airline/approvedStaff/store', [AirlineController::class, 'approvedStaffRightsStore'])->name('airline.approved-staff-rights.store');
    Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
    Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
    Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
    Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
    Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
    Route::get('agent/update/{id}', [AgentController::class, 'update'])->name('agent.update');
    Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
    Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
    Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
    Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');
    Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
    Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
    Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
    Route::post('agent/general/update/{id}', [AgentController::class, 'generalUpdate'])->name('agent.general.update');
    Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
    Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
    Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::get('events', [AppController::class, 'calendar'])->name('events');
    Route::post('events/store', [AppController::class, 'store'])->name('events.store');
    Route::patch('events/update/{id}', [AppController::class, 'update'])->name('events.update');
    Route::get('airlines', [AirlineController::class, 'index'])->name('airlines');
    Route::post('airlines/store', [AirlineController::class, 'store'])->name('airlines.store');
    Route::patch('airlines/edit/{id}', [AirlineController::class, 'update'])->name('airlines.update');
    Route::get('airlines/view/{id}', [AirlineController::class, 'view'])->name('airlines.view');
    Route::get('airlines/get-special-fare/{id}', [AirlineController::class, 'searchSpecialFare'])->name('airlines.special.fare');
    Route::post('airlines/aircraft/', [AirlineController::class, 'aircraftStore'])->name('airline.aircraft.store');
    Route::post('airlines/fleet/', [AirlineController::class, 'fleetStore'])->name('airline.fleet.store');
    Route::patch('airlines/aircraft/update/{id}', [AirlineController::class, 'aircraftUpdate'])->name('airline.aircraft.update');
    Route::delete('airlines/aircraft/delete/{id}', [AirlineController::class, 'aircraftDelete'])->name('airline.aircraft.destroy');
    Route::post('airlines/fleet/update/{id}', [AirlineController::class, 'fleetUpdate'])->name('airline.fleet.update');
    Route::delete('airlines/fleet/delete/{id}', [AirlineController::class, 'fleetDelete'])->name('airline.fleet.destroy');
    Route::post('airlines/approved-staff/', [AirlineController::class, 'approvedStaffStore'])->name('airline.approvedstaff.store');
    Route::post('airlines/approved-staff/upadte/{id}', [AirlineController::class, 'approvedStaffUpdate'])->name('airline.approvedstaff.update');
    Route::get('agent', [AgentController::class, 'index'])->name('agents');
    Route::get('deleted/agent', [AgentController::class, 'deletedAgent'])->name('deleted.agents');

    // B2B Partners routes
    Route::middleware(['module.access:b2b-partners'])->group(function () {
        Route::get('b2b-partners', [B2BPartnerController::class, 'index'])->name('b2b-partners');
        Route::get('b2b-partners/create', [B2BPartnerController::class, 'create'])->name('b2b-partners.create');
        Route::post('b2b-partners', [B2BPartnerController::class, 'store'])->name('b2b-partners.store');
        Route::get('b2b-partners/{id}', [B2BPartnerController::class, 'show'])->name('b2b-partners.show');
        Route::get('b2b-partners/{id}/edit', [B2BPartnerController::class, 'edit'])->name('b2b-partners.edit');
        Route::put('b2b-partners/{id}', [B2BPartnerController::class, 'update'])->name('b2b-partners.update');
        Route::delete('b2b-partners/{id}', [B2BPartnerController::class, 'destroy'])->name('b2b-partners.destroy');
        Route::post('b2b-partners/{partnerId}/contacts', [B2BPartnerController::class, 'storeContact'])->name('b2b-partners.contacts.store');
        Route::put('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'updateContact'])->name('b2b-partners.contacts.update');
        Route::delete('b2b-partners/contacts/{id}', [B2BPartnerController::class, 'deleteContact'])->name('b2b-partners.contacts.destroy');
        Route::post('b2b-partners/{partnerId}/documents', [B2BPartnerController::class, 'storeDocument'])->name('b2b-partners.documents.store');
        Route::delete('b2b-partners/documents/{id}', [B2BPartnerController::class, 'deleteDocument'])->name('b2b-partners.documents.destroy');
        Route::post('b2b-partners/{partnerId}/notes', [B2BPartnerController::class, 'storeNote'])->name('b2b-partners.notes.store');
        Route::delete('b2b-partners/notes/{id}', [B2BPartnerController::class, 'deleteNote'])->name('b2b-partners.notes.destroy');
        Route::delete('b2b-partners/airlines/{id}', [B2BPartnerController::class, 'deleteAirline'])->name('b2b-partners.airlines.destroy');
        Route::delete('b2b-partners/products/{id}', [B2BPartnerController::class, 'deleteProduct'])->name('b2b-partners.products.destroy');
        Route::get('b2b-partners/reports', [B2BPartnerController::class, 'reports'])->name('b2b-partners.reports');
        Route::post('b2b-partners/generate-report', [B2BPartnerController::class, 'generateReport'])->name('b2b-partners.generate-report');
    });

    // Search routes accessible to all authenticated staff (needed for booking form)
    Route::get('b2b-partners/search', [B2BPartnerController::class, 'search'])->name('b2b-partners.search');

    // B2C Customers routes for staff
    Route::middleware(['module.access:b2c-customers'])->group(function () {
        Route::get('b2c-customers', [B2CCustomerController::class, 'index'])->name('b2c-customers.index');
        Route::get('b2c-customers/create', [B2CCustomerController::class, 'create'])->name('b2c-customers.create');
        Route::post('b2c-customers', [B2CCustomerController::class, 'store'])->name('b2c-customers.store');
        Route::get('b2c-customers/{id}', [B2CCustomerController::class, 'show'])->name('b2c-customers.show');
        Route::get('b2c-customers/{id}/edit', [B2CCustomerController::class, 'edit'])->name('b2c-customers.edit');
        Route::put('b2c-customers/{id}', [B2CCustomerController::class, 'update'])->name('b2c-customers.update');
        Route::delete('b2c-customers/{id}', [B2CCustomerController::class, 'destroy'])->name('b2c-customers.destroy');
        Route::patch('b2c-customers/{id}/toggle-status', [B2CCustomerController::class, 'toggleStatus'])->name('b2c-customers.toggle-status');

        // B2C Passenger routes for staff
        Route::get('b2c-customers/{customerId}/passengers/create', [B2CCustomerController::class, 'addPassenger'])->name('b2c-customers.passengers.create');
        Route::post('b2c-customers/{customerId}/passengers', [B2CCustomerController::class, 'storePassenger'])->name('b2c-customers.passengers.store');
        Route::get('b2c-customers/{customerId}/passengers/{passengerId}/edit', [B2CCustomerController::class, 'editPassenger'])->name('b2c-customers.passengers.edit');
        Route::put('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'updatePassenger'])->name('b2c-customers.passengers.update');
        Route::delete('b2c-customers/{customerId}/passengers/{passengerId}', [B2CCustomerController::class, 'deletePassenger'])->name('b2c-customers.passengers.delete');

        // B2C Notes routes for staff
        Route::post('b2c-customers/{customerId}/notes', [B2CCustomerController::class, 'storeNote'])->name('b2c-customers.notes.store');
        Route::delete('b2c-customers/{customerId}/notes/{noteId}', [B2CCustomerController::class, 'deleteNote'])->name('b2c-customers.notes.delete');

        // B2C Documents routes for staff
        Route::post('b2c-customers/{customerId}/documents', [B2CCustomerController::class, 'storeDocument'])->name('b2c-customers.documents.store');
        Route::delete('b2c-customers/{customerId}/documents/{documentId}', [B2CCustomerController::class, 'deleteDocument'])->name('b2c-customers.documents.delete');
    });

    // Search routes accessible to all authenticated staff (needed for booking form)
    Route::get('b2c-customers/search', [B2CCustomerController::class, 'search'])->name('b2c-customers.search');

    Route::patch('airlines/specialfares/update/{id}', [AirlineController::class, 'specialfaresUpdate'])->name('airline.specialfares.update');
    Route::get('deleted/airlines', [AirlineController::class, 'deletedAirline'])->name('deleted.airlines');
    Route::post('airlines/SLA/store', [AirlineController::class, 'slaStore'])->name('airline.sla.store');
    Route::patch('airlines/SLA/{id}/update', [AirlineController::class, 'slaUpdate'])->name('airline.sla.update');
    Route::patch('airline/sla/toggle-status/{id}', [AirlineController::class, 'slaUpdateStatus']);
    Route::delete('airlines/SLA/{id}/destroy', [AirlineController::class, 'slaDestroy'])->name('airline.sla.destroy');
    Route::post('airlines/approved-staff/update-status', [AirlineController::class, 'approvedStaffUpdateStatus'])->name('airline.approvedstaff.updatestatus');
    Route::post('airlines/head_office/store', [AirlineController::class, 'headOfficeStore'])->name('airline.head_office.store');
    Route::patch('airlines/head_office/{id}/update', [AirlineController::class, 'headOfficeUpdate'])->name('airline.head_office.update');
    Route::delete('airlines/head_office/{id}/destroy', [AirlineController::class, 'headOfficeDestroy'])->name('airline.head_office.destroy');
    Route::get('sales-lead', [SalesLeadController::class, 'index'])->name('saleslead');
    Route::post('sales-lead/store', [SalesLeadController::class, 'store'])->name('saleslead.store');
    Route::post('sales-lead/staff/store', [SalesLeadController::class, 'assignStaff'])->name('saleslead.staff.store');
    Route::patch('sales-lead/edit/{id}', [SalesLeadController::class, 'update'])->name('saleslead.update');
    Route::get('air-tickets', [AirTicketController::class, 'index'])->name('air-tickets');
    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');
    Route::patch('groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
    Route::get('employees-list', [EmployeeController::class, 'Employeeslist'])->name('employees-list');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::delete('/admin/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('employee/view', [EmployeeController::class, 'viewUserProfile'])->name('employee.view-profile');
    Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
    Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    Route::get('employee/rights', [EmployeeController::class, 'viewUserRights'])->name('employee.rights');
    Route::post('employee/rights/store', [EmployeeController::class, 'storeUserRights'])->name('employee.rights.store');
    Route::patch('employee/rights/update/{id}', [EmployeeController::class, 'updateUserRights'])->name('employee.rights.update');
    Route::get('employee/view/{id}', [EmployeeController::class, 'PemployeeProfile'])->name('employee.list-profile');
    Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
    Route::post('view-staff/leaves/store', [EmployeeController::class, 'leavesEmployeeViewStore'])->name('view-staff.leaves.store');
    Route::patch('view-staff/leaves/edit/{id}', [EmployeeController::class, 'leavesEmployeeViewUpdate'])->name('view-staff.leaves.update');
    Route::post('view-staff/read-doc/store', [EmployeeController::class, 'EmployeeReadSignStore'])->name('view-staff.readsign.store');
    Route::patch('view-staff/read-doc/edit/{id}', [EmployeeController::class, 'EmployeeReadSignUpdate'])->name('view-staff.readsign.update');
    Route::post('view-staff/library', [EmployeeController::class, 'storeLibrary'])->name('view-staff.library.store');
    Route::patch('view-staff/library/{id}', [EmployeeController::class, 'libraryupdate'])->name('view-staff.library.update');
    Route::delete('view-staff/library/delete/{id}', [EmployeeController::class, 'libraryDelete'])->name('view-staff.library.destroy');
    Route::post('view-staff/store', [EmployeeController::class, 'leavesStaffStore'])->name('view-staff.store');
    Route::get('holidays', [EmployeeController::class, 'holidays'])->name('holidays');
    Route::post('holidays/store', [EmployeeController::class, 'holidayStore'])->name('holidays.store');
    Route::patch('holidays/edit/{id}', [EmployeeController::class, 'holidayUpdate'])->name('holidays.update');
    Route::get('leaves', [EmployeeController::class, 'leavesAdmin'])->name('leaves');
    Route::get('/get-holidays', [EmployeeController::class, 'getHolidays']);
    Route::post('leaves/store', [EmployeeController::class, 'leavesAdminStore'])->name('leaves.store');
    Route::patch('leaves/edit/{id}', [EmployeeController::class, 'leavesAdminUpdate'])->name('leaves.update');
    Route::get('leave-settings', [EmployeeController::class, 'leaveSettings'])->name('leave-settings');
    Route::get('support-ticket-settings', [SettingController::class, 'supportTicketSettings'])->name('support-ticket-settings');
    Route::post('support-ticket-settings', [SettingController::class, 'updateSupportTicketSettings'])->name('support-ticket-settings.update');
    Route::get('attendance', [EmployeeController::class, 'attendanceAdmin'])->name('attendance');
    Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
    Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
    Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
    Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
    Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');

    // Department Module Management routes
    Route::get('department-modules', [DepartmentModuleController::class, 'index'])->name('department-modules.index');
    Route::post('department-modules/store', [DepartmentModuleController::class, 'store'])->name('department-modules.store');
    Route::post('department-modules/destroy', [DepartmentModuleController::class, 'destroy'])->name('department-modules.destroy');
    Route::post('department-modules/toggle', [DepartmentModuleController::class, 'toggle'])->name('department-modules.toggle');
    Route::get('department-modules/{departmentName}/modules', [DepartmentModuleController::class, 'getModulesByDepartment'])->name('department-modules.get-modules');
    
    // Ticket Status routes
    Route::get('ticket-status', [TicketStatusController::class, 'index'])->name('ticket-status.index');
    Route::get('ticket-status/create', [TicketStatusController::class, 'create'])->name('ticket-status.create');
    Route::post('ticket-status', [TicketStatusController::class, 'store'])->name('ticket-status.store');
    Route::get('ticket-status/{ticketStatus}/edit', [TicketStatusController::class, 'edit'])->name('ticket-status.edit');
    Route::patch('ticket-status/{ticketStatus}', [TicketStatusController::class, 'update'])->name('ticket-status.update');
    Route::delete('ticket-status/{ticketStatus}', [TicketStatusController::class, 'destroy'])->name('ticket-status.destroy');
    Route::get('timesheet', [EmployeeController::class, 'timesheet'])->name('timesheet');
    Route::get('shift-scheduling', [EmployeeController::class, 'shiftScheduling'])->name('shift-scheduling');
    Route::get('overtime', [EmployeeController::class, 'overtime'])->name('overtime');
    Route::post('reportsick/store', [EmployeeController::class, 'storeReportSick'])->name('reportsick.store');
    Route::post('newabsence/store', [EmployeeController::class, 'storeNewAbsence'])->name('newabsence.store');
    Route::get('tasks', [TaskController::class, 'tasks'])->name('tasks');
    Route::get('task-board', [TaskController::class, 'taskBoard'])->name('task-board');
    
    // Employee management routes for staff
    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('add-staff', [EmployeeController::class, 'addStaff'])->name('add-staff');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('view-staff/{id}', [EmployeeController::class, 'viewEmployee'])->name('view-staff');
    Route::post('employee/view/store', [EmployeeController::class, 'storeUserProfile'])->name('employee.store-profile');
    Route::patch('employee/view/update/{id}', [EmployeeController::class, 'updateUserProfile'])->name('employee.update-profile');
    
    // Agent management routes for staff
    Route::get('agent', [AgentController::class, 'index'])->name('agents');
    Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::post('agent/store', [AgentController::class, 'store'])->name('agent.store');
    Route::post('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
    Route::post('agent/update/{id}', [AgentController::class, 'update'])->name('agent.general.update');
    Route::delete('agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');
    Route::post('agent/address/store', [AgentController::class, 'AddressStore'])->name('agent.address.store');
    Route::post('agent/address/update/{id}', [AgentController::class, 'addressUpdate'])->name('agent.address.update');
    Route::post('agent/contact/store', [AgentController::class, 'ContactStore'])->name('agent.contact.store');
    Route::post('agent/contact/update/{id}', [AgentController::class, 'contactUpdate'])->name('agent.contact.update');
    Route::post('agent/target/store', [AgentController::class, 'targetStore'])->name('agent.target.store');
    Route::post('agent/target/update/{id}', [AgentController::class, 'targetUpdate'])->name('agent.target.update');
    Route::post('agent/product/store', [AgentController::class, 'productStore'])->name('agent.product.store');
    Route::post('agent/product/update/{id}', [AgentController::class, 'productUpdate'])->name('agent.product.update');
    Route::delete('agent/product/delete/{id}', [AgentController::class, 'productDelete'])->name('agent.product.delete');
    Route::post('agent/conversation/store', [AgentController::class, 'conversationStore'])->name('agent.conversation.store');
    Route::post('agent/casehistory/store', [AgentController::class, 'caseStore'])->name('agent.case.store');
    Route::patch('agent/casehistory/update/{id}', [AgentController::class, 'caseUpdate'])->name('agent.cases.update');
    Route::post('agent/casehistory/close/{id}', [AgentController::class, 'caseClose'])->name('agent.cases.close');
    Route::post('agent/transaction/store', [AgentController::class, 'transactionStore'])->name('transaction.store');
    Route::post('agent/prov/store', [AgentController::class, 'provStore'])->name('prov.store');
    Route::post('agent/prov/update/{id}', [AgentController::class, 'provUpdate'])->name('agent.prov.update');
    Route::post('agent/pli/store', [AgentController::class, 'pliStore'])->name('pli.store');
    Route::post('agent/pli/update/{id}', [AgentController::class, 'pliUpdate'])->name('agent.pli.update');
    
    // Airline management routes for staff
    Route::get('airlines-details', [AirlineDetailController::class, 'index'])->name('airlines-details');
    Route::post('airlines-details/store', [AirlineController::class, 'store'])->name('airlines-details.store');
    Route::patch('/airline-details/{airlineDetail}', [AirlineController::class, 'update'])->name('airlines-details.update');
    Route::delete('/airline-details/delete/{airlineDetail}', [AirlineController::class, 'delete'])->name('airlines-details.delete');
    Route::delete('/admin/airline-details/{airlineDetail}', [AirlineDetailController::class, 'destroy'])->name('airlines-details.destroy');
    Route::post('airline/target/store', [AirlineController::class, 'targetStore'])->name('airline.target.store');
    Route::post('airline/approvedStaff/store', [AirlineController::class, 'approvedStaffRightsStore'])->name('airline.approved-staff-rights.store');
    Route::post('airlines/aircraft/', [AirlineController::class, 'aircraftStore'])->name('airline.aircraft.store');
    Route::post('airlines/fleet/', [AirlineController::class, 'fleetStore'])->name('airline.fleet.store');
    Route::patch('airlines/aircraft/update/{id}', [AirlineController::class, 'aircraftUpdate'])->name('airline.aircraft.update');
    Route::delete('airlines/aircraft/delete/{id}', [AirlineController::class, 'aircraftDelete'])->name('airline.aircraft.destroy');
    Route::post('airlines/fleet/update/{id}', [AirlineController::class, 'fleetUpdate'])->name('airline.fleet.update');
    Route::delete('airlines/fleet/delete/{id}', [AirlineController::class, 'fleetDelete'])->name('airline.fleet.destroy');
    Route::post('airlines/approved-staff/', [AirlineController::class, 'approvedStaffStore'])->name('airline.approvedstaff.store');
    Route::post('airlines/approved-staff/upadte/{id}', [AirlineController::class, 'approvedStaffUpdate'])->name('airline.approvedstaff.update');
    Route::patch('airlines/specialfares/update/{id}', [AirlineController::class, 'specialfaresUpdate'])->name('airline.specialfares.update');
    Route::post('airlines/SLA/store', [AirlineController::class, 'slaStore'])->name('airline.sla.store');
    Route::patch('airlines/SLA/{id}/update', [AirlineController::class, 'slaUpdate'])->name('airline.sla.update');
    Route::delete('airlines/SLA/{id}/destroy', [AirlineController::class, 'slaDestroy'])->name('airline.sla.destroy');
    Route::post('airlines/head_office/store', [AirlineController::class, 'headOfficeStore'])->name('airline.head_office.store');
    Route::patch('airlines/head_office/{id}/update', [AirlineController::class, 'headOfficeUpdate'])->name('airline.head_office.update');
    Route::delete('airlines/head_office/{id}/destroy', [AirlineController::class, 'headOfficeDestroy'])->name('airline.head_office.destroy');
    Route::patch('airline/sla/{id}/statusupdate', [AirlineController::class, 'slaUpdateStatus'])->name('airline.sla.statusupdate');
    Route::patch('airline/headOffice/toggle-status/{id}', [AirlineController::class, 'headOfficeUpdateStatus'])->name('airline.headOffice.statusupdate');
    Route::patch('airline/fleet/toggle-status/{id}', [AirlineController::class, 'fleetUpdateStatus'])->name('airline.fleet.statusupdate');
    Route::patch('airline/schedule/statusupdate/{id}', [AirlineController::class, 'scheduleUpdateStatus'])->name('airline.schedule.statusupdate');
    Route::patch('airline/library/statusupdate/{id}', [AirlineController::class, 'librarystatusUpdate'])->name('airline.library.statusupdate');
    Route::patch('airline/rules/statusupdate/{id}', [AirlineController::class, 'rulesupdateStatus'])->name('airline.rules.statusupdate');
    Route::patch('airline/specialfares/statusupdate/{id}', [AirlineController::class, 'specialfaresupdateStatus'])->name('airline.specialfares.statusupdate');
    Route::patch('admin/agreements/statusupdate/{id}', [AirlineController::class, 'agreemenstStatusUpdate'])->name('airline.agreements.statusupdate');
    Route::post('airlines/agreements/store', [AirlineController::class, 'agreementsStore'])->name('airline.agreements.store');
    Route::patch('airlines/agreements/{id}/update', [AirlineController::class, 'agreementsUpdate'])->name('airline.agreements.update');
    Route::patch('airlines/agreements/{id}/destroy', [AirlineController::class, 'agreementsDestroy'])->name('airline.agreements.destroy');
    Route::post('airlines/pli/store', [AirlineController::class, 'pliStore'])->name('airline.pli.store');
    Route::patch('airlines/library/{id}', [AirlineController::class, 'libraryupdate'])->name('airline.library.update');
    Route::delete('airlines/library/delete/{id}', [AirlineController::class, 'libraryDelete'])->name('airline.library.destroy');
    Route::post('library/store', [AirlineLibraryController::class, 'store'])->name('library.store');
    Route::post('library/airine/store', [AirlineLibraryController::class, 'viewstore'])->name('library.viewstore');
    Route::post('airlines/rules/store', [AirlineController::class, 'rulesStore'])->name('airline.rules.store');
    Route::patch('airlines/rules/update/{id}', [AirlineController::class, 'rulesUpdate'])->name('airline.rules.update');
    
    // Account dashboard for staff
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('booking', [AccountController::class, 'bookingIndex'])->name('booking.index');
    Route::get('booking/create', [AccountController::class, 'createBooking'])->name('booking.create');
    Route::get('booking/edit/{id}', [AccountController::class, 'editBooking'])->name('booking.edit');
    Route::post('booking/store', [AccountController::class, 'storeBooking'])->name('booking.store');
    Route::put('booking/update/{id}', [AccountController::class, 'updateBooking'])->name('booking.update');
    Route::post('booking/save-customer', [AccountController::class, 'saveCustomer'])->name('booking.save-customer');
    Route::get('booking/drop-tables', [AccountController::class, 'dropBookingTables'])->name('booking.drop-tables');
    Route::get('booking/invoice/{id}', [AccountController::class, 'generateInvoice'])->name('booking.invoice');
    Route::patch('support-tickets/{id}/company-name', [SupportTicketController::class, 'updateCompanyName'])->name('support-tickets.update-company-name');
    Route::delete('support-tickets/{id}', [SupportTicketController::class, 'destroy'])->name('support-tickets.destroy');

    // Get staff by department for SuperAdmin
    Route::get('get-staff-by-department', [SupportTicketController::class, 'getStaffByDepartment'])->name('get-staff-by-department');
    
    Route::get('leads', [LeadController::class, 'index'])->name('leads');
    Route::get('events/status', [EventStatusController:: class, 'index'])->name('events.status');
    Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');
    Route::patch('events/status/update/{id}', [EventStatusController::class, 'update'])->name('events.status.update');
    Route::delete('events/status/delete/{id}', [EventStatusController::class, 'delete'])->name('events.status.delete');
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('estimates', [SalesController::class, 'estimates'])->name('estimates');
    Route::get('invoices', [SalesController::class, 'invoices'])->name('invoices');
    Route::get('payments', [SalesController::class, 'payments'])->name('payments');
    Route::get('expenses', [SalesController::class, 'expenses'])->name('expenses');
    Route::get('provident-fund', [SalesController::class, 'providentFund'])->name('provident-fund');
    Route::get('taxes', [SalesController::class, 'taxes'])->name('taxes');
    Route::get('categories', [AccountingController::class, 'categories'])->name('categories');
    Route::get('budgets', [AccountingController::class, 'budgets'])->name('budgets');
    Route::get('budget-expenses', [AccountingController::class, 'budgetExpenses'])->name('budget-expenses');
    Route::get('budget-revenues', [AccountingController::class, 'budgetRevenues'])->name('budget-revenues');

    Route::get('customer/accounts/view', [AccountController::class, 'indexCustomerAccount'])->name('customer.accounts.view');
    Route::get('customer/accounts/all', [AccountController::class, 'viewCustomerAccount'])->name('customer.accounts.all');
    Route::get('customer/accounts/invoice/{id}', [AccountController::class, 'viewCustomerInvoice'])->name('customer.account.invoice');
    Route::post('customer/account/store', [AccountController::class, 'storeCustomerAccount'])->name('customer.account.store');
    Route::get('customer/account/edit/{id}', [AccountController::class, 'editCustomerAccount'])->name('customer.account.edit');
    Route::put('customer/account/update/{id}', [AccountController::class, 'updateCustomerAccount'])->name('customer.account.update');
    Route::post('customer/update-account-status', [AccountController::class, 'updateCustomerAccountStatus'])->name('customer.account.updateStatus');
    Route::post('customer/transaction/store', [CustomerController::class, 'transactionStore'])->name('customer.transaction.store');
    Route::get('customer/ledger', [AccountController::class, 'customerLedger'])->name('customer.ledger');
    Route::get('general-ledger', [AccountController::class, 'generalLedger'])->name('general-ledger');
    Route::get('supplier-ledger', [AccountController::class, 'supplierLedger'])->name('supplier-ledger');
    Route::get('expense-entry', [AccountController::class, 'expenseEntry'])->name('expense-entry');
    
    // Payment Pool routes
    Route::get('payment-pool', [PaymentPoolController::class, 'index'])->name('payment-pool');
    Route::post('payment-pool/store', [PaymentPoolController::class, 'store'])->name('payment-pool.store');
    Route::post('payment-pool/allocate/{id}', [PaymentPoolController::class, 'allocate'])->name('payment-pool.allocate');
    Route::post('payment-pool/deallocate/{id}', [PaymentPoolController::class, 'deallocate'])->name('payment-pool.deallocate');
    Route::delete('payment-pool/destroy/{id}', [PaymentPoolController::class, 'destroy'])->name('payment-pool.destroy');
    Route::post('payment-pool/create-expense', [PaymentPoolController::class, 'createExpense'])->name('payment-pool.create-expense');
    Route::post('payment-pool/create-supplier-payment', [PaymentPoolController::class, 'createSupplierPayment'])->name('payment-pool.create-supplier-payment');
    Route::post('payment-pool/split-allocation', [PaymentPoolController::class, 'splitAllocation'])->name('payment-pool.split-allocation');
    
    Route::get('accounts/view', [AccountController::class, 'account'])->name('accounts.view');
    Route::get('accounts/all', [AccountController::class, 'viewAccount'])->name('accounts.all');
    Route::get('accounts/invoice/{id}', [AccountController::class, 'viewInvoice'])->name('account.invoice');
    Route::post('account/store', [AccountController::class, 'storeAccount'])->name('account.store');
    Route::get('account/edit/{id}', [AccountController::class, 'editAccount'])->name('account.edit');
    Route::put('account/update/{id}', [AccountController::class, 'updateAccount'])->name('account.update');
    Route::post('/update-account-status', [AccountController::class, 'updateStatus'])->name('account.updateStatus');
    Route::get('reservations/new-sale', [ReservationController::class, 'newSale'])->name('reservation.newsale');
    Route::post('reservations/store', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('sales-packages', [SalesPackageController::class, 'index'])->name('sales-packages.index');
    Route::get('sales-packages/create', [SalesPackageController::class, 'create'])->name('sales-packages.create');
    Route::post('sales-packages/store', [SalesPackageController::class, 'store'])->name('sales-packages.store');
    Route::get('sales-packages/edit/{id}', [SalesPackageController::class, 'edit'])->name('sales-packages.edit');
    Route::put('sales-packages/update/{id}', [SalesPackageController::class, 'update'])->name('sales-packages.update');
    Route::delete('sales-packages/destroy/{id}', [SalesPackageController::class, 'destroy'])->name('sales-packages.destroy');
    Route::get('sales-packages/toggle-status/{id}', [SalesPackageController::class, 'toggleStatus'])->name('sales-packages.toggle-status');
    Route::get('sales-packages/{id}', [SalesPackageController::class, 'getPackage'])->name('sales-packages.get');
    Route::get('sales-packages/{packageId}/permissions', [SalesPackageController::class, 'getPackagePermissions'])->name('sales-packages.get.permissions');
    Route::post('sales-packages/save-permissions', [SalesPackageController::class, 'savePackagePermissions'])->name('sales-packages.save.permissions');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('customer-subscriptions', [SubscriptionController::class, 'customerSubscriptions'])->name('customer.subscriptions');
    Route::post('customer-subscriptions/store', [SubscriptionController::class, 'storeCustomerSubscription'])->name('customer.subscriptions.store');
    Route::get('customer-subscriptions/get-permissions', [SubscriptionController::class, 'getSubscriptionPermissions'])->name('customer.subscriptions.get.permissions');
    Route::post('customer-subscriptions/save-permissions', [SubscriptionController::class, 'saveSubscriptionPermissions'])->name('customer.subscriptions.save.permissions');
    Route::get('customer-module-permissions/{id}', [SubscriptionController::class, 'getCustomerModulePermissions'])->name('module.permissions');
    Route::post('customer-update-module-access', [SubscriptionController::class, 'updateCustomerModuleAccess'])->name('update.module.access');

    // Bank Accounts routes
    Route::get('bank-accounts', [BankAccountController::class, 'index'])->name('bank-accounts.index');
    Route::get('bank-accounts/create', [BankAccountController::class, 'create'])->name('bank-accounts.create');
    Route::post('bank-accounts/store', [BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::get('bank-accounts/edit/{id}', [BankAccountController::class, 'edit'])->name('bank-accounts.edit');
    Route::put('bank-accounts/update/{id}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
    Route::delete('bank-accounts/destroy/{id}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');
    Route::get('bank-accounts/toggle-status/{id}', [BankAccountController::class, 'toggleStatus'])->name('bank-accounts.toggle-status');
    
    Route::get('staff-reports', [StaffReportController::class, 'index'])->name('staff-reports');
    Route::get('airline-reports', [AirlineController::class, 'report'])->name('airline-reports');
    Route::get('agent-reports', [AgentReportController::class, 'airlineReport'])->name('agent-reports');
    Route::get('customer-reports', [CustomerReportController::class, 'customerReport'])->name('customer-reports');
    Route::get('salary', [PayrollController::class, 'employeeSalary'])->name('salary');
    Route::get('manage-staff', [EmployeeController::class, 'manageStaff'])->name('manage-staff');
    Route::get('/admin/manage-salary/{id}', [PayrollController::class, 'employeeSalaryId'])->name('manage-salary');
    Route::post('/admin/manage-salary/store', [PayrollController::class, 'employeeSalaryIdStore'])->name('manage-salary.store');
    Route::post('salary/store', [PayrollController::class, 'employeeSalaryStore'])->name('salary.store');
    Route::get('salary-view/{id}', [PayrollController::class, 'payslip'])->name('salary-view');
    Route::get('payroll-items', [PayrollController::class, 'payrollItems'])->name('payroll-items');
    Route::get('policies', [PolicyController::class, 'index'])->name('policies');
    Route::post('policies/store', [PolicyController::class, 'store'])->name('policies.store');
    Route::patch('policies/update', [PolicyController::class, 'update'])->name('policies.update');
    Route::patch('airline/sla/{id}/statusupdate', [AirlineController::class, 'slaUpdateStatus'])->name('airline.sla.statusupdate');
    Route::patch('airline/headOffice/toggle-status/{id}', [AirlineController::class, 'headOfficeUpdateStatus'])->name('airline.headOffice.statusupdate');
    Route::patch('airline/fleet/toggle-status/{id}', [AirlineController::class, 'fleetUpdateStatus'])->name('airline.fleet.statusupdate');
    Route::patch('airline/schedule/statusupdate/{id}', [AirlineController::class, 'scheduleUpdateStatus'])->name('airline.schedule.statusupdate');
    Route::patch('airline/library/statusupdate/{id}', [AirlineController::class, 'librarystatusUpdate'])->name('airline.library.statusupdate');
    Route::patch('airline/rules/statusupdate/{id}', [AirlineController::class, 'rulesupdateStatus'])->name('airline.rules.statusupdate');
    Route::patch('airline/specialfares/statusupdate/{id}', [AirlineController::class, 'specialfaresupdateStatus'])->name('airline.specialfares.statusupdate');
    Route::patch('admin/agreements/statusupdate/{id}', [AirlineController::class, 'agreemenstStatusUpdate'])->name('airline.agreements.statusupdate');
    Route::post('airlines/agreements/store', [AirlineController::class, 'agreementsStore'])->name('airline.agreements.store');
    Route::patch('airlines/agreements/{id}/update', [AirlineController::class, 'agreementsUpdate'])->name('airline.agreements.update');
    Route::patch('airlines/agreements/{id}/destroy', [AirlineController::class, 'agreementsDestroy'])->name('airline.agreements.destroy');
    Route::post('airlines/pli/store', [AirlineController::class, 'pliStore'])->name('airline.pli.store');
    Route::patch('airlines/library/{id}', [AirlineController::class, 'libraryupdate'])->name('airline.library.update');
    Route::delete('airlines/library/delete/{id}', [AirlineController::class, 'libraryDelete'])->name('airline.library.destroy');
    Route::post('airlines/rules/store', [AirlineController::class, 'rulesStore'])->name('airline.rules.store');
    Route::patch('airlines/rules/update/{id}', [AirlineController::class, 'rulesUpdate'])->name('airline.rules.update');
    Route::get('expense-reports', [ReportController::class, 'expenseReport'])->name('expense-reports');
    Route::get('invoice-reports', [ReportController::class, 'invoiceReport'])->name('invoice-reports');
    Route::get('payments-reports', [ReportController::class, 'paymentsReport'])->name('payments-reports');
    Route::get('project-reports', [ReportController::class, 'projectReport'])->name('project-reports');
    Route::get('task-reports', [ReportController::class, 'taskReport'])->name('task-reports');
    Route::get('user-reports', [ReportController::class, 'userReport'])->name('user-reports');
    Route::get('employee-reports', [ReportController::class, 'employeeReport'])->name('employee-reports');
    Route::get('payslip-reports', [ReportController::class, 'payslipReport'])->name('payslip-reports');
    Route::get('attendance-reports', [ReportController::class, 'attendanceReport'])->name('attendance-reports');
    Route::get('leave-reports', [ReportController::class, 'leaveReport'])->name('leave-reports');
    Route::get('daily-reports', [ReportController::class, 'dailyReport'])->name('daily-reports');
    Route::get('performance-indicator', [PerformanceController::class, 'performanceIndicator'])->name('performance-indicator');
    Route::get('performance-review', [PerformanceController::class, 'performanceReview'])->name('performance-review');
    Route::get('performance-appraisal', [PerformanceController::class, 'performanceAppraisal'])->name('performance-appraisal');
    Route::get('goal-tracking', [GoalController::class, 'goalList'])->name('goal-tracking');
    Route::get('goal-type', [GoalController::class, 'goalType'])->name('goal-type');
    Route::get('training', [TrainingController::class, 'trainingList'])->name('training');
    Route::get('trainers', [TrainingController::class, 'trainers'])->name('trainers');
    Route::get('training-type', [TrainingController::class, 'trainingType'])->name('training-type');
    Route::get('promotion', [HRController::class, 'promotion'])->name('promotion');
    Route::get('resignation', [HRController::class, 'resignation'])->name('resignation');
    Route::get('termination', [HRController::class, 'termination'])->name('termination');
    Route::post('termination/store', [HRController::class, 'terminationStore'])->name('termination.store');
    Route::post('termination/update', [HRController::class, 'terminationUpdate'])->name('termination.update');
    Route::post('resignation/store', [HRController::class, 'resignationStore'])->name('resignation.store');
    Route::patch('resignation/update', [HRController::class, 'resignationUpdate'])->name('resignation.update');
    Route::get('assets', [AdministrationController::class, 'assets'])->name('assets');
    Route::get('user-dashboard', [JobController::class, 'userDashboard'])->name('user-dashboard');
    Route::get('jobs-dashboard', [JobController::class, 'jobsDashboard'])->name('jobs-dashboard');
    Route::get('jobs', [JobController::class, 'manageJobs'])->name('jobs');
    Route::get('manage-resumes', [JobController::class, 'manageResumes'])->name('manage-resumes');
    Route::get('shortlist-candidates', [JobController::class, 'shortlistCandidates'])->name('shortlist-candidates');
    Route::get('interview-questions', [JobController::class, 'interviewQuestions'])->name('interview-questions');
    Route::get('offer-approvals', [JobController::class, 'offerApprovals'])->name('offer-approvals');
    Route::get('experience-level', [JobController::class, 'experienceLevel'])->name('experience-level');
    Route::get('candidates', [JobController::class, 'candidatesList'])->name('candidates');
    Route::get('schedule-timing', [JobController::class, 'scheduleTiming'])->name('schedule-timing');
    Route::get('apptitude-result', [JobController::class, 'aptitudeResults'])->name('apptitude-result');
    Route::get('knowledgebase', [KnowledgebaseController::class, 'index'])->name('knowledgebase');
    Route::get('activities', [ActivityController::class, 'index'])->name('activities');
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::get('profile', [ProfileController::class, 'employeeProfile'])->name('profile');
    Route::get('client-profile', [ProfileController::class, 'clientProfile'])->name('client-profile');
    Route::get('admin-profile', [ProfileController::class, 'adminProfile'])->name('admin-profile');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/timezone', [ProfileController::class, 'updateTimezone'])->name('profile.timezone');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/update', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::get('roles-permissions', [ModuleController::class, 'index'])->name('roles-permissions.index');
    Route::post('modules/update', [ModuleController::class, 'update'])->name('modules.update');
    Route::post('modules/toggle-status', [ModuleController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::get('fare_conditions', [FareConditionController::class, 'index'])->name('fare_conditions.index');
    Route::get('fare_conditions/create', [FareConditionController::class, 'create'])->name('fare_conditions.create');
    Route::post('fare_conditions', [FareConditionController::class, 'store'])->name('fare_conditions.store');
    Route::get('fare_conditions/{fare_condition}', [FareConditionController::class, 'show'])->name('fare_conditions.show');
    Route::get('fare_conditions/{fare_condition}/edit', [FareConditionController::class, 'edit'])->name('fare_conditions.edit');
    Route::put('fare_conditions/{fare_condition}', [FareConditionController::class, 'update'])->name('fare_conditions.update');
    Route::delete('fare_conditions/{fare_condition}', [FareConditionController::class, 'destroy'])->name('fare_conditions.destroy');
    Route::put('/airtickets/{id}/update-status', 'AirTicketController@updateStatus')->name('airtickets.update_status');
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');

    Route::get('roles-permissions', [ModuleController::class, 'index'])->name('roles-permissions.index');
    Route::post('modules/update', [ModuleController::class, 'update'])->name('modules.update');
    Route::post('modules/toggle-status', [ModuleController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'getRolePermissions'])->name('roles.getPermissions');
    Route::put('/roles/update', [RolePermissionController::class, 'update'])->name('roles.update');
    Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store');
    Route::post('/update-permission-status', [RolePermissionController::class, 'updatePermissionStatus'])->name('update.permission.status');
    Route::post('/update-staff-permission', [RolePermissionController::class, 'updateStaffPermission'])->name('update.staff.permission');

    Route::get('admin-view', [AdminController::class, 'showAllAdmin'])->name('admin.view');
    Route::get('admin-add-customer', [AdminController::class, 'addCustomer'])->name('admin.add-customer');
    Route::post('admin-view/store', [AdminController::class, 'registerAdmin'])->name('admin.store');
    Route::patch('admin-view/update/{id}', [AdminController::class, 'editAdmin'])->name('customer.update');

    Route::get('admin-view/kyc/document', [AdminController::class, 'kycDocumentIndex'])->name('kyc.documents');
    Route::patch('admin-view/kyc/document/{id}', [AdminController::class, 'kycDocument'])->name('kyc.document.store');
    Route::get('customer/view/{id}', [CustomerController::class, 'customerProfile'])->name('customer.view');
    Route::post('/update-customer-role', [CustomerController::class, 'updateRole'])->name('update.customer.role');
    Route::patch('customer/update-package/{id}', [CustomerController::class, 'updatePackage'])->name('customer.update-package');

    Route::post('admin/update-customer-permission', [CustomerController::class, 'updatePermission'])->name('update.customer.permission');

    Route::get('/toggle-status/{id}', [AdminController::class, 'toggleStatus'])->name('toggle.status');

    // System Admin routes for customers
    Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
    Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
    Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
    Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
    Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');
    Route::get('department-modules', [DepartmentModuleController::class, 'index'])->name('department-modules.index');
    Route::post('department-modules/store', [DepartmentModuleController::class, 'store'])->name('department-modules.store');
    Route::post('department-modules/destroy', [DepartmentModuleController::class, 'destroy'])->name('department-modules.destroy');
    Route::post('department-modules/toggle', [DepartmentModuleController::class, 'toggle'])->name('department-modules.toggle');
    Route::get('categories/view', [CategoryController::class, 'category'])->name('categories.view');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
    Route::post('/update-category-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');
    Route::get('duties', [DutyController::class, 'duties'])->name('duties');
    Route::post('duties/store', [DutyController::class, 'storeDuty'])->name('duties.store');
    Route::put('duties/update/{id}', [DutyController::class, 'updateDuty'])->name('duties.update');
    Route::post('/update-duty-status', [DutyController::class, 'updateStatus'])->name('duties.updateStatus');
    Route::get('events/status', [EventStatusController::class, 'index'])->name('events.status');
    Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');
    Route::patch('events/status/update/{id}', [EventStatusController::class, 'update'])->name('events.status.update');
    Route::delete('events/status/delete/{id}', [EventStatusController::class, 'delete'])->name('events.status.delete');
    Route::get('ticket-status', [TicketStatusController::class, 'index'])->name('ticket-status.index');
    Route::get('ticket-status/create', [TicketStatusController::class, 'create'])->name('ticket-status.create');
    Route::post('ticket-status', [TicketStatusController::class, 'store'])->name('ticket-status.store');
    Route::get('ticket-status/{ticketStatus}/edit', [TicketStatusController::class, 'edit'])->name('ticket-status.edit');
    Route::patch('ticket-status/{ticketStatus}', [TicketStatusController::class, 'update'])->name('ticket-status.update');
    Route::delete('ticket-status/{ticketStatus}', [TicketStatusController::class, 'destroy'])->name('ticket-status.destroy');
    Route::get('leave-type', [LeaveTypeController::class, 'leaveType'])->name('leave-type');
    Route::post('leave-type/store', [LeaveTypeController::class, 'storeLeaveType'])->name('leave-type.store');
    Route::put('leave-type/update/{id}', [LeaveTypeController::class, 'updateLeaveType'])->name('leave-type.update');
    Route::delete('leave-type/delete/{id}', [LeaveTypeController::class, 'deleteLeaveType'])->name('leave-type.delete');
    Route::post('/update-leavetype-status', [LeaveTypeController::class, 'updateStatus'])->name('leave-type.updateStatus');
    Route::get('faretypes', [FareTypeController::class, 'index'])->name('faretypes');
    Route::post('faretypes/store', [FareTypeController::class, 'store'])->name('faretypes.store');
    Route::put('faretypes/update/{id}', [FareTypeController::class, 'update'])->name('faretypes.update');
    Route::delete('faretypes/delete/{id}', [FareTypeController::class, 'delete'])->name('faretypes.delete');
    Route::get('discounts', [DiscountController::class, 'index'])->name('discounts');
    Route::post('discounts/store', [DiscountController::class, 'discountStore'])->name('discounts.store');
    Route::put('discounts/update/{id}', [DiscountController::class, 'discountUpdate'])->name('discounts.update');
    Route::delete('discounts/delete/{id}', [DiscountController::class, 'discountDelete'])->name('discounts.delete');


});

