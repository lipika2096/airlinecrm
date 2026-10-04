@extends('admin/layouts/head-main')
@section('content')
    <title>Subscription & Billing Rules</title>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Subscription & Billing Rules</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::getDashboardRoute() }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subscription & Billing Rules</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Configure Subscription Rules</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.subscriptions.update') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.subscriptions.update') : route('staff.subscriptions.update')) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Billing Frequency</label>
                                        <select class="form-control" name="billing_frequency" id="billing_frequency">
                                            <option value="monthly" {{ $rule && $rule->billing_frequency === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="yearly" {{ $rule && $rule->billing_frequency === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Annual Discount</label>
                                        <select class="form-control" name="annual_discount" id="annual_discount">
                                            <option value="0" {{ $rule && $rule->annual_discount == 0 ? 'selected' : '' }}>0%</option>
                                            <option value="5" {{ $rule && $rule->annual_discount == 5 ? 'selected' : '' }}>5%</option>
                                            <option value="10" {{ $rule && $rule->annual_discount == 10 ? 'selected' : '' }}>10%</option>
                                            <option value="15" {{ $rule && $rule->annual_discount == 15 ? 'selected' : '' }}>15%</option>
                                            <option value="20" {{ $rule && $rule->annual_discount == 20 ? 'selected' : '' }}>20%</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Proration (First Month)</label>
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="proration_first_month" value="0">
                                            <input class="form-check-input" type="checkbox" name="proration_first_month" id="proration_first_month" value="1" {{ $rule && $rule->proration_first_month ? 'checked' : 'checked' }}>
                                            <label class="form-check-label" for="proration_first_month">
                                                {{ $rule && $rule->proration_first_month ? 'Enabled' : 'Disabled' }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Billing Cycle</label>
                                        <select class="form-control" name="billing_cycle" id="billing_cycle">
                                            <option value="calendar_month" {{ $rule && $rule->billing_cycle === 'calendar_month' ? 'selected' : '' }}>Calendar Month</option>
                                            <option value="anniversary" {{ $rule && $rule->billing_cycle === 'anniversary' ? 'selected' : '' }}>Anniversary Date</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Cancellation</label>
                                        <select class="form-control" name="cancellation_policy" id="cancellation_policy">
                                            <option value="end_of_current_month" {{ $rule && $rule->cancellation_policy === 'end_of_current_month' ? 'selected' : '' }}>End of Current Month</option>
                                            <option value="immediate" {{ $rule && $rule->cancellation_policy === 'immediate' ? 'selected' : '' }}>Immediate</option>
                                            <option value="end_of_billing_cycle" {{ $rule && $rule->cancellation_policy === 'end_of_billing_cycle' ? 'selected' : '' }}>End of Billing Cycle</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Minimum Subscription Period</label>
                                        <select class="form-control" name="minimum_subscription_period" id="minimum_subscription_period">
                                            <option value="1 Month" {{ $rule && $rule->minimum_subscription_period === '1 Month' ? 'selected' : '' }}>1 Month</option>
                                            <option value="3 Months" {{ $rule && $rule->minimum_subscription_period === '3 Months' ? 'selected' : '' }}>3 Months</option>
                                            <option value="6 Months" {{ $rule && $rule->minimum_subscription_period === '6 Months' ? 'selected' : '' }}>6 Months</option>
                                            <option value="12 Months" {{ $rule && $rule->minimum_subscription_period === '12 Months' ? 'selected' : '' }}>12 Months</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Notice Period (for cancellation)</label>
                                        <select class="form-control" name="notice_period" id="notice_period">
                                            <option value="0 Days" {{ $rule && $rule->notice_period === '0 Days' ? 'selected' : '' }}>0 Days</option>
                                            <option value="7 Days" {{ $rule && $rule->notice_period === '7 Days' ? 'selected' : '' }}>7 Days</option>
                                            <option value="15 Days" {{ $rule && $rule->notice_period === '15 Days' ? 'selected' : '' }}>15 Days</option>
                                            <option value="30 Days" {{ $rule && $rule->notice_period === '30 Days' ? 'selected' : '' }}>30 Days</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Example Plan Section -->
                                <div class="mt-4 p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                                    <h6 class="mb-3"><strong>Example Plan</strong></h6>
                                    <p class="text-muted mb-2">Based on current date: 15th</p>
                                    <div id="example-plan">
                                        <div class="mb-2">
                                            <strong>If subscription starts on Sep 15:</strong>
                                            <span id="subscription-start-example" class="text-success">
                                                First invoice only for Sep 15 - Sep 30
                                            </span>
                                        </div>
                                        <div>
                                            <strong>If subscription cancels on Sep 6:</strong>
                                            <span id="cancellation-example" class="text-danger">
                                                Access ends on Sep 30
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Save Rules</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const prorationToggle = document.getElementById('proration_first_month');
            const prorationLabel = prorationToggle.nextElementSibling;
            const cancellationPolicy = document.getElementById('cancellation_policy');
            const noticePeriod = document.getElementById('notice_period');

            // Update proration label
            prorationToggle.addEventListener('change', function() {
                prorationLabel.textContent = this.checked ? 'Enabled' : 'Disabled';
                updateExamplePlan();
            });

            // Update example plan on any change
            document.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', updateExamplePlan);
            });

            function updateExamplePlan() {
                const prorationEnabled = prorationToggle.checked;
                const cancellation = cancellationPolicy.value;
                const notice = noticePeriod.value;

                // Update subscription start example
                const startExample = document.getElementById('subscription-start-example');
                if (prorationEnabled) {
                    startExample.textContent = 'First invoice only for Sep 15 - Sep 30';
                } else {
                    startExample.textContent = 'First invoice for full month (Sep 1 - Sep 30)';
                }

                // Update cancellation example
                const cancelExample = document.getElementById('cancellation-example');
                if (cancellation === 'end_of_current_month') {
                    cancelExample.textContent = 'Access ends on Sep 30';
                } else if (cancellation === 'immediate') {
                    cancelExample.textContent = 'Access ends immediately on Sep 6';
                } else if (cancellation === 'end_of_billing_cycle') {
                    cancelExample.textContent = 'Access ends at end of billing cycle';
                }

                // Add notice period info
                if (notice !== '0 Days') {
                    cancelExample.textContent += ` (after ${notice} notice)`;
                }
            }

            // Initialize
            updateExamplePlan();
        });
    </script>
@endsection
