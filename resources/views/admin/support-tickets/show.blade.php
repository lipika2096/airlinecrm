@extends('admin/layouts/head-main')
@section('content')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css" />
    <title>View Support Ticket</title>
    <style>
        .ql-toolbar {
            border-top-left-radius: 20px !important;
            border-top-right-radius: 20px !important;
        }
        .ql-container {
            border-bottom-left-radius: 20px !important;
            border-bottom-right-radius: 20px !important;
        }
    </style>

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{ $isSuperAdmin ? 'Ticket Details' : 'Support Ticket Details' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isCustomer() ? route('customer.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.dashboard') : route('admin.dashboard')) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.dashboard') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.index') : route('customer.support-tickets.index')) }}">Support Ticket Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard')) }}">{{ $isSuperAdmin ? 'All Tickets' : 'Support Tickets' }}</a></li>
                            <li class="breadcrumb-item active">{{ $ticket->ticket_number }}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard')) }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> {{ $isSuperAdmin ? 'Back to All Tickets' : 'Back to List' }}
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            @if($isSuperAdmin || $isStaff)
            <!-- SuperAdmin View -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Ticket Header -->
                    <div class="card ticket-header-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="mb-0" style="margin-right: 1rem;">Ticket {{ $ticket->id }}({{ $ticket->ticket_number }})</h4>
                                        @php
                                            $currentStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                        @endphp
                                        @if($currentStatus)
                                            <span class="badge" style="background-color: {{ $currentStatus->color }}; color: white;">{{ $currentStatus->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($ticket->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="ticket-meta-info">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p><strong>Company:</strong> 
                                                {{ $ticket->company_name ?? '-' }}
                                                @if($isSuperAdmin)
                                                    <button type="button" class="btn btn-sm btn-link p-0 ms-2" data-bs-toggle="modal" data-bs-target="#editCompanyNameModal">
                                                        <i class="fa fa-edit" style="color:#fff;"></i>
                                                    </button>
                                                @endif
                                                </p>
                                                <p><strong>Created By:</strong> {{ $ticket->creator_name }}
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Category:</strong> 
                                                    @if($ticket->department)
                                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $ticket->department)) }}</span>
                                                    @else
                                                        <span style="color:unset;font-size: smaller;">-</span>
                                                    @endif
                                                </p>
                                                <p style="float:inline-start; margin-right:1rem;" ><strong>Priority:</strong> 
                                                    @if($isSuperAdmin)
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn dropdown-toggle p-0" type="button" data-bs-toggle="dropdown" style="background: none; border: none;">
                                                                @if($ticket->priority == 'low')
                                                                    <span class="badge bg-success">Low</span>
                                                                @elseif($ticket->priority == 'medium')
                                                                    <span class="badge bg-primary">Medium</span>
                                                                @elseif($ticket->priority == 'high')
                                                                    <span class="badge bg-danger">High</span>
                                                                @elseif($ticket->priority == 'critical')
                                                                    <span class="badge bg-danger">Critical</span>
                                                                @elseif($ticket->priority == 'urgent')
                                                                    <span class="badge bg-danger">Urgent</span>
                                                                @endif
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#" onclick="changePriority('low')">Low</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="changePriority('medium')">Medium</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="changePriority('high')">High</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="changePriority('critical')">Critical</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="changePriority('urgent')">Urgent</a></li>
                                                            </ul>
                                                        </div>
                                                    @else
                                                        @if($ticket->priority == 'low')
                                                            <span class="badge bg-success">Low</span>
                                                        @elseif($ticket->priority == 'medium')
                                                            <span class="badge bg-primary">Medium</span>
                                                        @elseif($ticket->priority == 'high')
                                                            <span class="badge bg-danger">High</span>
                                                        @elseif($ticket->priority == 'critical')
                                                            <span class="badge bg-danger">Critical</span>
                                                        @elseif($ticket->priority == 'urgent')
                                                            <span class="badge bg-danger">Urgent</span>
                                                        @endif
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Created:</strong> {{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A') }}</p>
                                                <p><strong>SLA Due:</strong> {{ \App\Helpers\TimezoneHelper::format($slaDue, 'M d, Y h:i A') }}
                                                    @if($isOverdue)
                                                        <span class="badge bg-danger ms-2">Overdue</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Action Bar -->
                    <div class="card mt-3">
                        <div class="card-body">
                            @if($ticket->status !== 'closed')
                            <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-status', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', $ticket->id) : route('customer.support-tickets.update-status', $ticket->id)) }}">
                                @csrf
                                @method('patch')
                                <div class="row align-items-end">
                                    @if($isSuperAdmin)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Department</label>
                                            @php
                                                // Always prioritize staff's department if ticket has assigned staff
                                                $defaultDepartment = $ticket->department;
                                                if ($ticket->assignedTo && !empty($ticket->assignedTo->department_names)) {
                                                    $defaultDepartment = trim($ticket->assignedTo->department_names[0] ?? $ticket->department);
                                                }
                                                if ($defaultDepartment) {
                                                    $defaultDepartment = trim($defaultDepartment);
                                                }
                                                // Debug output
                                                // \Log::info('Department debug', [
                                                //     'ticket_department' => $ticket->department,
                                                //     'assigned_to' => $ticket->assigned_to,
                                                //     'staff_department_names' => $ticket->assignedTo ? $ticket->assignedTo->department_names : null,
                                                //     'default_department' => $defaultDepartment
                                                // ]);
                                            @endphp
                                            <select class="form-control"  id="departmentSelect" name="department">
                                                @foreach($departments as $department)
                                                @php
                                                    $deptValue = trim($department);
                                                    $isSelected = ($defaultDepartment && $deptValue === $defaultDepartment) ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $deptValue }}" {{ $isSelected }}>{{ $deptValue }}</option>
                                                @endforeach
                                                <option value="" disabled>Select Department</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Assign To</label>
                                            <select class="form-control" name="assigned_to" id="staffSelect">
                                                <option value="" disabled>Select Staff Member</option>
                                                @if($ticket->assigned_to && $ticket->assignedTo && !$isAssignedStaffDeleted)
                                                    <option value="{{ $ticket->assigned_to }}" selected data-is-current="true">{{ $ticket->assignedTo->first_name }} {{ $ticket->assignedTo->last_name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Priority</label>
                                            <select class="form-control" name="priority">
                                                <option value="">Select Priority</option>
                                                <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                                <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                                <option value="critical" {{ $ticket->priority == 'critical' ? 'selected' : '' }}>Critical</option>
                                                <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                                @if($ticket->priority && !in_array($ticket->priority, ['low', 'medium', 'high', 'critical', 'urgent']))
                                                    <option value="{{ $ticket->priority }}" selected>{{ $ticket->priority }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div> -->
                                    @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                @foreach($ticketStatuses as $status)
                                                    @if($status->slug !== 'closed')
                                                    <option value="{{ $status->slug }}" {{ $ticket->status == $status->slug ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{$ticket->department}}" name="category">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: -60px !important;">Update</button>
                                    </div>
                                    @if($ticket->assigned_to && $ticket->status !== 'closed')
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#closeTicketModal">
                                                <i class="fa fa-times"></i> Close Ticket
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="text" class="form-control" value="{{ $ticketStatuses->where('slug', $ticket->status)->first()?->name ?? $ticket->status }}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </form>
                            @else
                            <!-- Closed Ticket Actions -->
                            <div class="row align-items-center">
                                    <div class="col-md-6 text-center">
                                        <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-status', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', $ticket->id) : route('customer.support-tickets.update-status', $ticket->id)) }}">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="open">
                                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to reopen this ticket?')">
                                                <i class="fa fa-undo"></i> Reopen Ticket
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-center">
                                    <div class="ticket-resolution-info">
                                        <h6 style="color:unset;font-size: smaller;">Resolution Details</h6>
                                        <p><strong>Resolved On:</strong> {{ $ticket->closed_at ? \App\Helpers\TimezoneHelper::format($ticket->closed_at, 'M d, Y h:i A') : 'N/A' }}</p>
                                        <p><strong>Feedback:</strong> {{ $ticket->rating_comment ? $ticket->rating_comment : 'N/A' }}</p>
                                        @if($ticket->rating)
                                        <p><strong>User Rating:</strong> 
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $ticket->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            ({{ $ticket->rating }}/5)
                                        </p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Tabs -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="ticketTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="conversation-tab" data-bs-toggle="tab" href="#conversation" role="tab">Conversation</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="internal-notes-tab" data-bs-toggle="tab" href="#internal-notes" role="tab">Internal Notes ({{ $internalNotes->count() }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#attachments" role="tab">Attachments</a>
                                </li>
                            </ul>
                            
                            <div class="tab-content mt-3" id="ticketTabsContent">
                                <!-- Conversation Tab -->
                                <div class="tab-pane fade " id="conversation" role="tabpanel">
                                    <div class="conversation-section {{ $isSuperAdmin ? 'superadmin-conversation' : 'user-conversation' }}">
                                        <!-- Initial Ticket Message -->
                                        @php
                                            $currentUserId = $isStaff ? (auth()->user()?->id ?? null) : (auth('admin')->user()?->id ?? null);
                                            $isTicketCreatorCurrentUser = $ticket->creator && $ticket->creator->id == $currentUserId;
                                            $creatorName = $ticket->creator_name;
                                            $creatorType = $ticket->creator_type;
                                        @endphp
                                        <div class="message-item {{ $isTicketCreatorCurrentUser ? 'note-dark mb-3' : 'note-light mb-3' }}">
                                            <div class="message-header d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong>{{ $creatorName }}</strong>
                                                    <small class="message-time" style="margin-left: 1rem;">{{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="message-body">
                                                <div>{!! $ticket->description !!}</div>
                                                @if($ticket->attachments && !empty(json_decode($ticket->attachments, true)))
                                                    @php
                                                        $ticketAttachments = json_decode($ticket->attachments, true);
                                                    @endphp
                                                    <div class="attachments mt-2">
                                                        <strong>Attachments:</strong><br>
                                                        @foreach($ticketAttachments as $attachment)
                                                            @php
                                                                $attachmentPath = is_array($attachment) ? $attachment['path'] : $attachment;
                                                                $attachmentName = is_array($attachment) && isset($attachment['original_name']) ? $attachment['original_name'] : basename($attachmentPath);
                                                            @endphp
                                                            <a href="{{ asset('storage/app/public/' . $attachmentPath) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                <i class="fa fa-paperclip"></i> {{ $attachmentName }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Comments (including final comments in chronological order) -->
                                        @if(isset($allComments) && $allComments->count() > 0)
                                            @foreach ($allComments as $commentItem)
                                                @if($commentItem['type'] === 'regular')
                                                    @php
                                                        $comment = $commentItem['data'];
                                                        $isCommentAuthorCurrentUser = $comment->user_id == $currentUserId;
                                                        $commentAuthorName = $comment->author_name;
                                                        $commentAuthorType = $comment->author_type;
                                                    @endphp
                                                    <div class="message-item {{ $isCommentAuthorCurrentUser ? 'note-dark mb-3' : 'note-light mb-3' }}">
                                                        <div class="message-header d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <strong>{{ $commentAuthorName }}</strong>
                                                                <small class="message-time" style="margin-left: 1rem;">{{ \App\Helpers\TimezoneHelper::format($comment->created_at, 'M d, Y h:i A') }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            <div>{!! $comment->comment !!}</div>
                                                            @if($comment->attachments && !empty($comment->attachments))
                                                                @php $attachments = is_array($comment->attachments) ? $comment->attachments : json_decode($comment->attachments, true); @endphp
                                                                @if($attachments && !empty($attachments))
                                                                    <div class="attachments mt-2">
                                                                        <strong>Attachments:</strong><br>
                                                                        @foreach($attachments as $attachment)
                                                                            @php
                                                                                $attachmentPath = is_array($attachment) ? $attachment['path'] : $attachment;
                                                                                $attachmentName = is_array($attachment) && isset($attachment['original_name']) ? $attachment['original_name'] : basename($attachmentPath);
                                                                            @endphp
                                                                            <a href="{{ asset('storage/app/public/' . $attachmentPath) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                                <i class="fa fa-paperclip"></i> {{ $attachmentName }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @elseif($commentItem['type'] === 'final')
                                                    @php
                                                        $ticket = $commentItem['data'];
                                                        $closerName = $ticket->closed_by_name;
                                                        $isReopened = $ticket->status !== 'closed';
                                                    @endphp
                                                    <div class="message-item note-dark mb-3">
                                                        <div class="message-header d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <strong>{{ $closerName }}</strong>
                                                                <small class="message-time" style="margin-left: 1rem;">{{ $ticket->closed_at ? \App\Helpers\TimezoneHelper::format($ticket->closed_at, 'M d, Y h:i A') : \App\Helpers\TimezoneHelper::format($ticket->updated_at, 'M d, Y h:i A') }}</small>
                                                                @if($isReopened)
                                                                    <span class="badge bg-secondary ms-2">Previously Closed</span>
                                                                @else
                                                                    <span class="badge bg-success ms-2">Final Resolution</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            @if($ticket->status === 'closed')
                                                                <p><strong>Final Resolution Comment:</strong></p>
                                                            @else
                                                                <p><strong>Previous Final Comment (Ticket Reopened):</strong></p>
                                                            @endif
                                                            <p>{{ nl2br($ticket->final_comment) }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                        <!-- Add Comment Form -->
                                        @if($ticket->status !== 'closed')
                                        <div class="add-comment-section mt-4">
                                            <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.add-comment', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.add-comment', $ticket->id) : route('customer.support-tickets.add-comment', $ticket->id)) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group" style="width:92%;">
                                                    <div id="commentEditorAdmin" style="height: 150px; border-radius: 20px;"></div>
                                                    <input type="hidden" name="comment" id="commentInputAdmin">
                                                </div>
                                                <input class="form-control" name="commented_by" value="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? 'superadmin' : (\App\Helpers\RouteHelper::isStaff() ? 'staff' : 'customer') }}" style="display:none;">
                                                <div class="form-group" style="margin-top: 0px;">
                                                    <div style="margin-right: 16px;">
                                                        <label class="btn btn-link p-0 text-success">
                                                            <i class="fa fa-paperclip fa-lg"></i>
                                                            <input type="file" name="attachments[]" multiple style="display: none;" class="attachment-input">
                                                        </label>
                                                        <div class="attachment-preview mt-2" id="attachmentPreviewAdmin" style="display: block; min-height: 50px;"></div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="border-radius: 20px;">
                                                        <i class="fa fa-paper-plane"></i> Send
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="ticket-closed-notice mt-4 text-center">
                                            <p style="color:unset;font-size: smaller;"><i class="fa fa-lock"></i> This ticket is closed. No further comments can be added.</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Details Tab -->
                                <div class="tab-pane fade show active" id="details" role="tabpanel">
                                    <div class="ticket-details">
                                        <h5>Ticket Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Ticket Number</th>
                                                        <td>{{ $ticket->ticket_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Subject</th>
                                                        <td>{{ $ticket->subject }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Department</th>
                                                        <td>{{ $ticket->department ? ucfirst(str_replace('_', ' ', $ticket->department)) : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Created By</th>
                                                        <td>@if(\App\Models\Admin::where('id', $ticket->created_by)->exists())
                                                {{
                                                    \App\Models\Admin::where('id', $ticket->created_by)->first()->name
                                                }}
                                                @else
                                                {{
                                                    \App\Models\User::where('id', $ticket->created_by)->first()->first_name ?? ""
                                                }} {{
                                                    \App\Models\User::where('id', $ticket->created_by)->first()->last_name ?? ""
                                                }}
                                                @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Assigned To</th>
                                                        <td>{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'Unassigned' }}</td>
                                                    </tr>
                                                    @if($ticket->status == 'closed' || $ticket->status == 'resolved')
                                                    <tr>
                                                        <th>Resolved On</th>
                                                        <td>{{ $ticket->resolved_at ? \App\Helpers\TimezoneHelper::format($ticket->resolved_at, 'M d, Y h:i A') : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Resolved By</th>
                                                        <td>{{ $ticket->resolved_by_name }}</td>
                                                    </tr>
                                                    @if($ticket->status == 'closed')
                                                    <tr>
                                                        <th>Closed By</th>
                                                        <td>{{ $ticket->closed_by_name }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($ticket->rating)
                                                    <tr>
                                                        <th>User Rating</th>
                                                        <td>
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fa fa-star {{ $i <= $ticket->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                            @endfor
                                                            ({{ $ticket->rating }}/5)
                                                            @if($ticket->rating_comment)
                                                                <br><small>"{{ $ticket->rating_comment }}"</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endif
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Priority</th>
                                                        <td>
                                                            @php
                                                                $priorityColors = [
                                                                    'low' => '#28a745',
                                                                    'medium' => '#ffc107',
                                                                    'high' => '#fd7e14',
                                                                    'critical' => '#dc3545'
                                                                ];
                                                                $priorityColor = $priorityColors[$ticket->priority] ?? '#6c757d';
                                                            @endphp
                                                            <span class="badge" style="background-color: {{ $priorityColor }}; color: white;">{{ ucfirst($ticket->priority ?? 'Not set') }}</span>
                                                        </td>
                                                    </tr>
                                                    @if($isSuperAdmin || $isStaff)
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            @php
                                                                $detailStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                                            @endphp
                                                            @if($detailStatus)
                                                                <span class="badge" style="background-color: {{ $detailStatus->color }}; color: white;">{{ $detailStatus->name }}</span>
                                                            @else
                                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <th>Booking Reference</th>
                                                        <td>{{ $ticket->booking_reference ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Created At</th>
                                                        <td>{{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Updated At</th>
                                                        <td>{{ \App\Helpers\TimezoneHelper::format($ticket->updated_at, 'M d, Y h:i A') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Internal Notes Tab -->
                                <div class="tab-pane fade" id="internal-notes" role="tabpanel">
                                    <div class="internal-notes">
                                        <!-- <h5>Internal Notes</h5> -->
                                        <!-- <p style="color:unset;font-size: smaller;">Internal notes are only visible to superAdmin users.</p> -->
                                        
                                        @if($internalNotes->count() > 0)
                                        <div class="notes-list">
                                            @foreach ($internalNotes as $index => $note)
                                                <div class="note-item mb-3 pb-3 border-bottom {{ $index % 2 === 0 ? 'note-light mb-3' : 'note-dark mb-3' }}">
                                                    <div class="note-header d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <strong>{{ $note->user ? $note->user->name : 'Unknown' }}</strong>
                                                            <small class="message-time" style="margin-left: 1rem;">{{ \App\Helpers\TimezoneHelper::format($note->created_at, 'M d, Y h:i A') }}</small>
                                                        </div>
                                                        @if($note->user_id == $currentUserId)
                                                            <button type="button" class="btn btn-sm btn-outline-primary edit-note-btn" data-note-id="{{ $note->id }}" data-note-content="{{ $note->note }}">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="note-body">
                                                        <p>{{ nl2br($note->note) }}</p>
                                                        @if($note->attachments && !empty(json_decode($note->attachments, true)))
                                                            <div class="attachments mt-2">
                                                                <strong>Attachments:</strong><br>
                                                                @php $attachments = is_array($note->attachments) ? $note->attachments : json_decode($note->attachments, true); @endphp
                                                                @if($attachments && !empty($attachments))
                                                                    @foreach($attachments as $attachment)
                                                                        @php
                                                                            $attachmentPath = is_array($attachment) ? $attachment['path'] : $attachment;
                                                                            $attachmentName = is_array($attachment) && isset($attachment['original_name']) ? $attachment['original_name'] : basename($attachmentPath);
                                                                        @endphp
                                                                        <a href="{{ asset('storage/app/public/' . $attachmentPath) }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
                                                                            <i class="fa fa-paperclip"></i> {{ $attachmentName }}
                                                                        </a>
                                                                        <br>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <p style="color:unset;font-size: smaller;">No internal notes yet.</p>
                                        @endif

                                        <!-- Edit Note Form (Hidden by default) -->
                                        <div class="edit-note-section mt-4" id="editNoteSection" style="display: none;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3">Edit Internal Note</h5>
                                                    <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-internal-note', $ticket->id) : route('staff.support-tickets.update-internal-note', $ticket->id) }}" id="editNoteForm" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('patch')
                                                        <input type="hidden" name="note_id" id="editNoteId">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="note" rows="3" placeholder="Edit internal note..." required id="editNoteContent"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="btn btn-link p-0">
                                                                <i class="fa fa-paperclip"></i> Attach Additional Files
                                                                <input type="file" name="attachments[]" multiple style="display: none;" class="attachment-input">
                                                            </label>
                                                            <small style="color:unset;font-size: smaller;">You can attach additional files (images, documents, etc.)</small>
                                                            <div class="attachment-preview mt-2" id="editNoteAttachmentPreview" style="display: block; min-height: 50px;"></div>
                                                        </div>
                                                        <div class="d-flex gap-2" style="margin-top: 15px;">
                                                            <button type="submit" class="btn btn-primary">Update Note</button>
                                                            <button type="button" class="btn btn-secondary" id="cancelEditNote">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="add-note-section mt-4">
                                            <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.add-internal-note', $ticket->id) : route('staff.support-tickets.add-internal-note', $ticket->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <textarea class="form-control" name="note" rows="3" placeholder="Add internal note..." required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="btn btn-link p-0">
                                                        <i class="fa fa-paperclip"></i> Attach Files
                                                        <input type="file" name="attachments[]" multiple style="display: none;" class="attachment-input">
                                                    </label>
                                                    <small style="color:unset;font-size: smaller;">You can attach multiple files (images, documents, etc.)</small>
                                                    <div class="attachment-preview mt-2" id="internalNoteAttachmentPreview" style="display: block; min-height: 50px;"></div>
                                                </div>
                                                <button type="submit" class="btn btn-secondary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attachments Tab -->
                                <div class="tab-pane fade" id="attachments" role="tabpanel">
                                    <div class="attachments-section">
                                        <h5>All Attachments</h5>
                                        
                                        @php
                                            $allAttachments = [];
                                            // Add ticket attachments
                                            if($ticket->attachments && !empty(json_decode($ticket->attachments, true))) {
                                                $ticketAttachments = json_decode($ticket->attachments, true);
                                                foreach($ticketAttachments as $attachment) {
                                                    // Handle both old string format and new array format
                                                    if(is_array($attachment)) {
                                                        $path = $attachment['path'];
                                                        $name = isset($attachment['original_name']) ? $attachment['original_name'] : basename($path);
                                                    } else {
                                                        $path = $attachment;
                                                        $name = basename($path);
                                                    }
                                                    $allAttachments[] = [
                                                        'path' => $path,
                                                        'name' => $name,
                                                        'source' => 'Ticket',
                                                        'date' => \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A'),
                                                    ];
                                                }
                                            }
                                            // Add comment attachments
                                            foreach($comments as $comment) {
                                                if($comment->attachments && !empty($comment->attachments)) {
                                                    $commentAttachments = is_array($comment->attachments) ? $comment->attachments : json_decode($comment->attachments, true);
                                                    if($commentAttachments && !empty($commentAttachments)) {
                                                        foreach($commentAttachments as $attachment) {
                                                            // Handle both old string format and new array format
                                                            if(is_array($attachment)) {
                                                                $path = $attachment['path'];
                                                                $name = isset($attachment['original_name']) ? $attachment['original_name'] : basename($path);
                                                            } else {
                                                                $path = $attachment;
                                                                $name = basename($path);
                                                            }
                                                            $allAttachments[] = [
                                                                'path' => $path,
                                                                'name' => $name,
                                                                'source' => 'Comment by ' . ($comment->user ? $comment->user->name : 'Unknown'),
                                                                'date' => \App\Helpers\TimezoneHelper::format($comment->created_at, 'M d, Y h:i A'),
                                                            ];
                                                        }
                                                    }
                                                }
                                            }
                                            // Add internal note attachments
                                            foreach($internalNotes as $note) {
                                                if($note->attachments && !empty($note->attachments)) {
                                                    $noteAttachments = is_array($note->attachments) ? $note->attachments : json_decode($note->attachments, true);
                                                    if($noteAttachments && !empty($noteAttachments)) {
                                                        foreach($noteAttachments as $attachment) {
                                                            // Handle both old string format and new array format
                                                            if(is_array($attachment)) {
                                                                $path = $attachment['path'];
                                                                $name = isset($attachment['original_name']) ? $attachment['original_name'] : basename($path);
                                                            } else {
                                                                $path = $attachment;
                                                                $name = basename($path);
                                                            }
                                                            $allAttachments[] = [
                                                                'path' => $path,
                                                                'name' => $name,
                                                                'source' => 'Internal Note by ' . ($note->user ? $note->user->name : 'Unknown'),
                                                                'date' => \App\Helpers\TimezoneHelper::format($note->created_at, 'M d, Y h:i A'),
                                                            ];
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        @if(!empty($allAttachments))
                                            <div class="attachments-list">
                                                @foreach($allAttachments as $index => $attachment)
                                                    <div class="attachment-item mb-3 pb-3 border-bottom {{ $index % 2 === 0 ? 'note-light mb-3' : 'note-dark mb-3' }}">
                                                        <div class="attachment-header d-flex justify-content-between align-items-center">
                                                            <div class="attachment-info">
                                                                <strong><i class="fa fa-paperclip"></i> {{ $attachment['name'] }}</strong>
                                                                <small class="text-muted d-block mt-1">{{ $attachment['date'] }}</small>
                                                            </div>
                                                            <a href="{{ asset('storage/app/public/' . $attachment['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary flex-shrink-0">
                                                                <i class="fa fa-download"></i> Download
                                                            </a>
                                                        </div>
                                                        <div class="attachment-body mt-2">
                                                            <p class="mb-0"><strong>Source:</strong> {{ $attachment['source'] }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p style="color:unset;font-size: smaller;">No attachments found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
            @else
            <!-- Non-SuperAdmin View (User View) -->
            <div class="row">
                <div class="col-md-12">
                    @if($ticket->status == 'closed')
                    <!-- Ticket Closed View -->
                    <div class="ticket-closed-container">
                        <div class="card ticket-closed-card">
                            <div class="card-body text-center">
                                <div class="ticket-closed-icon mb-4">
                                    <i class="fa fa-check-circle fa-4x text-success"></i>
                                </div>
                                <h2 class="ticket-closed-title">Ticket {{ $ticket->ticket_number }}</h2>
                                <h4 class="ticket-closed-title">{{ $ticket->ticket_number }}</h4>
                                <span class="badge bg-success badge-lg mb-3">Closed</span>
                                <p class="ticket-closed-message">
                                    This ticket was closed on {{ $ticket->closed_at ? \App\Helpers\TimezoneHelper::format($ticket->closed_at, 'M d, Y h:i A') : \App\Helpers\TimezoneHelper::format($ticket->updated_at, 'M d, Y h:i A') }}
                                </p>
                                
                                @if($ticket->rating)
                                <!-- Already Rated -->
                                <div class="rating-section mt-5">
                                    <h4 class="rating-title">Your Rating</h4>
                                    <div class="star-rating mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $ticket->rating ? 'filled' : '' }}">
                                                <i class="fa fa-star"></i>
                                            </span>
                                        @endfor
                                    </div>
                                    <p class="rating-text text-success">{{ $ticket->rating >= 4 ? 'Excellent' : ($ticket->rating >= 3 ? 'Good' : ($ticket->rating >= 2 ? 'Fair' : 'Poor')) }}</p>
                                    @if($ticket->rating_comment)
                                        <p class="rating-comment">"{{ $ticket->rating_comment }}"</p>
                                    @endif
                                    <p class="rating-thankyou">Thank you for your feedback!</p>
                                </div>
                                @else
                                <!-- Rating Form -->
                                <div class="rating-section mt-5">
                                    <h4 class="rating-title">How was your support experience?</h4>
                                    <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.submit-rating', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.submit-rating', $ticket->id) : route('customer.support-tickets.submit-rating', $ticket->id)) }}">
                                        @csrf
                                        <div class="star-rating mb-3" id="starRating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="star {{ $i <= 1 ? 'filled' : '' }}" data-rating="{{ $i }}">
                                                    <i class="fa fa-star"></i>
                                                </span>
                                            @endfor
                                            <input type="hidden" name="rating" id="ratingInput" value="1">
                                        </div>
                                        <p class="rating-text text-success" id="ratingText">Poor</p>
                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="rating_comment" rows="3" placeholder="Add a comment (optional)"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                                    </form>
                                </div>
                                @endif
                                
                                <div class="mt-5">
                                    <a href="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.index') : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard')) }}" class="btn btn-primary btn-lg">
                                        View All Tickets
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Active Ticket View with Tabs -->
                    <!-- Ticket Header -->
                    <div class="card ticket-header-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <h4 class="mb-0" style="margin-right: 1rem;">Ticket {{ $ticket->ticket_number }}</h4>
                                        @if($isSuperAdmin || $isStaff)
                                        @php
                                            $headerStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                        @endphp
                                        @if($headerStatus)
                                            <span class="badge" style="background-color: {{ $headerStatus->color }}; color: white;">{{ $headerStatus->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($ticket->status) }}</span>
                                        @endif
                                        @endif
                                    </div>
                                    <div class="ticket-meta-info">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p><strong>Category:</strong> 
                                                    @if($ticket->department)
                                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $ticket->department)) }}</span>
                                                    @else
                                                        <span style="color:unset;font-size: smaller;">-</span>
                                                    @endif
                                                </p>
                                                @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))

                                                <p><strong>Priority:</strong> 
                                                    @if($ticket->priority == 'low')
                                                        <span class="badge bg-success">Low</span>
                                                    @elseif($ticket->priority == 'medium')
                                                        <span class="badge bg-primary">Medium</span>
                                                    @elseif($ticket->priority == 'high')
                                                        <span class="badge bg-danger">High</span>
                                                    @elseif($ticket->priority == 'critical')
                                                        <span class="badge bg-danger">Critical</span>
                                                    @elseif($ticket->priority == 'urgent')
                                                        <span class="badge bg-danger">Urgent</span>
                                                    @endif
                                                </p>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Created:</strong> {{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A') }}</p>
                                                <p><strong>Last Updated:</strong> {{ \App\Helpers\TimezoneHelper::format($ticket->updated_at, 'M d, Y h:i A') }}</p>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="ticketTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="conversation-tab" data-bs-toggle="tab" href="#conversation" role="tab">Conversation</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="attachments-tab" data-bs-toggle="tab" href="#attachments" role="tab">Attachments</a>
                                </li>
                            </ul>
                            
                            <div class="tab-content mt-3" id="ticketTabsContent">
                                <!-- Details Tab -->
                                <div class="tab-pane fade show active" id="details" role="tabpanel">
                                    <div class="ticket-details">
                                        <h5>Ticket Information</h5>
                                        <div class="row">
                                            <div class="col-md-6">  
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Ticket Number</th>
                                                        <td>{{ $ticket->ticket_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Subject</th>
                                                        <td>{{ $ticket->subject }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Department</th>
                                                        <td>{{ $ticket->department ? ucfirst(str_replace('_', ' ', $ticket->department)) : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Created By</th>
                                                        <td>@if(\App\Models\Admin::where('id', $ticket->created_by)->exists())
                                                {{
                                                    \App\Models\Admin::where('id', $ticket->created_by)->first()->name
                                                }}
                                                @else
                                                {{
                                                    \App\Models\User::where('id', $ticket->created_by)->first()->first_name
                                                }} {{
                                                    \App\Models\User::where('id', $ticket->created_by)->first()->last_name
                                                }}
                                                @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Assigned To</th>
                                                        <td>{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'Unassigned' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                @if(\App\Helpers\RouteHelper::isSuperAdmin() || (\App\Helpers\RouteHelper::isStaff() && auth()->user()?->created_by == \App\Models\Admin::role('SuperAdmin')->first()?->id))

                                                    <tr>
                                                        <th>Priority</th>
                                                        <td>
                                                            @php
                                                                $priorityColors = [
                                                                    'low' => '#28a745',
                                                                    'medium' => '#ffc107',
                                                                    'high' => '#fd7e14',
                                                                    'critical' => '#dc3545'
                                                                ];
                                                                $priorityColor = $priorityColors[$ticket->priority] ?? '#6c757d';
                                                            @endphp
                                                            <span >{{ ucfirst($ticket->priority ) }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                    @if($isSuperAdmin || $isStaff)
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            @php
                                                                $indexStatus = $ticketStatuses->where('slug', $ticket->status)->first();
                                                            @endphp
                                                            @if($indexStatus)
                                                                <span class="badge" style="background-color: {{ $indexStatus->color }}; color: white;">{{ $indexStatus->name }}</span>
                                                            @else
                                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <th>Booking Reference</th>
                                                        <td>{{ $ticket->booking_reference ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Created At</th>
                                                        <td>{{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Updated At</th>
                                                        <td>{{ \App\Helpers\TimezoneHelper::format($ticket->updated_at, 'M d, Y h:i A') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Conversation Tab -->
                                <div class="tab-pane fade" id="conversation" role="tabpanel">
                                    <div class="conversation-section {{ \App\Helpers\RouteHelper::isSuperAdmin() ? 'superadmin-conversation' : 'user-conversation' }}">
                                        <!-- Initial Ticket Message -->
                                        @php
                                            $currentUserId = $isStaff ? (auth()->user()?->id ?? null) : (auth('admin')->user()?->id ?? null);
                                            $isTicketCreatorCurrentUser = $ticket->creator && $ticket->creator->id == $currentUserId;
                                            $creatorName = $ticket->creator_name;
                                            $creatorType = $ticket->creator_type;
                                        @endphp
                                        <div class="message-item {{ $isTicketCreatorCurrentUser ? 'note-dark  mb-3' : 'note-light mb-3' }}">
                                            <div class="message-header d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong>{{ $creatorName }}</strong>
                                                    <small class="message-time" style="margin-left: 1rem;">{{ \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="message-body">
                                                <div>{!! $ticket->description !!}</div>
                                                @if($ticket->attachments && !empty(json_decode($ticket->attachments, true)))
                                                    @php
                                                        $ticketAttachments = json_decode($ticket->attachments, true);
                                                    @endphp
                                                    <div class="attachments mt-2">
                                                        <strong>Attachments:</strong><br>
                                                        @foreach($ticketAttachments as $attachment)
                                                            @php
                                                                $attachmentPath = is_array($attachment) ? $attachment['path'] : $attachment;
                                                                $attachmentName = is_array($attachment) && isset($attachment['original_name']) ? $attachment['original_name'] : basename($attachmentPath);
                                                            @endphp
                                                            <a href="{{ asset('storage/app/public/' . $attachmentPath) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                <i class="fa fa-paperclip"></i> {{ $attachmentName }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Comments (including final comments in chronological order) -->
                                        @if(isset($allComments) && $allComments->count() > 0)
                                            @foreach ($allComments as $commentItem)
                                                @if($commentItem['type'] === 'regular')
                                                    @php
                                                        $comment = $commentItem['data'];
                                                        $isCommentAuthorCurrentUser = $comment->user_id == $currentUserId;
                                                        $commentAuthorName = $comment->author_name;
                                                        $commentAuthorType = $comment->author_type;
                                                    @endphp
                                                    <div class="message-item {{ $isCommentAuthorCurrentUser ? 'note-dark mb-3' : 'note-light mb-3' }}">
                                                        <div class="message-header d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <strong>{{ $commentAuthorName }}</strong>
                                                                <small class="message-time" style="margin-left: 1rem;">{{ \App\Helpers\TimezoneHelper::format($comment->created_at, 'M d, Y h:i A') }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            <div>{!! $comment->comment !!}</div>
                                                            @if($comment->attachments && !empty($comment->attachments))
                                                                @php $attachments = is_array($comment->attachments) ? $comment->attachments : json_decode($comment->attachments, true); @endphp
                                                                @if($attachments && !empty($attachments))
                                                                    <div class="attachments mt-2">
                                                                        <strong>Attachments:</strong><br>
                                                                        @foreach($attachments as $attachment)
                                                                            <a href="{{ asset('storage/app/public/' . (is_array($attachment) ? $attachment['path'] : $attachment)) }}" target="_blank" class class="btn btn-sm btn-outline-success">
                                                                                <i class="fa fa-file"></i> {{ is_array($attachment) && isset($attachment['original_name']) ? $attachment['original_name'] : basename(is_array($attachment) ? $attachment['path'] : $attachment) }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @elseif($commentItem['type'] === 'final')
                                                    @php
                                                        $ticket = $commentItem['data'];
                                                        $closerName = $ticket->closed_by_name;
                                                        $isReopened = $ticket->status !== 'closed';
                                                    @endphp
                                                    <div class="message-item note-dark mb-3">
                                                        <div class="message-header d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <strong>{{ $closerName }}</strong>
                                                                <small class="message-time" style="margin-left: 1rem;">{{ $ticket->closed_at ? \App\Helpers\TimezoneHelper::format($ticket->closed_at, 'M d, Y h:i A') : \App\Helpers\TimezoneHelper::format($ticket->updated_at, 'M d, Y h:i A') }}</small>
                                                                @if($isReopened)
                                                                    <span class="badge bg-secondary ms-2">Previously Closed</span>
                                                                @else
                                                                    <span class="badge bg-success ms-2">Final Resolution</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="message-body">
                                                            @if($ticket->status === 'closed')
                                                                <p><strong>Final Resolution Comment:</strong></p>
                                                            @else
                                                                <p><strong>Previous Final Comment (Ticket Reopened):</strong></p>
                                                            @endif
                                                            <p>{{ nl2br($ticket->final_comment) }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                        <!-- Add Comment Form -->
                                        @if($ticket->status !== 'closed')
                                        <div class="add-comment-section mt-4">
                                            <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.add-comment', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.add-comment', $ticket->id) : route('customer.support-tickets.add-comment', $ticket->id)) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group" style="width:92%;">
                                                    <div id="commentEditorCustomer" style="height: 150px; border-radius: 20px;"></div>
                                                    <input type="hidden" name="comment" id="commentInputCustomer">
                                                </div>
                                                <div class="form-group">
                                                    <div style="margin-right: 16px;">
                                                        <label class="btn btn-link p-0 text-success">
                                                            <i class="fa fa-paperclip fa-lg"></i>
                                                            <input type="file" name="attachments[]" multiple style="display: none;" class="attachment-input">
                                                        </label>
                                                        <div class="attachment-preview mt-2" id="attachmentPreviewCustomer" style="display: block; min-height: 50px;"></div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" style="border-radius: 20px;">
                                                        <i class="fa fa-paper-plane"></i> Send
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="ticket-closed-notice mt-4 text-center">
                                            <p style="color:unset;font-size: smaller;"><i class="fa fa-lock"></i> This ticket is closed. No further comments can be added.</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Attachments Tab -->
                                <div class="tab-pane fade" id="attachments" role="tabpanel">
                                    <div class="attachments-section">
                                        <h5>All Attachments</h5>
                                        
                                        @php
                                            $allAttachments = [];
                                            // Add ticket attachments
                                            if($ticket->attachments && !empty(json_decode($ticket->attachments, true))) {
                                                $ticketAttachments = json_decode($ticket->attachments, true);
                                                foreach($ticketAttachments as $attachment) {
                                                    // Handle both old string format and new array format
                                                    if(is_array($attachment)) {
                                                        $path = $attachment['path'];
                                                        $name = isset($attachment['original_name']) ? $attachment['original_name'] : basename($path);
                                                    } else {
                                                        $path = $attachment;
                                                        $name = basename($path);
                                                    }
                                                    $allAttachments[] = [
                                                        'path' => $path,
                                                        'name' => $name,
                                                        'source' => 'Ticket',
                                                        'date' => \App\Helpers\TimezoneHelper::format($ticket->created_at, 'M d, Y h:i A'),
                                                    ];
                                                }
                                            }
                                            // Add comment attachments
                                            foreach($comments as $comment) {
                                                if($comment->attachments && !empty($comment->attachments)) {
                                                    $commentAttachments = is_array($comment->attachments) ? $comment->attachments : json_decode($comment->attachments, true);
                                                    if($commentAttachments && !empty($commentAttachments)) {
                                                        foreach($commentAttachments as $attachment) {
                                                            // Handle both old string format and new array format
                                                            if(is_array($attachment)) {
                                                                $path = $attachment['path'];
                                                                $name = isset($attachment['original_name']) ? $attachment['original_name'] : basename($path);
                                                            } else {
                                                                $path = $attachment;
                                                                $name = basename($path);
                                                            }
                                                            $allAttachments[] = [
                                                                'path' => $path,
                                                                'name' => $name,
                                                                'source' => 'Comment by ' . ($comment->user ? $comment->user->name : 'Unknown'),
                                                                'date' => \App\Helpers\TimezoneHelper::format($comment->created_at, 'M d, Y h:i A'),
                                                            ];
                                                        }
                                                    }
                                                }
                                            }
                                            // Add internal note attachments
                                            foreach($internalNotes as $note) {
                                                if($note->attachments && !empty($note->attachments)) {
                                                    $noteAttachments = is_array($note->attachments) ? $note->attachments : json_decode($note->attachments, true);
                                                    if($noteAttachments && !empty($noteAttachments)) {
                                                        foreach($noteAttachments as $attachment) {
                                                            // Handle both old string format and new array format
                                                            if(is_array($attachment)) {
                                                                $path = $attachment['path'];
                                                                $name = isset($attachment['original_name']) ? $attachment['original_name'] : basename($path);
                                                            } else {
                                                                $path = $attachment;
                                                                $name = basename($path);
                                                            }
                                                            $allAttachments[] = [
                                                                'path' => $path,
                                                                'name' => $name,
                                                                'source' => 'Internal Note by ' . ($note->user ? $note->user->name : 'Unknown'),
                                                                'date' => \App\Helpers\TimezoneHelper::format($note->created_at, 'M d, Y h:i A'),
                                                            ];
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        @if(!empty($allAttachments))
                                            <div class="attachments-list">
                                                @foreach($allAttachments as $index => $attachment)
                                                    <div class="attachment-item mb-3 pb-3 border-bottom {{ $index % 2 === 0 ? 'note-light mb-3' : 'note-dark mb-3' }}">
                                                        <div class="attachment-header d-flex justify-content-between align-items-center">
                                                            <div class="attachment-info">
                                                                <strong><i class="fa fa-paperclip"></i> {{ $attachment['name'] }}</strong>
                                                                <small class="text-muted d-block mt-1">{{ $attachment['date'] }}</small>
                                                            </div>
                                                            <a href="{{ asset('storage/app/public/' . $attachment['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary flex-shrink-0">
                                                                <i class="fa fa-download"></i> Download
                                                            </a>
                                                        </div>
                                                        <div class="attachment-body mt-2">
                                                            <p class="mb-0"><strong>Source:</strong> {{ $attachment['source'] }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p style="color:unset;font-size: smaller;">No attachments found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <!-- /Page Content -->
    </div>

    <!-- Edit Company Name Modal -->
    @if($isSuperAdmin)
    <div class="modal fade" id="editCompanyNameModal" tabindex="-1" role="dialog" aria-labelledby="editCompanyNameModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompanyNameModalLabel">Edit Company Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-company-name', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-company-name', $ticket->id) : route('customer.support-tickets.update-company-name', $ticket->id)) }}">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <select class="form-control select2" id="company_name" name="company_name" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->company_name }}" {{ $ticket->company_name == $company->company_name ? 'selected' : '' }}>
                                        {{ $company->company_name }} ({{$company->admin->name}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Close Ticket Modal -->
    <div class="modal fade" id="closeTicketModal" tabindex="-1" role="dialog" aria-labelledby="closeTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeTicketModalLabel">Close Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-status', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', $ticket->id) : route('customer.support-tickets.update-status', $ticket->id)) }}">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="status" value="closed">
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> You are about to close this ticket. This action cannot be undone.
                        </div>
                        <div class="form-group mb-3">
                            <label for="final_comment">Final Comment <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="final_comment" name="final_comment" rows="4" placeholder="Please provide a final comment explaining the resolution..." required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Rating</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5"><label for="star5" class="fa fa-star"></label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4" class="fa fa-star"></label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3" class="fa fa-star"></label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2" class="fa fa-star"></label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1" class="fa fa-star"></label>
                            </div>
                            <style>
                                .star-rating {
                                    display: flex;
                                    flex-direction: row-reverse;
                                    justify-content: flex-end;
                                }
                                .star-rating input {
                                    display: none;
                                }
                                .star-rating label {
                                    font-size: 24px;
                                    color: #ddd;
                                    cursor: pointer;
                                    margin: 0 5px;
                                }
                                .star-rating input:checked ~ label {
                                    color: #ffc107;
                                }
                                .star-rating label:hover,
                                .star-rating label:hover ~ label {
                                    color: #ffc107;
                                }
                            </style>
                        </div>
                        <div class="form-group mb-3">
                            <label for="rating_comment">Feedback</label>
                            <textarea class="form-control" id="rating_comment" name="rating_comment" rows="3" placeholder="Please provide your feedback about the support..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to close this ticket?')">Close Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ticket-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .ticket-header-card .card-body {
            background: transparent;
        }
        
        .ticket-header-card h4 {
            color: white;
        }
        
        .ticket-header-card h5 {
            color: white;
        }
        
        .ticket-header-card p {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .ticket-header-card strong {
            color: white;
        }
        
        .conversation-section {
            padding: 20px;
            border-radius: 8px;
            min-height: 400px;
        }
        
        .superadmin-conversation .note-light {
            background-color: #e3f2fd;
            border-left: 4px solid #4169E1;
        }
        
        .superadmin-conversation .note-light:hover {
            background-color: #d1e7ff;
            border-left-color: #3047b3;
        }
        
        .superadmin-conversation .note-dark {
            background-color: #3047b3;
            border-left: 4px solid #3047b3;
            color:white !important;
        }
        
        .superadmin-conversation .note-dark:hover {
            background-color: #174f8d;
            border-left: 4px solid #3047b3;
            color: white;

        }
        
        .user-conversation .note-light {
            background-color: #fff3e0;
            border-left: 4px solid #FF7F50;
        }
        
        .user-conversation .note-light:hover {
            background-color: #ffe0cc;
            border-left-color: #e65c33;
        }
        
        .user-conversation .note-dark {
            background-color: #174f8d;
            border-left: 4px solid #3047b3;
            color:white;
        }
        
        .user-conversation .note-dark:hover {
            background-color: #174f8d;
            border-left: 4px solid #3047b3;
            color:white;
        }
        
        .message-item {
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .message-header {
            margin-bottom: 10px;
        }

        .message-time {
            color: #666;
            font-size: 0.85rem;
        }

        .note-dark .message-time {
            color: rgba(255, 255, 255, 0.9);
        }

        .message-body {
            color: unset;
        }

        .message-body p {
            margin-bottom: 0;
        }

        .message-body .attachments {
            margin-top: 10px;
        }
        
        .add-comment-section {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 20px;
            margin-top: 20px;
        }
        
        .add-comment-section .form-control {
            border: 1px solid #ddd;
            resize: none;
        }
        
        .add-comment-section .form-control:focus {
            border-color: #25d366;
            box-shadow: 0 0 0 2px rgba(37, 211, 102, 0.2);
        }
        
        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        .icon-input-container {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .icon-input-container .file-icon,
        .icon-input-container img {
            width: 32px;
            height: 32px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .icon-input-container .custom-file-name {
            flex: 1;
            min-width: 120px;
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }

        .icon-input-container .custom-file-name:focus {
            outline: none;
            border-color: #4169E1;
        }

        .attachment-preview-item {
            margin-bottom: 12px;
            padding: 10px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .attachment-preview-item .file-name {
            font-size: 12px;
            color: #666;
            margin-top: 6px;
            word-break: break-all;
        }

        .attachment-preview-item .remove-file {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .attachment-preview-item {
            position: relative;
        }

        .custom-name-wrapper {
            margin-bottom: 8px;
        }

        .custom-name-wrapper .custom-file-name {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
        }

        .attachment-preview {
            display: block !important;
            width: 100%;
            min-height: 50px;
            visibility: visible !important;
        }

        .attachment-preview .attachment-preview-item {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            margin-right: 10px;
            margin-bottom: 10px;
            vertical-align: top;
        }

        .attachment-preview .attachment-preview-item img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .attachment-preview .attachment-preview-item .file-icon {
            font-size: 40px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .attachment-preview .attachment-preview-item .file-name {
            font-size: 11px;
            color: #495057;
            word-break: break-all;
            max-width: 100px;
            text-align: center;
        }

        .attachment-preview .attachment-preview-item .remove-file {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .attachment-preview .attachment-preview-item .remove-file:hover {
            background: #c82333;
        }

        .custom-name-wrapper .custom-file-name:focus {
            outline: none;
            border-color: #4169E1;
            box-shadow: 0 0 0 2px rgba(65, 105, 225, 0.2);
        }

        .attach-files {
            display: flex;
            align-items: center;
        }
        
        .ticket-closed-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .ticket-closed-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }
        
        .ticket-closed-icon {
            color: #28a745;
        }
        
        .ticket-closed-title {
            color: #333;
            margin-bottom: 15px;
        }
        
        .badge-lg {
            font-size: 1.2rem;
            padding: 10px 20px;
        }
        
        .ticket-closed-message {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        
        .rating-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
        }
        
        .rating-title {
            color: #333;
            margin-bottom: 20px;
        }
        
        .star-rating {
            font-size: 2rem;
        }
        
        .star {
            color: #ffc107;
            margin: 0 5px;
        }
        
        .star.filled {
            color: #ffc107;
        }
        
        .star.hovered {
            color: #ffd54f;
        }
        
        .rating-comment {
            color: #6c757d;
            font-style: italic;
            margin: 10px 0;
        }
        
        .rating-text {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 15px 0;
        }
        
        .rating-thankyou {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .ticket-closed-notice {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #6c757d;
        }
        
        .ticket-resolution-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        
        .ticket-resolution-info h6 {
            margin-bottom: 10px;
            color: #333;
        }
        
        .ticket-resolution-info p {
            margin: 5px 0;
            color: #6c757d;
        }
        
        .attachment-item {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .attachment-item small {
            margin-left: 10px;
        }
        
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
            display: block !important;
            visibility: visible !important;
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
        
        .note-item {
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .message-item {
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .note-light {
            background-color: #f8f9fa;
            border-left: 4px solid #6c757d;
        }
        
        .note-light:hover {
            background-color: #e9ecef;
            border-left-color: #495057;
        }
        
        .note-dark {
            background-color: #174f8d;
            border-left: 4px solid #3047b3;
            color: white;
        }

        .note-dark:hover {
            background-color: #174f8d;
            border-left: 4px solid #3047b3;
            color: white;
        }

        .note-dark strong,
        .note-dark .text-muted,
        .note-dark small,
        .note-dark p,
        .note-dark .attachment-info,
        .note-dark .attachment-body {
            color: white !important;
        }

        .note-dark .message-time {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        #departmentSelect {
            cursor: pointer;
        }

        #staffSelect {
            cursor: pointer;
        }
        
        
        .note-header {
            margin-bottom: 10px;
        }

        .note-header .message-time {
            color: #666;
            font-size: 0.85rem;
        }

        .note-dark .note-header .message-time {
            color: rgba(255, 255, 255, 0.9);
        }

        .note-body {
            color: #495057;
        }
        
        .note-item .note-body p {
            margin-bottom: 0;
        }
        
        .edit-note-btn {
            font-size: 12px;
            padding: 4px 8px;
        }
        
        .edit-note-section {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
        }
        
        .edit-note-section .card {
            border: none;
            box-shadow: none;
            background: transparent;
        }
        
        .edit-note-section .card-body {
            padding: 0;
        }
        
        .attachment-item {
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .attachment-header {
            margin-bottom: 10px;
            width: 100%;
        }
        
        .attachment-info {
            flex: 1;
            min-width: 0; /* Allows text truncation if needed */
        }
        
        .attachment-info strong {
            display: block;
            word-break: break-all;
        }
        
        .attachment-body {
            color: #495057;
        }
        
        .attachment-body p {
            margin-bottom: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ticket-header-card .row {
                flex-direction: column;
            }

            .ticket-header-card .col-md-4 {
                margin-bottom: 15px;
            }

            /* Action bar responsive */
            .card.mt-3 .row {
                flex-direction: column;
            }

            .card.mt-3 .col-md-3,
            .card.mt-3 .col-md-2 {
                width: 100%;
                margin-bottom: 10px;
            }

            .card.mt-3 button {
                width: 100%;
                margin-top: 10px !important;
            }

            /* Tabs responsive */
            .nav-tabs {
                flex-wrap: wrap;
            }

            .nav-tabs .nav-item {
                flex: 1 1 auto;
                text-align: center;
            }

            .nav-tabs .nav-link {
                font-size: 12px;
                padding: 8px 10px;
            }

            /* Tables responsive */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Conversation section */
            .conversation-section {
                padding: 10px;
            }

            .message-item {
                padding: 10px;
            }

            /* Attachments */
            .attachment-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .attachment-header {
                width: 100%;
            }

            .attachment-item .btn {
                margin-top: 10px;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .ticket-header-card h4 {
                font-size: 18px;
            }

            .badge {
                font-size: 10px;
                padding: 4px 8px;
            }

            .nav-tabs .nav-link {
                font-size: 11px;
                padding: 6px 8px;
            }

            .btn {
                font-size: 12px;
                padding: 8px 12px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        } else {
            console.log('jQuery version:', jQuery.fn.jquery);
        }

        $(document).ready(function() {
            @if(\App\Helpers\RouteHelper::isSuperAdmin())
            var staffByDepartmentRoute = '{{ route('admin.get-staff-by-department') }}';
            @elseif(\App\Helpers\RouteHelper::isStaff())
            var staffByDepartmentRoute = '{{ route('staff.get-staff-by-department') }}';
            @else
            var staffByDepartmentRoute = null;
            @endif

            // Initialize staff select with current assignment and department
            @if($isSuperAdmin)
            var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';
            var currentAssignedName = '{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . " " . $ticket->assignedTo->last_name : "" }}';
            var currentDepartment = '{{ $ticket->department ?? '' }}';
            @php
                // Get the default department from assigned staff if ticket department is not set
                $staffDepartment = '';
                if ($ticket->assignedTo && !empty($ticket->assignedTo->department_names)) {
                    $staffDepartment = trim($ticket->assignedTo->department_names[0] ?? '');
                }
            @endphp
            var staffDepartment = '{{ $staffDepartment }}';
            var staffSelect = $('#staffSelect');
            var departmentSelect = $('#departmentSelect');

            // Always use staff's department if ticket has assigned staff, otherwise use ticket's department
            var departmentToLoad = staffDepartment || currentDepartment;

            console.log('Initializing with - Current Department:', currentDepartment, 'Staff Department:', staffDepartment, 'Department to Load:', departmentToLoad);

            // Set current department using a more reliable method
            if (departmentToLoad) {
                // Use setTimeout to ensure the select element is fully rendered
                setTimeout(function() {
                    // First, try to find and select the option by text
                    departmentSelect.find('option').filter(function() {
                        return $(this).text().trim() === departmentToLoad.trim();
                    }).prop('selected', true);
                    
                    // If that didn't work, try by value
                    if (departmentSelect.val() !== departmentToLoad) {
                        departmentSelect.val(departmentToLoad);
                    }
                    
                    // Trigger change event to ensure consistency
                    departmentSelect.trigger('change');
                    
                    console.log('Department set to:', departmentSelect.val());
                }, 100);
                
                // Load staff for current department
                if (departmentToLoad && staffByDepartmentRoute) {
                    $.ajax({
                        url: staffByDepartmentRoute,
                        type: 'GET',
                        data: { department_id: departmentToLoad.trim() },
                        success: function(response) {
                            staffSelect.empty();
                            staffSelect.append('<option value="">Select Staff Member</option>');
                            
                            var currentAssignmentFound = false;
                            
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    if (staff.id == currentAssignedTo) {
                                        currentAssignmentFound = true;
                                    }
                                    staffSelect.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                staffSelect.append('<option value="">No staff members found</option>');
                            }

                            // If current assigned staff is not in the current department, still show them as selected
                            // But only if they are not deleted
                            @if(!isset($isAssignedStaffDeleted) || !$isAssignedStaffDeleted)
                            if (currentAssignedTo && !currentAssignmentFound && currentAssignedName) {
                                staffSelect.append('<option value="' + currentAssignedTo + '" selected>' + currentAssignedName + ' (Current Assignment)</option>');
                            }
                            @endif
                        },
                        error: function(xhr) {
                            console.error('Error loading staff on page load:', xhr);
                            staffSelect.empty();
                            staffSelect.append('<option value="">Error loading staff</option>');

                            // Still show current assignment on error
                            // But only if they are not deleted
                            @if(!isset($isAssignedStaffDeleted) || !$isAssignedStaffDeleted)
                            if (currentAssignedTo && currentAssignedName) {
                                staffSelect.append('<option value="' + currentAssignedTo + '" selected>' + currentAssignedName + ' (Current Assignment)</option>');
                            }
                            @endif
                        }
                    });
                }
            }
            @endif

            // Auto-update department when staff is selected
            $('#staffSelect').on('change', function() {
                var selectedStaffId = $(this).val();
                var departmentSelect = $('#departmentSelect');
                
                if (selectedStaffId) {
                    // Find the selected staff option to get their department
                    // Note: We need to fetch staff details to get their department
                    // For now, we'll trigger the department change event if needed
                    console.log('Staff selected:', selectedStaffId);
                }
            });

            $('#departmentSelect').on('change', function() {
                var departmentId = $(this).val();
                var staffSelect = $('#staffSelect');
                var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';
                var currentAssignedName = '{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . " " . $ticket->assignedTo->last_name : "" }}';

                console.log('Department changed:', departmentId);
                console.log('Route URL:', staffByDepartmentRoute);
                console.log('Current assigned to:', currentAssignedTo);

                // Show loading state
                staffSelect.html('<option value="">Loading...</option>');
                if (departmentId && staffByDepartmentRoute) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: staffByDepartmentRoute,
                        type: 'GET',
                        data: { department_id: departmentId.trim() },
                        success: function(response) {
                            console.log('Staff response:', response);
                            staffSelect.empty();
                            staffSelect.append('<option value="">Select Staff Member</option>');
                            
                            var currentAssignmentFound = false;
                            
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    console.log(staff);
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    if (staff.id == currentAssignedTo) {
                                        currentAssignmentFound = true;
                                    }
                                    staffSelect.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                staffSelect.append('<option value="">No staff members found</option>');
                            }
                            
                            // If current assigned staff is not in the new department, still show them as selected
                            // But only if they are not deleted
                            @if(!isset($isAssignedStaffDeleted) || !$isAssignedStaffDeleted)
                            if (currentAssignedTo && !currentAssignmentFound && currentAssignedName) {
                                staffSelect.append('<option value="' + currentAssignedTo + '" selected>' + currentAssignedName + ' (Current Assignment)</option>');
                            }
                            @endif
                        },
                        error: function(xhr) {
                            console.error('Error loading staff:', xhr);
                            console.error('Response status:', xhr.status);
                            console.error('Response text:', xhr.responseText);
                            staffSelect.empty();
                            staffSelect.append('<option value="">Error loading staff</option>');

                            // Still show current assignment on error
                            // But only if they are not deleted
                            @if(!isset($isAssignedStaffDeleted) || !$isAssignedStaffDeleted)
                            if (currentAssignedTo && currentAssignedName) {
                                staffSelect.append('<option value="' + currentAssignedTo + '" selected>' + currentAssignedName + ' (Current Assignment)</option>');
                            }
                            @endif
                        }
                    });
                } else {
                    // Reset to all staff members
                    staffSelect.empty();
                    staffSelect.append('<option value="">Select Staff Member</option>');
                    @if(isset($staffMembers) && $staffMembers)
                        @foreach($staffMembers as $staff)
                            var selected = '{{ $staff->id }}' == currentAssignedTo ? 'selected' : '';
                            staffSelect.append('<option value="{{ $staff->id }}" ' + selected + '>{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                        @endforeach
                    @endif
                }
            });

            $('#departmentStaffSelect').on('change', function() {
                var departmentId = $(this).val();
                var staffSelect2 = $('#staffSelect2');
                var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';

                console.log('DepartmentStaffSelect changed:', departmentId);
                console.log('Route URL:', staffByDepartmentRoute);

                // Show loading state
                staffSelect2.html('<option value="">Loading...</option>');
                if (departmentId && staffByDepartmentRoute) {
                // Fetch staff members by department via AJAX
                    $.ajax({
                        url: staffByDepartmentRoute,
                        type: 'GET',
                        data: { department_id: departmentId.trim() },
                        success: function(response) {
                            console.log('Staff response for departmentStaffSelect:', response);
                            staffSelect2.empty();
                            staffSelect2.append('<option value="">Select Staff Member</option>');
                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    staffSelect2.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                staffSelect2.append('<option value="">No staff members found</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error loading staff for departmentStaffSelect:', xhr);
                            console.error('Response status:', xhr.status);
                            console.error('Response text:', xhr.responseText);
                            staffSelect2.empty();
                            staffSelect2.append('<option value="">Error loading staff</option>');
                        }
                    });
                } else {
                    // Reset to all staff members
                    staffSelect2.empty();
                    staffSelect2.append('<option value="">Select Staff Member</option>');
                    @foreach($staffMembers as $staff)
                        staffSelect2.append('<option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                    @endforeach
                }
            });
            
        });

        // Change priority function - defined globally for inline onclick handlers
        window.changePriority = function(priority) {
            var ticketId = {{ $ticket->id }};
            var route = "{{ \App\Helpers\RouteHelper::isSuperAdmin() ? route('admin.support-tickets.update-status', $ticket->id) : (\App\Helpers\RouteHelper::isStaff() ? route('staff.support-tickets.update-status', $ticket->id) : route('customer.support-tickets.update-status', $ticket->id)) }}";

            $.ajax({
                url: route,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PATCH',
                    priority: priority
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error updating priority: ' + xhr.responseJSON?.message || 'Unknown error');
                }
            });
        };

        $(document).ready(function() {
            console.log('Document ready - Attachment preview script loaded');
            // Tab state persistence
            var ticketId = '{{ $ticket->id }}';
            var storageKey = 'active_tab_' + ticketId;
            var initialActiveTab = '{{ $activeTab ?? 'details' }}';

            // Function to activate a specific tab
            function activateTab(tabId) {
                // Remove active class from all tabs and panes
                $('#ticketTabs .nav-link').removeClass('active');
                $('#ticketTabsContent .tab-pane').removeClass('show active');

                // Add active class to the clicked tab and corresponding pane
                $('#' + tabId + '-tab').addClass('active');
                $('#' + tabId).addClass('show active');

                // Save to localStorage
                localStorage.setItem(storageKey, tabId);
            }
            
            // Restore active tab from session or localStorage
            var activeTabFromStorage = localStorage.getItem(storageKey);
            
            if (initialActiveTab && initialActiveTab !== 'details') {
                activateTab(initialActiveTab);
            } else if (activeTabFromStorage) {
                activateTab(activeTabFromStorage);
            } else {
                // Default to first tab if no state exists
                activateTab('details');
            }
            
            // Handle tab clicks to save state
            $('#ticketTabs .nav-link').on('click', function(e) {
                var tabId = $(this).attr('id').replace('-tab', '');
                activateTab(tabId);
            });
            
            // Add active_tab parameter to form submissions
            $('form').on('submit', function() {
                var activeTab = localStorage.getItem(storageKey) || 'details';
                var action = $(this).attr('action');

                // Check if action already has query parameters
                if (action.indexOf('?') !== -1) {
                    $(this).attr('action', action + '&active_tab=' + activeTab);
                } else {
                    $(this).attr('action', action + '?active_tab=' + activeTab);
                }
            });

            // Initialize Select2 for company name dropdown
            $('#company_name').select2({
                placeholder: 'Select Company',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#editCompanyNameModal')
            });
            
            // File count display
            $('input[type="file"]').on('change', function() {
                var count = $(this).get(0).files.length;
                if (count > 0) {
                    $('#file-count').text('(' + count + ' file(s) selected)');
                } else {
                    $('#file-count').text('');
                }
            });
            
            // Attachment preview functionality
            $(document).on('change', '.attachment-input', function() {
                console.log('Attachment input changed');
                var input = this;
                var previewContainer = null;

                // Try to find the preview container by checking which form we're in
                var form = $(input).closest('form');
                if (form.find('#attachmentPreviewAdmin').length > 0) {
                    previewContainer = $('#attachmentPreviewAdmin');
                    console.log('Using attachmentPreviewAdmin');
                } else if (form.find('#attachmentPreviewCustomer').length > 0) {
                    previewContainer = $('#attachmentPreviewCustomer');
                    console.log('Using attachmentPreviewCustomer');
                } else if (form.find('#editNoteAttachmentPreview').length > 0) {
                    previewContainer = $('#editNoteAttachmentPreview');
                    console.log('Using editNoteAttachmentPreview');
                } else if (form.find('#internalNoteAttachmentPreview').length > 0) {
                    previewContainer = $('#internalNoteAttachmentPreview');
                    console.log('Using internalNoteAttachmentPreview');
                } else {
                    // Fallback to finding by DOM structure
                    previewContainer = $(input).parent().next('.attachment-preview');
                    console.log('Preview container found via parent().next():', previewContainer.length);
                }

                if (!previewContainer || previewContainer.length === 0) {
                    console.error('Could not find preview container');
                    return;
                }

                previewContainer.empty();

                if (input.files && input.files.length > 0) {
                    console.log('Files selected:', input.files.length);
                    for (var i = 0; i < input.files.length; i++) {
                        (function(file, index) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                console.log('Loading file:', file.name);
                                var previewItem = $('<div class="attachment-preview-item" data-file-name="' + file.name + '" style="display: inline-flex; flex-direction: column; align-items: center; margin: 5px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; position: relative;"></div>');

                                // Check if it's an image
                                if (file.type.startsWith('image/')) {
                                    previewItem.append('<img src="' + e.target.result + '" alt="' + file.name + '" style="max-width: 80px; max-height: 80px; border-radius: 4px; margin-bottom: 5px;">');
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
                                    previewItem.append('<i class="fa ' + iconClass + '" style="font-size: 40px; color: #6c757d; margin-bottom: 5px;"></i>');
                                }

                                previewItem.append('<div class="file-name" style="font-size: 11px; color: #495057; word-break: break-all; max-width: 100px; text-align: center; margin-bottom: 5px;">' + file.name + '</div>');
                                previewItem.append('<button type="button" class="remove-file" style="position: absolute; top: -8px; right: -8px; width: 20px; height: 20px; border-radius: 50%; background: #dc3545; color: white; border: none; cursor: pointer; font-size: 14px; line-height: 1; display: flex; align-items: center; justify-content: center;">×</button>');

                                // Add custom name input inside the preview item
                                var customNameInput = $('<input type="text" class="form-control custom-file-name" placeholder="Custom name" value="" style="width: 100%; margin-top: 5px; font-size: 11px; padding: 4px; display: block;">');
                                previewItem.append(customNameInput);
                                console.log('Custom name input added for:', file.name);

                                previewContainer.append(previewItem);
                                console.log('Preview item added for:', file.name);
                            };

                            reader.readAsDataURL(file);
                        })(input.files[i], i);
                    }
                } else {
                    console.log('No files selected');
                }
            });
            
            // Remove file from preview
            $(document).on('click', '.remove-file', function() {
                var previewItem = $(this).closest('.attachment-preview-item');
                var fileNameToRemove = previewItem.data('file-name');
                var previewContainer = $(previewItem).closest('.attachment-preview');
                var input = null;

                // Find the input based on which preview container we're in
                if (previewContainer.attr('id') === 'attachmentPreviewAdmin' || previewContainer.attr('id') === 'attachmentPreviewCustomer') {
                    input = previewContainer.prev().find('.attachment-input')[0];
                } else {
                    input = previewContainer.closest('form').find('.attachment-input')[0];
                }

                // Fallback to finding input in the same form if the above doesn't work
                if (!input) {
                    input = $(previewItem).closest('form').find('.attachment-input')[0];
                }

                console.log('Removing file:', fileNameToRemove);

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

                // Update file count (if the element exists)
                var fileCountElement = $(input).closest('.form-group').find('#file-count');
                if (fileCountElement.length > 0) {
                    var count = input.files.length;
                    if (count > 0) {
                        fileCountElement.text('(' + count + ' file(s) selected)');
                    } else {
                        fileCountElement.text('');
                    }
                }
            });
            
            // Handle form submission to include custom file names
            $('form').on('submit', function(e) {
                var form = $(this);
                var attachmentNames = [];

                // Collect custom file names from attachment preview items
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

            // Filter staff members by department for SuperAdmin


            // Interactive star rating
            $('#starRating .star').on('click', function() {
                var rating = $(this).data('rating');
                $('#ratingInput').val(rating);
                
                // Update star display
                $('#starRating .star').each(function() {
                    var starRating = $(this).data('rating');
                    if (starRating <= rating) {
                        $(this).addClass('filled');
                    } else {
                        $(this).removeClass('filled');
                    }
                });
                
                // Update rating text
                var ratingTexts = ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                $('#ratingText').text(ratingTexts[rating - 1]);
            });
            
            // Hover effect for stars
            $('#starRating .star').on('mouseenter', function() {
                var rating = $(this).data('rating');
                $('#starRating .star').each(function() {
                    var starRating = $(this).data('rating');
                    if (starRating <= rating) {
                        $(this).addClass('hovered');
                    } else {
                        $(this).removeClass('hovered');
                    }
                });
            });
            
            $('#starRating').on('mouseleave', function() {
                $('#starRating .star').removeClass('hovered');
            });
            
            // Edit note functionality
            $('.edit-note-btn').on('click', function() {
                var noteId = $(this).data('note-id');
                var noteContent = $(this).data('note-content');
                
                $('#editNoteId').val(noteId);
                $('#editNoteContent').val(noteContent);
                $('#editNoteSection').show();
                
                // Scroll to edit form
                $('html, body').animate({
                    scrollTop: $('#editNoteSection').offset().top - 100
                }, 500);
            });
            
            // Cancel edit note
            $('#cancelEditNote').on('click', function() {
                $('#editNoteSection').hide();
                $('#editNoteId').val('');
                $('#editNoteContent').val('');
                $('#editNoteAttachmentPreview').empty();
                // Clear file input
                $('#editNoteForm input[type="file"]').val('');
            });
            
            // Initialize attachment preview for edit note form
            $('#editNoteForm .attachment-input').on('change', function() {
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
        });
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        // Initialize Quill editor for admin/staff comments
        if (document.getElementById('commentEditorAdmin')) {
            console.log('hello');
            var quillAdmin = new Quill('#commentEditorAdmin', {
                theme: 'snow',
                placeholder: 'Type your message here...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Update hidden input on form submission
            quillAdmin.on('text-change', function() {
                document.getElementById('commentInputAdmin').value = quillAdmin.root.innerHTML;
            });

            // Validate form before submission
            var adminForm = document.getElementById('commentEditorAdmin').closest('form');
            if (adminForm) {
                adminForm.addEventListener('submit', function(e) {
                    var content = quillAdmin.getText().trim();
                    if (content === '') {
                        e.preventDefault();
                        alert('Please enter a comment');
                    }
                });
            }
        }

        // Initialize Quill editor for customer comments
        if (document.getElementById('commentEditorCustomer')) {
            var quillCustomer = new Quill('#commentEditorCustomer', {
                theme: 'snow',
                placeholder: 'Type your message here...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Update hidden input on form submission
            quillCustomer.on('text-change', function() {
                document.getElementById('commentInputCustomer').value = quillCustomer.root.innerHTML;
            });

            // Validate form before submission
            var customerForm = document.getElementById('commentEditorCustomer').closest('form');
            if (customerForm) {
                customerForm.addEventListener('submit', function(e) {
                    var content = quillCustomer.getText().trim();
                    if (content === '') {
                        e.preventDefault();
                        alert('Please enter a comment');
                    }
                });
            }
        }
    </script>
@endsection