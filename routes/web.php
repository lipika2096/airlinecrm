<?php

use Illuminate\Support\Facades\Route;
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
    AirTicketController,
    FareConditionController,
    CommissionController,
    EventStatusController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home route
Route::get('/', function () {
    return view('admin.index');
})->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.post.login');
// Dashboard routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'verified']) // Correct way to add middleware
->group(function () {
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::get('employee-dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee-dashboard');

//Project Routes
Route::get('project-view', function(){
    return view('admin.project-view');
})->name('project-view');

// App routes



Route::delete('wallet/delete', [AgentController::class, 'deleteWallet'])->name('wallet.delete');

Route::post('store-wallet', [AgentController::class, 'storeWallet'])->name('store.wallet');

Route::post('agentgroups/store', [AgentController::class, 'groupstore'])->name('agentgroups.store');

Route::put('agentgroups/update/{id}', [AgentController::class, 'groupupdate'])->name('agentgroups.update');

Route::delete('wallet/requests/{id}', [AgentController::class, 'deleteWalletRequest'])->name('wallet.requests.delete');



Route::post('agent.store', [AgentController::class, 'store'])->name('agent.store');

Route::patch('agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');

Route::get('agent/view/{id}', [AgentController::class, 'view'])->name('agent.view');
    Route::get('events', [AppController::class, 'calendar'])->name('events');
    Route::post('events/store', [AppController::class, 'store'])->name('events.store');
    Route::get('airlines', [AirlineController::class, 'index'])->name('airlines');
    Route::post('airlines/store', [AirlineController::class, 'store'])->name('airlines.store');
    Route::patch('airlines/edit/{id}', [AirlineController::class, 'update'])->name('airlines.update');
    Route::get('agent', [AgentController::class, 'index'])->name('agents');

    Route::get('sales-lead', [SalesLeadController::class, 'index'])->name('saleslead');
    Route::post('sales-lead/store', [SalesLeadController::class, 'store'])->name('saleslead.store');
    Route::patch('sales-lead/edit/{id}', [SalesLeadController::class, 'update'])->name('saleslead.update');

    Route::get('air-tickets', [AirTicketController::class, 'index'])->name('air-tickets');

    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');
// Employee routes
    Route::get('employees', [EmployeeController::class, 'allEmployees'])->name('employees');
    Route::get('employees-list', [EmployeeController::class, 'Employeeslist'])->name('employees-list');
    Route::post('employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::patch('employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::get('holidays', [EmployeeController::class, 'holidays'])->name('holidays');
    Route::post('holidays/store', [EmployeeController::class, 'holidayStore'])->name('holidays.store');
    Route::patch('holidays/edit/{id}', [EmployeeController::class, 'holidayUpdate'])->name('holidays.update');
    Route::get('leaves', [EmployeeController::class, 'leavesAdmin'])->name('leaves');
    Route::post('leaves/store', [EmployeeController::class, 'leavesAdminStore'])->name('leaves.store');
    Route::patch('leaves/edit/{id}', [EmployeeController::class, 'leavesAdminUpdate'])->name('leaves.update');
    Route::get('leaves-employee', [EmployeeController::class, 'leavesEmployee'])->name('leaves-employee');
    Route::get('leave-settings', [EmployeeController::class, 'leaveSettings'])->name('leave-settings');
    Route::get('attendance', [EmployeeController::class, 'attendanceAdmin'])->name('attendance');
    Route::get('attendance-employee', [EmployeeController::class, 'attendanceEmployee'])->name('attendance-employee');
    Route::get('departments', [EmployeeController::class, 'departments'])->name('departments');
    Route::post('departments/store', [EmployeeController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('departments/edit/{id}', [EmployeeController::class, 'editDepartment'])->name('departments.edit');
    Route::get('designations', [EmployeeController::class, 'designations'])->name('designations');
    Route::post('designations/store', [EmployeeController::class, 'storeDesignation'])->name('designations.store');
    Route::patch('designations/edit/{id}', [EmployeeController::class, 'editDesignation'])->name('designations.edit');
    Route::get('timesheet', [EmployeeController::class, 'timesheet'])->name('timesheet');
    Route::get('shift-scheduling', [EmployeeController::class, 'shiftScheduling'])->name('shift-scheduling');
    Route::get('overtime', [EmployeeController::class, 'overtime'])->name('overtime');

// Task routes
    Route::get('tasks', [TaskController::class, 'tasks'])->name('tasks');
    Route::get('task-board', [TaskController::class, 'taskBoard'])->name('task-board');

// Lead routes
    Route::get('leads', [LeadController::class, 'index'])->name('leads');
//Status Routes
    Route::get('events/status', [EventStatusController:: class, 'index'])->name('events.status');
    Route::post('events/status/store', [EventStatusController::class, 'store'])->name('events.status.store');

// Ticket routes
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets');

// Sales routes
    Route::get('estimates', [SalesController::class, 'estimates'])->name('estimates');
    Route::get('invoices', [SalesController::class, 'invoices'])->name('invoices');
    Route::get('payments', [SalesController::class, 'payments'])->name('payments');
    Route::get('expenses', [SalesController::class, 'expenses'])->name('expenses');
    Route::get('provident-fund', [SalesController::class, 'providentFund'])->name('provident-fund');
    Route::get('taxes', [SalesController::class, 'taxes'])->name('taxes');

// Accounting routes
    Route::get('categories', [AccountingController::class, 'categories'])->name('categories');
    Route::get('budgets', [AccountingController::class, 'budgets'])->name('budgets');
    Route::get('budget-expenses', [AccountingController::class, 'budgetExpenses'])->name('budget-expenses');
    Route::get('budget-revenues', [AccountingController::class, 'budgetRevenues'])->name('budget-revenues');

// Payroll routes
    Route::get('salary', [PayrollController::class, 'employeeSalary'])->name('salary');
    Route::post('salary/store', [PayrollController::class, 'employeeSalaryStore'])->name('salary.store');
    Route::get('salary-view/{id}', [PayrollController::class, 'payslip'])->name('salary-view');
    Route::get('payroll-items', [PayrollController::class, 'payrollItems'])->name('payroll-items');

// Policy routes
    Route::get('policies', [PolicyController::class, 'index'])->name('policies');
    Route::post('policies/store', [PolicyController::class, 'store'])->name('policies.store');
    Route::patch('policies/update', [PolicyController::class, 'update'])->name('policies.update');


// Report routes
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

// Performance routes
    Route::get('performance-indicator', [PerformanceController::class, 'performanceIndicator'])->name('performance-indicator');
    Route::get('performance-review', [PerformanceController::class, 'performanceReview'])->name('performance-review');
    Route::get('performance-appraisal', [PerformanceController::class, 'performanceAppraisal'])->name('performance-appraisal');

// Goal routes
    Route::get('goal-tracking', [GoalController::class, 'goalList'])->name('goal-tracking');
    Route::get('goal-type', [GoalController::class, 'goalType'])->name('goal-type');

// Training routes
    Route::get('training', [TrainingController::class, 'trainingList'])->name('training');
    Route::get('trainers', [TrainingController::class, 'trainers'])->name('trainers');
    Route::get('training-type', [TrainingController::class, 'trainingType'])->name('training-type');

// HR routes
    Route::get('promotion', [HRController::class, 'promotion'])->name('promotion');
    Route::get('resignation', [HRController::class, 'resignation'])->name('resignation');
    Route::get('termination', [HRController::class, 'termination'])->name('termination');
    Route::post('termination/store', [HRController::class, 'terminationStore'])->name('termination.store');
    Route::post('termination/update', [HRController::class, 'terminationUpdate'])->name('termination.update');
    Route::post('resignation/store', [HRController::class, 'resignationStore'])->name('resignation.store');
    Route::patch('resignation/update', [HRController::class, 'resignationUpdate'])->name('resignation.update');

// Administration routes
    Route::get('assets', [AdministrationController::class, 'assets'])->name('assets');

// Job routes
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

// Knowledgebase routes
    Route::get('knowledgebase', [KnowledgebaseController::class, 'index'])->name('knowledgebase');

// Activity routes
    Route::get('activities', [ActivityController::class, 'index'])->name('activities');

// User routes
    Route::get('users', [UserController::class, 'index'])->name('users');

// Setting routes
    Route::get('settings', [SettingController::class, 'index'])->name('settings');

// Profile routes
    Route::get('profile', [ProfileController::class, 'employeeProfile'])->name('profile');
    Route::get('client-profile', [ProfileController::class, 'clientProfile'])->name('client-profile');
    Route::get('admin-profile', [ProfileController::class, 'adminProfile'])->name('admin-profile');

// Subscription routes
    Route::get('subscriptions', [SubscriptionController::class, 'subscriptionsAdmin'])->name('subscriptions');
    Route::get('subscriptions-company', [SubscriptionController::class, 'subscriptionsCompany'])->name('subscriptions.company');
    Route::get('subscribed-companies', [SubscriptionController::class, 'subscribedCompanies'])->name('subscribed.companies');

    Route::get('roles-permissions', function () {
        return view('admin.roles-permissions');
    });

    Route::get('fare_conditions', [FareConditionController::class, 'index'])->name('fare_conditions.index');
Route::get('fare_conditions/create', [FareConditionController::class, 'create'])->name('fare_conditions.create');
Route::post('fare_conditions', [FareConditionController::class, 'store'])->name('fare_conditions.store');
Route::get('fare_conditions/{fare_condition}', [FareConditionController::class, 'show'])->name('fare_conditions.show');
Route::get('fare_conditions/{fare_condition}/edit', [FareConditionController::class, 'edit'])->name('fare_conditions.edit');
Route::put('fare_conditions/{fare_condition}', [FareConditionController::class, 'update'])->name('fare_conditions.update');
Route::delete('fare_conditions/{fare_condition}', [FareConditionController::class, 'destroy'])->name('fare_conditions.destroy');
Route::put('/airtickets/{id}/update-status', 'AirTicketController@updateStatus')
    ->name('airtickets.update_status');

    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');


Route::get('commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
Route::post('commissions', [CommissionController::class, 'store'])->name('commissions.store');
Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');

});
