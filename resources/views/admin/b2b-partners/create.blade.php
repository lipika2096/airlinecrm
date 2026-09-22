@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <title>Add New Travel Partner</title>

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <style>
            .submit-section {
                margin-top: 10px !important;
            }
            .add-btn {
                background-color: #ff9b44;
                border: 1px solid #ff9b44;
                color: #ffffff;
                float: right;
                font-weight: 500;
                min-width: 140px;
                border-radius: 50px;
                font-size: 13px;
                transition: all 0.3s ease;
            }
            .add-btn:hover {
                background-color: #e88a3a;
                border-color: #e88a3a;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(255, 155, 68, 0.3);
            }

            /* Enhanced Card Styling */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
            }
            .card:hover {
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            }
            .card-body {
                padding: 24px;
            }

            /* Enhanced Typography */
            .page-title {
                font-weight: 600;
                color: #1a1a2e;
                font-size: 24px;
                margin-bottom: 8px;
            }
            .breadcrumb-item a {
                color: #6c757d;
                transition: color 0.2s ease;
            }
            .breadcrumb-item a:hover {
                color: #ff9b44;
            }
            .breadcrumb-item.active {
                color: #ff9b44;
                font-weight: 500;
            }

            /* Enhanced Tabs */
            .nav-tabs {
                border-bottom: 2px solid #e9ecef;
                margin-bottom: 24px;
            }
            .nav-tabs .nav-link {
                color: #6c757d;
                border: none;
                border-bottom: 3px solid transparent;
                border-radius: 0;
                padding: 12px 20px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .nav-tabs .nav-link:hover {
                color: #ff9b44;
                border-bottom-color: #ff9b44;
            }
            .nav-tabs .nav-link.active {
                background-color: transparent;
                color: #ff9b44;
                border-bottom: 3px solid #ff9b44;
            }
            .step-number {
                display: inline-block;
                width: 32px;
                height: 32px;
                line-height: 32px;
                text-align: center;
                border-radius: 50%;
                background-color: #ff9b44;
                color: white;
                margin-right: 10px;
                font-weight: 600;
                font-size: 14px;
            }

            /* Enhanced Form Styling */
            .form-group {
                margin-bottom: 20px;
            }
            .form-group label {
                font-weight: 500;
                color: #495057;
                margin-bottom: 8px;
                font-size: 14px;
            }
            .form-control {
                border-radius: 8px;
                border: 1px solid #e0e0e0;
                padding: 12px 16px;
                font-size: 14px;
                transition: all 0.3s ease;
            }
            .form-control:focus {
                border-color: #ff9b44;
                box-shadow: 0 0 0 3px rgba(255, 155, 68, 0.1);
            }
            .form-control.is-invalid {
                border-color: #dc3545;
            }
            .form-control.is-invalid:focus {
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            }

            /* Enhanced Buttons */
            .btn-primary {
                background-color: #ff9b44;
                border-color: #ff9b44;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #e88a3a;
                border-color: #e88a3a;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 155, 68, 0.3);
            }
            .btn-secondary {
                background-color: #6c757d;
                border-color: #6c757d;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-secondary:hover {
                background-color: #5a6268;
                border-color: #5a6268;
                transform: translateY(-2px);
            }
            .btn-danger {
                background-color: #dc3545;
                border-color: #dc3545;
                border-radius: 8px;
                transition: all 0.3s ease;
            }
            .btn-danger:hover {
                background-color: #c82333;
                border-color: #c82333;
            }

            /* Enhanced Contact Rows */
            .contact-row {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                transition: all 0.3s ease;
            }
            .contact-row:hover {
                background-color: #f1f3f5;
                border-color: #dee2e6;
            }

            /* Enhanced Checkboxes */
            .form-check-input {
                border-radius: 4px;
                border: 2px solid #e0e0e0;
                transition: all 0.3s ease;
            }
            .form-check-input:checked {
                background-color: #ff9b44;
                border-color: #ff9b44;
            }
            .form-check-input:focus {
                box-shadow: 0 0 0 3px rgba(255, 155, 68, 0.1);
            }
            .form-check-label {
                cursor: pointer;
                padding-left: 8px;
                color: #495057;
            }

            /* Tab Content */
            .tab-content {
                padding: 8px 0;
            }
            .tab-pane h5 {
                color: #1a1a2e;
                font-weight: 600;
                margin-bottom: 20px;
            }
            .tab-pane h6 {
                color: #495057;
                font-weight: 600;
                margin-bottom: 16px;
                font-size: 16px;
            }
        </style>
        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add New Travel Partner</h3>
                        <ul class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.dashboard') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : route('staff.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners') : route('staff.b2b-partners')) }}">B2B Partners</a></li>
                            <li class="breadcrumb-item active">Add New Partner</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.b2b-partners.store') : (\App\Helpers\RouteHelper::isCustomer() ? route('customer.b2b-partners.store') : route('staff.b2b-partners.store')) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs" id="partnerTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                            <span class="step-number">1</span> General Details
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">
                                            <span class="step-number">2</span> Contact Persons
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="airlines-tab" data-bs-toggle="tab" data-bs-target="#airlines" type="button" role="tab">
                                            <span class="step-number">3</span> Airlines & Products
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="responsibility-tab" data-bs-toggle="tab" data-bs-target="#responsibility" type="button" role="tab">
                                            <span class="step-number">4</span> Responsibility
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content mt-4" id="partnerTabsContent">
                                    <!-- General Details Tab -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                                        <h5 class="mb-3">General Details</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Partner Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="partner_name" class="form-control" required value="{{ old('partner_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Partner Type <span class="text-danger">*</span></label>
                                                    <select name="partner_type" class="form-control" required>
                                                        <option value="">Select Type</option>
                                                        <option value="Travel Agent" @if (old('partner_type') == 'Travel Agent') selected @endif>Travel Agent</option>
                                                        <option value="Tour Operator" @if (old('partner_type') == 'Tour Operator') selected @endif>Tour Operator</option>
                                                        <option value="Corporate" @if (old('partner_type') == 'Corporate') selected @endif>Corporate</option>
                                                        <option value="TMC" @if (old('partner_type') == 'TMC') selected @endif>TMC</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country <span class="text-danger">*</span></label>
                                                    <input type="text" name="country" class="form-control" required value="{{ old('country') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>IATA / TIDS No.</label>
                                                    <input type="text" name="iata_tids_no" class="form-control" value="{{ old('iata_tids_no') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Website</label>
                                                    <input type="url" name="website" class="form-control" value="{{ old('website') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="Pending" @if (old('status') == 'Pending') selected @endif>Pending</option>
                                                        <option value="Active" @if (old('status') == 'Active') selected @endif>Active</option>
                                                        <option value="Inactive" @if (old('status') == 'Inactive') selected @endif>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Remarks</label>
                                                    <textarea name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="button" class="btn btn-primary" onclick="nextTab('general', 'contacts')">Next <i class="fa fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>

                                    <!-- Contact Persons Tab -->
                                    <div class="tab-pane fade" id="contacts" role="tabpanel">
                                        <h5 class="mb-3">Contact Persons</h5>
                                        <p class="text-muted mb-4">Add multiple contacts for each partner. Keep records of key decision makers and their roles.</p>

                                        <div id="contacts-container">
                                            <div class="contact-row border p-4 mb-3 rounded">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="contacts[0][name]" class="form-control" required placeholder="Enter contact name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Designation <span class="text-danger">*</span></label>
                                                            <input type="text" name="contacts[0][designation]" class="form-control" required placeholder="Job title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Role <span class="text-danger">*</span></label>
                                                            <select name="contacts[0][role]" class="form-control" required>
                                                                <option value="Secondary">Secondary</option>
                                                                <option value="Primary">Primary</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Phone <span class="text-danger">*</span></label>
                                                            <input type="text" name="contacts[0][phone]" class="form-control" required placeholder="Phone number">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Email <span class="text-danger">*</span></label>
                                                            <input type="email" name="contacts[0][email]" class="form-control" required placeholder="Email address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-secondary" onclick="addContactRow()">
                                            <i class="fa fa-plus me-2"></i> Add Contact
                                        </button>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-secondary" onclick="prevTab('contacts', 'general')"><i class="fa fa-arrow-left me-2"></i> Back</button>
                                            <button type="button" class="btn btn-primary" onclick="nextTab('contacts', 'airlines')">Next <i class="fa fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>

                                    <!-- Airlines & Products Tab -->
                                    <div class="tab-pane fade" id="airlines" role="tabpanel">
                                        <h5 class="mb-3">Airlines & Products</h5>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Airlines Represented</h6>
                                                <div class="form-group">
                                                    @foreach ($airlines as $airline)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="airlines[]" value="{{ $airline->id }}" id="airline_{{ $airline->id }}">
                                                            <label class="form-check-label" for="airline_{{ $airline->id }}">
                                                                {{ $airline->airline_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Products / Services</h6>
                                                <div class="form-group">
                                                    @foreach ($products as $product)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="products[]" value="{{ $product->id }}" id="product_{{ $product->id }}">
                                                            <label class="form-check-label" for="product_{{ $product->id }}">
                                                                {{ $product->product_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-secondary" onclick="prevTab('airlines', 'contacts')"><i class="fa fa-arrow-left me-2"></i> Back</button>
                                            <button type="button" class="btn btn-primary" onclick="nextTab('airlines', 'responsibility')">Next <i class="fa fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>

                                    <!-- Responsibility Tab -->
                                    <div class="tab-pane fade" id="responsibility" role="tabpanel">
                                        <h5 class="mb-3">Set Responsible Person & Region</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Responsible Person</label>
                                                    <input type="text" name="responsible_person" class="form-control" value="{{ old('responsible_person') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Region</label>
                                                    <input type="text" name="region" class="form-control" value="{{ old('region') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Airline Responsibility</label>
                                                    <input type="text" name="airline_responsibility" class="form-control" value="{{ old('airline_responsibility') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Product Responsibility</label>
                                                    <input type="text" name="product_responsibility" class="form-control" value="{{ old('product_responsibility') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>TSA Status</label>
                                                    <select name="tsa_status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Activated" @if (old('tsa_status') == 'Activated') selected @endif>Activated</option>
                                                        <option value="Deactivated" @if (old('tsa_status') == 'Deactivated') selected @endif>Deactivated</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-secondary" onclick="prevTab('responsibility', 'airlines')"><i class="fa fa-arrow-left me-2"></i> Back</button>
                                            <div>
                                                <a href="{{ route('admin.b2b-partners') }}" class="btn btn-secondary me-2">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Save Partner</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let contactRowCount = 1;

        function nextTab(currentTab, nextTab) {
            // Validate current tab before proceeding
            if (!validateCurrentTab(currentTab)) {
                return false;
            }
            
            // Hide current tab and show next tab
            document.getElementById(currentTab).classList.remove('show', 'active');
            document.getElementById(currentTab + '-tab').classList.remove('active');
            
            document.getElementById(nextTab).classList.add('show', 'active');
            document.getElementById(nextTab + '-tab').classList.add('active');
        }

        function prevTab(currentTab, prevTab) {
            // Hide current tab and show previous tab
            document.getElementById(currentTab).classList.remove('show', 'active');
            document.getElementById(currentTab + '-tab').classList.remove('active');
            
            document.getElementById(prevTab).classList.add('show', 'active');
            document.getElementById(prevTab + '-tab').classList.add('active');
        }

        function validateCurrentTab(tabId) {
            const currentTab = document.getElementById(tabId);
            const requiredFields = currentTab.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields before proceeding.');
            }

            return isValid;
        }

        function addContactRow() {
            const container = document.getElementById('contacts-container');
            const newRow = document.createElement('div');
            newRow.className = 'contact-row border p-4 mb-3 rounded';
            newRow.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="contacts[${contactRowCount}][name]" class="form-control" required placeholder="Enter contact name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Designation <span class="text-danger">*</span></label>
                            <input type="text" name="contacts[${contactRowCount}][designation]" class="form-control" required placeholder="Job title">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Role <span class="text-danger">*</span></label>
                            <select name="contacts[${contactRowCount}][role]" class="form-control" required>
                                <option value="Secondary">Secondary</option>
                                <option value="Primary">Primary</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="contacts[${contactRowCount}][phone]" class="form-control" required placeholder="Phone number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="contacts[${contactRowCount}][email]" class="form-control" required placeholder="Email address">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.contact-row').remove()">Remove</button>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
            contactRowCount++;
        }

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection