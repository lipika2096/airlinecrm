@extends('admin/layouts/head-main')
@section('content')
    <title>Admin List</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Customer</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Customer</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <form action="{{ route('admin.admin.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Brand Name</label>
                                        <input class="form-control" name="full_name" type="text" required placeholder="Enter Brand Name">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Email</label>
                                        <input class="form-control" name="email" type="email" required placeholder="Enter Email">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Company Name</label>
                                        <input class="form-control" name="company_name" type="text" required placeholder="Enter Company Name">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Group</label>
                                        <input class="form-control" name="group" type="text"  placeholder="Enter Group">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Street</label>
                                        <input class="form-control" name="address" type="address" required placeholder="Enter Street">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>City</label>
                                        <input class="form-control" name="city" type="city" required placeholder="Enter City">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>State</label>
                                        <input class="form-control" name="state" type="state" required placeholder="Enter State">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Pincode</label>
                                        <input class="form-control" name="pincode" type="text" required placeholder="Enter Pincode">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Country</label>
                                        <input class="form-control" name="country" type="text" required placeholder="Enter Country">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Company Registration No</label>
                                        <input class="form-control" name="company_registration_no" type="text"  placeholder="Enter Company Registration No">
                                    </div>
                                    <!-- <div class="form-group col-sm-3">
                                        <label>Select Role</label>
                                        <select class="form-control" name="role" required>
                                            <option>Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> -->
                                    <div class="form-group col-sm-3">
                                        <label>Subscription Type</label>
                                        <select class="form-control" name="sales_package" id="sales_package_select" required>
                                            <option value="">Select Package</option>
                                            @foreach ($salesPackages as $package)
                                                <option value="{{ $package->id }}" 
                                                        data-monthly-rate="{{ $package->monthly_rate }}"
                                                        data-annual-rate="{{ $package->annual_rate }}"
                                                        data-base-rate="{{ $package->rate }}">
                                                    {{ $package->package_name }} - ${{ number_format($package->rate, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Payment Type</label>
                                        <select class="form-control" name="payment_type" id="payment_type_select" required>
                                            <option value="base">Base Rate</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="annual">Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Select Modules</label>                                
                                        <input class="form-control" name="modules[]" id="modules_ids" type="hidden"  placeholder="Enter Modules" >

                                        <input class="form-control" id="modules_input" type="text"  placeholder="Enter Modules" readonly>
                                        
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Subscription Charges</label>
                                        <input class="form-control" name="subscription_charge" id="subscription_charge" type="text"  placeholder="Enter Subscription Charges">
                                    </div>
                                    <div class="form-group col-sm-3">                            
                                        <label>Package Activation Date</label>
                                        <input class="form-control" name="package_activation_date" type="date" id="package_activation_date">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Subscription Expiring</label>
                                        <input class="form-control" name="subscription_expiring" id="subscription_expiring" type="text"  placeholder="Auto-calculated based on payment type" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <!-- <div class="form-group"> -->
                                        <label class="col-form-label">Business Focus</label>
                                        <div id="focus-destinations-container">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="focus_destinations[]"
                                                    placeholder="Enter Business Focus">
                                                <button class="btn btn-danger remove-destination" type="button">Remove</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="button" id="add-destination">Add More</button>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label>Remarks</label>
                                        <input class="form-control" name="remarks" type="text" placeholder="Enter Remarks">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Business Mode</label>
                                        <input class="form-control" name="business_mode" type="text" placeholder="Enter Business Mode">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Key People</label>
                                        <input class="form-control" name="key_people" type="text" placeholder="Enter Key People">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Parent Company</label>
                                        <input class="form-control" name="parent_company" type="text"  placeholder="Enter Parent Company">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Headquarters</label>
                                        <input class="form-control" name="headquarters" type="text"  placeholder="Enter Headquarter Name">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>No. of Employees</label>
                                        <input class="form-control" name="no_employees" type="number"  placeholder="Enter No. of employees">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Websites</label>
                                        <div id="website-address-container">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="websites[]"
                                                    placeholder="Enter website address">
                                                <button class="btn btn-danger remove-website-address"
                                                    type="button">Remove</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="button" id="add-website-address">Add More</button>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

    </div>
    <!-- /Page Content -->
    </div>
    <script>
        document.getElementById('add-destination').addEventListener('click', function() {
            const container = document.getElementById('focus-destinations-container');
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');
            newInputGroup.innerHTML = `
                <input type="text" class="form-control" name="focus_destinations[]" placeholder="Enter destination">
                <button class="btn btn-danger remove-destination" type="button">Remove</button>
            `;
            container.appendChild(newInputGroup);

            // Add event listener to the remove button
            newInputGroup.querySelector('.remove-destination').addEventListener('click', function() {
                container.removeChild(newInputGroup);
            });
        });
        document.getElementById('add-website-address').addEventListener('click', function() {
                const container = document.getElementById('website-address-container');
                const newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-2');
                newInputGroup.innerHTML = `
                    <input type="text" class="form-control" name="websites[]" placeholder="Enter Website address">
                    <button class="btn btn-danger remove-website-address" type="button">Remove</button>
                `;
                container.appendChild(newInputGroup);

                // Add event listener to the remove button
                newInputGroup.querySelector('.remove-website-address').addEventListener('click', function() {
                    container.removeChild(newInputGroup);
                });
            });

        // Auto-fill modules when sales package is selected
        document.getElementById('sales_package_select').addEventListener('change', function() {
            const packageId = this.value;
            const modulesSelect = document.getElementById('modules_select');
            
            if (packageId) {
                // Fetch package data via AJAX
                fetch(`./superadmin/sales-packages/${packageId}`)
                    .then(response => response.json())
                    .then(data => {
                        
                        console.log(data);
                        document.getElementById('modules_input').value = data.modules_list;
                        document.getElementById('modules_ids').value = JSON.stringify(data.modules);
                        
                        // Update subscription charge based on payment type
                        updateSubscriptionCharge();
                    })
                    .catch(error => console.error('Error fetching package:', error));
            } else {
                // Clear all selections if no package selected
                Array.from(modulesSelect.options).forEach(option => {
                    option.selected = false;
                });
                document.getElementById('subscription_charge').value = '';
            }
        });

        // Update subscription charge when payment type changes
        document.getElementById('payment_type_select').addEventListener('change', function() {
            updateSubscriptionCharge();
            //updateSubscriptionExpiry();
        });
        document.getElementById('package_activation_date').addEventListener('input', function() {
            updateSubscriptionExpiry();
        });

        function updateSubscriptionCharge() {
            const packageSelect = document.getElementById('sales_package_select');
            const paymentTypeSelect = document.getElementById('payment_type_select');
            const subscriptionChargeInput = document.getElementById('subscription_charge');
            
            if (packageSelect.value) {
                const selectedOption = packageSelect.options[packageSelect.selectedIndex];
                const baseRate = parseFloat(selectedOption.getAttribute('data-base-rate')) || 0;
                const monthlyRate = parseFloat(selectedOption.getAttribute('data-monthly-rate')) || 0;
                const annualRate = parseFloat(selectedOption.getAttribute('data-annual-rate')) || 0;
                
                let rate = 0;
                switch(paymentTypeSelect.value) {
                    case 'monthly':
                        rate = monthlyRate || baseRate;
                        break;
                    case 'annual':
                        rate = annualRate || baseRate;
                        break;
                    default:
                        rate = baseRate;
                }
                
                subscriptionChargeInput.value = rate > 0 ? rate.toFixed(2) : '';
            }
        }

        function updateSubscriptionExpiry() {
            const paymentTypeSelect = document.getElementById('payment_type_select');
            const packageActivationDateInput = document.querySelector('input[name="package_activation_date"]');
            const subscriptionExpiringInput = document.getElementById('subscription_expiring');
            
            
            if (packageActivationDateInput.value && paymentTypeSelect.value) {
                const activationDate = new Date(packageActivationDateInput.value);
                let expiryDate = new Date(activationDate);
                switch(paymentTypeSelect.value) {
                    case 'monthly':
                        expiryDate.setMonth(expiryDate.getMonth() + 1);
                        break;
                    case 'annual':
                        expiryDate.setFullYear(expiryDate.getFullYear() + 1);
                        break;
                    default:
                        // Base rate - no expiry date
                        subscriptionExpiringInput.value = '';
                        return;
                }
                
                // Format the expiry date as YYYY-MM-DD
                const formattedExpiry = expiryDate.toISOString().split('T')[0];
                subscriptionExpiringInput.value = formattedExpiry;
            }
        }

        // Initialize expiry date calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSubscriptionExpiry();
        });
    </script>
@endsection
