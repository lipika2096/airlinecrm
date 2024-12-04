<?php
$currentRoute = Route::currentRouteName();
?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome/css/all.min.css') }}">

<!-- Lineawesome CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/line-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/css/material.css') }}">

<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.min.css') }}">

@if ($currentRoute == 'admin.dashboard')
<!-- Chart CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/plugins/morris/morris.css') }}">
@endif

@if (in_array($currentRoute, [
    'admin.events', 'admin.employees', 'admin.holidays', 'admin.leaves', 'admin.leaves-employee',
    'admin.leave-settings', 'admin.attendance', 'admin.attendance-employee',
    'admin.departments', 'admin.designations', 'admin.timesheet', 'admin.shift-scheduling',
    'admin.overtime', 'admin.client-profile', 'admin.tasks', 'admin.task-board',
    'admin.tickets', 'admin.estimates', 'admin.invoices', 'admin.expenses',
    'admin.provident-fund', 'admin.taxes', 'admin.salary', 'admin.payroll-items',
    'admin.policies', 'admin.expense-reports', 'admin.invoice-reports',
    'admin.payments-reports', 'admin.project-reports', 'admin.task-reports',
    'admin.user-reports', 'admin.employee-reports', 'admin.payslip-reports',
    'admin.attendance-reports', 'admin.leave-reports', 'admin.daily-reports',
    'admin.performance-indicator', 'admin.performance-review',
    'admin.performance-appraisal', 'admin.goal-tracking', 'admin.goal-type',
    'admin.training', 'admin.trainers', 'admin.training-type', 'admin.promotion',
    'admin.resignation', 'admin.termination', 'admin.assets', 'admin.jobs',
    'admin.manage-resumes', 'admin.shortlist-candidates', 'admin.interview-questions',
    'admin.offer-approvals', 'admin.experience-level', 'admin.candidates',
    'admin.schedule-timing', 'admin.aptitude-results', 'admin.users',
    'admin.settings', 'admin.profile', 'admin.subscribed-companies',
    'admin.components', 'form-horizontal', 'form-vertical',  'admin.groups','admin.employee.view-profile'
]))
<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endif

@if (in_array($currentRoute, [
    'admin.events', 'admin.employees', 'admin.holidays', 'admin.leaves', 'admin.leaves-employee',
    'admin.leave-settings', 'admin.attendance', 'admin.attendance-employee',
    'admin.timesheet', 'admin.shift-scheduling', 'admin.overtime', 'admin.projects',
    'admin.project-view', 'admin.tasks', 'admin.task-board', 'admin.tickets',
    'admin.estimates', 'admin.invoices', 'admin.expenses', 'admin.categories',
    'admin.budgets', 'admin.budget-expenses', 'admin.budget-revenues',
    'admin.salary', 'admin.payroll-items', 'admin.expense-reports', 'admin.invoice-reports',
    'admin.payments-reports', 'admin.employee-reports', 'admin.payslip-reports',
    'admin.leave-reports', 'admin.daily-reports', 'admin.performance-indicator',
    'admin.performance-review', 'admin.performance-appraisal', 'admin.goal-tracking',
    'admin.training', 'admin.promotion', 'admin.resignation', 'admin.termination',
    'admin.assets', 'admin.jobs', 'admin.manage-resumes', 'admin.shortlist-candidates',
    'admin.interview-questions', 'admin.offer-approvals', 'admin.experience-level',
    'admin.candidates', 'admin.schedule-timing', 'admin.aptitude-results',
    'admin.users', 'admin.profile', 'admin.components'
]))
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap-datetimepicker.min.css') }}">
@endif

@if ($currentRoute == 'admin.events' || $currentRoute == 'admin.holidays')
<!-- Calendar CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/fullcalendar.min.css') }}">
@endif

@if (in_array($currentRoute, [
    'admin.employees', 'admin.leaves', 'admin.leaves-employee', 'admin.departments',
    'admin.designations', 'admin.timesheet', 'admin.shift-scheduling', 'admin.overtime',
    'admin.client-profile', 'admin.tasks', 'admin.task-board', 'admin.leads', 'admin.tickets',
    'admin.payments', 'admin.expenses', 'admin.provident-fund', 'admin.salary',
    'admin.payroll-items', 'admin.policies', 'admin.expense-reports', 'admin.invoice-reports',
    'admin.payments-reports', 'admin.project-reports', 'admin.task-reports',
    'admin.user-reports', 'admin.employee-reports', 'admin.payslip-reports',
    'admin.attendance-reports', 'admin.leave-reports', 'admin.daily-reports',
    'admin.performance-indicator', 'admin.performance-review',
    'admin.performance-appraisal', 'admin.goal-tracking', 'admin.goal-type',
    'admin.training', 'admin.trainers', 'admin.training-type', 'admin.promotion',
    'admin.resignation', 'admin.termination', 'admin.assets', 'admin.jobs',
    'admin.manage-resumes', 'admin.shortlist-candidates', 'admin.interview-questions',
    'admin.offer-approvals', 'admin.experience-level', 'admin.candidates',
    'admin.schedule-timing', 'admin.aptitude-results', 'admin.users',
    'admin.leave-type', 'admin.subscribed-companies', 'data-tables', 'admin.events', 'admin.holidays', 'admin.attendance','airlines.view','admin.agents','admin.airlines-details', 'admin.airline-library','admin.airline-reports', 'admin.deleted.agents', 'admin.agent-library','admin.agent-reports','admin.view.case-history', 'admin.saleslead', 'admin.air-tickets', 'admin.groups','admin.accounts.view','admin.accounts.all','admin.categories.view','admin.faretypes','admin.duties', 'admin.events.status','admin.events','admin.manage-staff','admin.employee.view-profile','admin.employee.rights','admin.staff-reports'
]))
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/dataTables.bootstrap4.min.css') }}">
@endif

@if ($currentRoute == 'admin.leave-settings')
<!-- Tagsinput CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endif

@if (in_array($currentRoute, ['admin.projects', 'admin.project-view', 'admin.tasks']))
<!-- CKEditor -->
<link rel="stylesheet" href="{{ asset('public/assets/css/ckeditor.css') }}">
@endif

@if (in_array($currentRoute, ['admin.profile', 'admin.components']))
<!-- Tagsinput CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endif

<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
