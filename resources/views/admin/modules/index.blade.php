@extends('admin/layouts/head-main')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Manage Modules</h3>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Module Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Price (Monthly)</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mainModules as $module)
                                            <tr data-module-id="{{ $module['id'] }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="la la-cube fa-lg me-2 text-primary"></i>
                                                        <span>{{ $module['display_name'] }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $module['description'] ?: '-' }}</td>
                                                <td>
                                                    @if($module['status'] === 'published')
                                                        <button class="btn btn-sm btn-success status-btn"
                                                            data-module-id="{{ $module['id'] }}"
                                                            data-current-status="published">
                                                            Active
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary status-btn"
                                                            data-module-id="{{ $module['id'] }}"
                                                            data-current-status="unpublished">
                                                            Inactive
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($module['is_priced_module'])
                                                        ${{ number_format($module['monthly_price'], 2) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-primary edit-module-btn"
                                                        data-module-id="{{ $module['id'] }}"
                                                        data-module-name="{{ $module['display_name'] }}"
                                                        data-description="{{ $module['description'] }}"
                                                        data-monthly-price="{{ $module['monthly_price'] }}"
                                                        data-is-priced-module="{{ $module['is_priced_module'] ? 'true' : 'false' }}"
                                                        data-status="{{ $module['status'] }}">
                                                        <i class="la la-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->

    <!-- Edit Module Modal -->
    <div class="modal fade" id="editModuleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Module</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editModuleForm">
                        @csrf
                        <input type="hidden" id="editModuleId" name="module_id">

                        <div class="form-group">
                            <label>Module Name</label>
                            <input type="text" class="form-control" id="editModuleName" readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label>Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label>Status</label>
                            <select class="form-control" id="editStatus" name="status">
                                <option value="published">Published</option>
                                <option value="unpublished">Unpublished</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editIsPricedModule" name="is_priced_module">
                                <label class="form-check-label" for="editIsPricedModule">
                                    Enable Pricing
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-3" id="priceField">
                            <label>Monthly Price ($)</label>
                            <input type="number" class="form-control" id="editMonthlyPrice" name="monthly_price" step="0.01" min="0">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveModuleBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle module status
            $('.status-btn').on('click', function() {
                var moduleId = $(this).data('module-id');
                var currentStatus = $(this).data('current-status');
                var button = $(this);

                $.ajax({
                    url: '{{ route('admin.modules.toggle-status') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        module_id: moduleId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        let msg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    }
                });
            });

            // Open edit modal
            $('.edit-module-btn').on('click', function() {
                var moduleId = $(this).data('module-id');
                var moduleName = $(this).data('module-name');
                var description = $(this).data('description');
                var monthlyPrice = $(this).data('monthly-price');
                var isPricedModule = $(this).data('is-priced-module') === 'true';
                var status = $(this).data('status');

                $('#editModuleId').val(moduleId);
                $('#editModuleName').val(moduleName);
                $('#editDescription').val(description);
                $('#editMonthlyPrice').val(monthlyPrice);
                $('#editIsPricedModule').prop('checked', isPricedModule);
                $('#editStatus').val(status);

                // Show/hide price field based on is_priced_module
                if (isPricedModule) {
                    $('#priceField').show();
                } else {
                    $('#priceField').hide();
                }

                $('#editModuleModal').modal('show');
            });

            // Toggle price field visibility
            $('#editIsPricedModule').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#priceField').show();
                } else {
                    $('#priceField').hide();
                }
            });

            // Save module changes
            $('#saveModuleBtn').on('click', function() {
                var formData = {
                    _token: '{{ csrf_token() }}',
                    module_id: $('#editModuleId').val(),
                    description: $('#editDescription').val(),
                    status: $('#editStatus').val(),
                    is_priced_module: $('#editIsPricedModule').is(':checked') ? 1 : 0,
                    monthly_price: $('#editMonthlyPrice').val() || 0
                };

                $.ajax({
                    url: '{{ route('admin.modules.update') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message);
                        $('#editModuleModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        let msg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    }
                });
            });
        });
    </script>

@endsection
