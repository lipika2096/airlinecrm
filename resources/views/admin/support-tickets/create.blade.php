@extends('admin/layouts/head-main')
@section('content')
    <title>Create Support Ticket</title>
    

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Create Support Ticket</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.support-tickets.index') }}">Support Tickets</a></li>
                            <li class="breadcrumb-item active">Create Ticket</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">New Support Ticket</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ $isStaff ? route('staff.support-tickets.store') : ($isSuperAdmin ? route('admin.support-tickets.store') : route('customer.support-tickets.store')) }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select class="select form-control" name="department" required>
                                        <option value="">Select Category</option>
                                        <option value="technical_support">Technical Support</option>
                                        <option value="billing">Billing</option>
                                        <option value="booking">Booking</option>
                                        <option value="account">Account</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <!--  -->
                                @if($isSuperAdmin)
                                <div class="form-group">
                                    <label>Priority (Optional)</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline" style="float:left; margin-right:2rem;">
                                            <input type="radio" id="priority_low" name="priority" value="low" class="custom-control-input">
                                            <label class="custom-control-label" for="priority_low">Low</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="float:left; margin-right:2rem;">
                                            <input type="radio" id="priority_medium" name="priority" value="medium" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="priority_medium">Medium</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style="float:left; margin-right:2rem;">
                                            <input type="radio" id="priority_high" name="priority" value="high" class="custom-control-input">
                                            <label class="custom-control-label" for="priority_high">High</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline" style=" margin-right:2rem;">
                                            <input type="radio" id="priority_critical" name="priority" value="critical" class="custom-control-input">
                                            <label class="custom-control-label" for="priority_critical">Critical</label>
                                        </div>
                                    </div>
                                </div>
                                @endif                                
                                <div class="form-group">
                                    <label>Subject <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="subject" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control summernote" name="description" rows="5" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Attach Files</label>
                                    <input type="file" class="form-control-file" name="attachments[]" multiple>
                                    <small class="text-muted">You can attach multiple files (images, documents, etc.) - Max 5MB per file</small>
                                    <div class="attachment-preview mt-2" id="createAttachmentPreview"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Booking Reference (Optional)</label>
                                    <input class="form-control" type="text" name="booking_reference">
                                    <small class="text-muted">If this ticket is related to a specific booking</small>
                                </div>
                                
                                @if($isSuperAdmin)
                                <div class="form-group">
                                    <label>Assign To Staff (Optional)</label>
                                    <select class="select form-control" name="assigned_to">
                                        <option value="">Select a staff member to assign</option>
                                        @foreach ($staffMembers as $staff)
                                            <option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }} ({{ $staff->email }})</option>
                                        @endforeach
                                    </select>
                                </div>                               
                                <div class="form-group" style="display:none;">
                                    <label>Related User (Optional)</label>
                                    <select class="select form-control" name="related_user_id">
                                        <option value="">Select a related user</option>
                                        @foreach ($staffMembers as $staff)
                                            <option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }} ({{ $staff->email }})</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">The user this ticket is about (e.g., if reporting an issue for another user)</small>
                                </div>
                                @endif 
                                
                                <div class="submit-section">
                                    <button class="btn btn-primary" type="submit">Submit Ticket</button>
                                    <a href="{{ route('admin.support-tickets.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
    
    <style>
        .attachment-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        
        .attachment-preview-item {
            position: relative;
            display: inline-block;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            text-align: center;
            width: 100px;
        }
        
        .attachment-preview-item img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        
        .attachment-preview-item .file-icon {
            font-size: 40px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .attachment-preview-item .file-name {
            font-size: 11px;
            color: #495057;
            word-break: break-all;
            line-height: 1.2;
            max-height: 28px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .attachment-preview-item .custom-file-name {
            width: 100%;
            font-size: 10px;
            padding: 2px 4px;
            margin-top: 4px;
            border: 1px solid #ced4da;
            border-radius: 3px;
        }
        
        .attachment-preview-item .remove-file {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .attachment-preview-item .remove-file:hover {
            background: #c82333;
        }
    </style>
    
    <!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter your description here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            
            // Attachment preview functionality for create form
            $('input[name="attachments[]"]').on('change', function() {
                var input = this;
                var previewContainer = $(this).closest('.form-group').find('.attachment-preview');
                previewContainer.empty();
                
                if (input.files && input.files.length > 0) {
                    for (var i = 0; i < input.files.length; i++) {
                        (function(file, index) {
                            var reader = new FileReader();
                            
                            reader.onload = function(e) {
                                var previewItem = $('<div class="attachment-preview-item" data-file-name="' + file.name + '"></div>');
                                
                                // Check if it's an image
                                if (file.type.startsWith('image/')) {
                                    previewItem.append('<img src="' + e.target.result + '" alt="' + file.name + '">');
                                } else {
                                    // Show file icon for non-image files
                                    var iconClass = 'fa-file';
                                    if (file.type.includes('pdf')) {
                                        iconClass = 'fa-file-pdf';
                                    } else if (file.type.includes('word') || file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
                                        iconClass = 'fa-file-word';
                                    } else if (file.type.includes('excel') || file.name.endsWith('.xls') || file.name.endsWith('.xlsx')) {
                                        iconClass = 'fa-file-excel';
                                    } else if (file.type.includes('zip') || file.name.endsWith('.zip') || file.name.endsWith('.rar')) {
                                        iconClass = 'fa-file-archive';
                                    }
                                    previewItem.append('<i class="fa ' + iconClass + ' file-icon"></i>');
                                }
                                
                                previewItem.append('<div class="file-name">' + file.name + '</div>');
                                previewItem.append('<input type="text" class="custom-file-name" placeholder="Custom name (optional)" value="">');
                                previewItem.append('<button type="button" class="remove-file">×</button>');
                                
                                previewContainer.append(previewItem);
                            };
                            
                            reader.readAsDataURL(file);
                        })(input.files[i], i);
                    }
                }
            });
            
            // Remove file functionality
            $(document).on('click', '.remove-file', function() {
                var previewItem = $(this).closest('.attachment-preview-item');
                var fileNameToRemove = previewItem.data('file-name');
                var input = $(this).closest('.form-group').find('input[name="attachments[]"]')[0];
                
                // Create a new FileList without the removed file
                var dt = new DataTransfer();
                for (var i = 0; i < input.files.length; i++) {
                    if (input.files[i].name !== fileNameToRemove) {
                        dt.items.add(input.files[i]);
                    }
                }
                input.files = dt.files;
                
                // Remove the preview item
                previewItem.remove();
            });
            
            // Handle form submission to include custom file names
            $('form').on('submit', function(e) {
                var form = $(this);
                var attachmentNames = [];
                
                // Collect custom file names from preview items
                form.find('.attachment-preview-item').each(function(index) {
                    var customName = $(this).find('.custom-file-name').val();
                    if (customName && customName.trim() !== '') {
                        attachmentNames[index] = customName.trim();
                    }
                });
                
                // Add attachment names as hidden inputs
                form.find('input[name^="attachment_names"]').remove();
                if (attachmentNames.length > 0) {
                    attachmentNames.forEach(function(name, index) {
                        form.append('<input type="hidden" name="attachment_names[' + index + ']" value="' + name + '">');
                    });
                }
            });
        });
    </script>
@endsection