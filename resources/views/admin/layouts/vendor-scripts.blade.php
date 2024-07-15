<?php
use Illuminate\Support\Facades\Route;

$currentRoute = Route::currentRouteName();
?>

<!-- jQuery -->
<script src="{{ asset('public/assets/js/jquery-3.6.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Theme Settings JS -->
<script src="{{ asset('public/assets/js/layout.js') }}"></script>
<script src="{{ asset('public/assets/js/theme-settings.js') }}"></script>
<script src="{{ asset('public/assets/js/greedynav.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('public/assets/js/jquery.slimscroll.min.js') }}"></script>

@if ($currentRoute == 'admin.dashboard')
    <!-- Chart JS -->
    <script src="{{ asset('public/assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/chart.js') }}"></script>
@endif

@php
$routesWithSelect2 = [
    'admin.events', 'admin.employees', 'admin.leaves', 'admin.leave-settings',
    'admin.attendance', 'admin.departments', 'admin.designations', 'admin.timesheet', 'admin.shift-scheduling','admin.holidays',
    'admin.overtime', 'admin.client-profile', 'admin.tasks', 'admin.task-board', 'admin.tickets',
    'admin.estimates', 'admin.invoices', 'admin.expenses', 'admin.provident-fund', 'admin.taxes',
    'admin.salary', 'admin.payroll-items', 'admin.policies', 'admin.expense-reports',
    'admin.invoice-reports', 'admin.payments-reports', 'admin.project-reports', 'admin.task-reports',
    'admin.user-reports', 'admin.employee-reports', 'admin.payslip-reports', 'admin.attendance-reports',
    'admin.leave-reports', 'admin.daily-reports', 'admin.performance-indicator',
    'admin.performance-review', 'admin.performance-appraisal', 'admin.goal-tracking',
    'admin.goal-type', 'admin.training', 'admin.trainers', 'admin.training-type', 'admin.promotion',
    'admin.resignation', 'admin.termination', 'admin.assets', 'admin.jobs', 'admin.manage-resumes',
    'admin.shortlist-candidates', 'admin.interview-questions', 'admin.offer-approvals',
    'admin.experience-level', 'admin.candidates', 'admin.schedule-timing', 'admin.aptitude-results',
    'admin.users', 'admin.settings', 'admin.profile', 'admin.subscribed-companies', 'admin.components',
    'form-horizontal', 'form-vertical'
];
@endphp
@if (in_array($currentRoute, $routesWithSelect2))
    <!-- Select2 JS -->
    <script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
@endif

@php
$routesWithDatetimepicker = [
    'admin.events','admin.holidays', 'admin.employees', 'admin.leaves', 'admin.leave-settings',
    'admin.attendance', 'admin.timesheet', 'admin.shift-scheduling', 'admin.overtime',
    'admin.projects', 'admin.project-view', 'admin.tasks', 'admin.task-board', 'admin.tickets',
    'admin.estimates', 'admin.invoices', 'admin.expenses', 'admin.categories', 'admin.sub-category',
    'admin.budgets', 'admin.budget-expenses', 'admin.budget-revenues', 'admin.salary',
    'admin.payroll-items', 'admin.expense-reports', 'admin.payments-reports', 'admin.employee-reports',
    'admin.payslip-reports', 'admin.leave-reports', 'admin.daily-reports', 'admin.performance-indicator',
    'admin.performance-review', 'admin.performance-appraisal', 'admin.goal-tracking', 'admin.training',
    'admin.promotion', 'admin.resignation', 'admin.termination', 'admin.assets', 'admin.job-details',
    'admin.jobs', 'admin.job-applicants', 'admin.manage-resumes', 'admin.shortlist-candidates',
    'admin.interview-questions', 'admin.offer-approvals', 'admin.experience-level', 'admin.candidates',
    'admin.schedule-timing', 'admin.aptitude-results', 'admin.users', 'admin.profile', 'admin.components'
];
@endphp
@if (in_array($currentRoute, $routesWithDatetimepicker)) {
    <!-- Datetimepicker JS -->
    <script src="{{ asset('public/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
}
@endif

@php
$routesWithCalendar = [
    'admin.events', 'admin.employees', 'admin.holidays', 'admin.leaves', 'admin.leave-settings',
    'admin.attendance', 'admin.timesheet', 'admin.shift-scheduling', 'admin.overtime', 'admin.projects',
    'admin.project-view', 'admin.tasks', 'admin.task-board', 'admin.tickets', 'admin.estimates',
    'admin.invoices', 'admin.expenses', 'admin.categories', 'admin.budgets', 'admin.budget-expenses',
    'admin.budget-revenues', 'admin.salary', 'admin.payroll-items', 'admin.expense-reports',
    'admin.payments-reports', 'admin.employee-reports', 'admin.payslip-reports', 'admin.leave-reports',
    'admin.daily-reports', 'admin.performance-indicator', 'admin.performance-review',
    'admin.performance-appraisal', 'admin.goal-tracking', 'admin.training', 'admin.promotion',
    'admin.resignation', 'admin.termination', 'admin.assets', 'admin.job-details', 'admin.jobs',
    'admin.job-applicants', 'admin.manage-resumes', 'admin.shortlist-candidates', 'admin.interview-questions',
    'admin.offer-approvals', 'admin.experience-level', 'admin.candidates', 'admin.schedule-timing',
    'admin.aptitude-results', 'admin.users', 'admin.profile', 'admin.subscribed-companies'
];
@endphp
@if (in_array($currentRoute, $routesWithCalendar))

    <script src="{{ asset('public/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery.fullcalendar.js') }}"></script>
@endif

@php
$routesWithDatatable = [
    'admin.employees', 'admin.leaves', 'admin.departments', 'admin.designations',
    'admin.timesheet', 'admin.shift-scheduling', 'admin.overtime', 'admin.client-profile',
    'admin.tasks', 'admin.task-board', 'admin.leads', 'admin.tickets', 'admin.payments',
    'admin.expenses', 'admin.provident-fund', 'admin.salary', 'admin.payroll-items', 'admin.policies',
    'admin.expense-reports', 'admin.invoice-reports', 'admin.payments-reports', 'admin.project-reports',
    'admin.task-reports', 'admin.user-reports', 'admin.employee-reports', 'admin.payslip-reports',
    'admin.attendance-reports', 'admin.leave-reports', 'admin.daily-reports', 'admin.performance-indicator',
    'admin.performance-review', 'admin.performance-appraisal', 'admin.goal-tracking', 'admin.goal-type',
    'admin.training', 'admin.trainers', 'admin.training-type', 'admin.promotion', 'admin.resignation',
    'admin.termination', 'admin.assets', 'admin.jobs', 'admin.job-applicants', 'admin.manage-resumes',
    'admin.shortlist-candidates', 'admin.interview-questions', 'admin.offer-approvals', 'admin.experience-level',
    'admin.candidates', 'admin.schedule-timing', 'admin.aptitude-results', 'admin.users', 'admin.leave-type',
    'admin.subscribed-companies', 'data-tables'
];
@endphp
@if (in_array($currentRoute, $routesWithDatatable))
    <!-- Datatable JS -->
    <script src="{{ asset('public/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/dataTables.bootstrap4.min.js') }}"></script>
 @endif

@if ($currentRoute == 'admin.leave-settings')
    <!-- Multiselect JS -->
    <script src="{{ asset('public/assets/js/multiselect.min.js') }}"></script>
@endif

@if (in_array($currentRoute, ['admin.client-profile', 'admin.project-view', 'admin.tasks']))
    <!-- Summernote JS -->
    <script src="{{ asset('public/assets/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
 @endif

<!-- Custom JS -->
<script src="{{ asset('public/assets/js/app.js') }}"></script>
