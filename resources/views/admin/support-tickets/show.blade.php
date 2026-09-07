@extends('admin/layouts/head-main')
@section('content')
    <title>View Support Ticket</title>

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
                            <li class="breadcrumb-item"><a href="{{ $isSuperAdmin ? route('admin.support-tickets.dashboard') : ($isStaff ? route('staff.support-tickets.index') : route('customer.support-tickets.index')) }}">Support Ticket Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ $isSuperAdmin ? route('admin.support-tickets.index') : ($isStaff ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard')) }}">{{ $isSuperAdmin ? 'All Tickets' : 'Support Tickets' }}</a></li>
                            <li class="breadcrumb-item active">{{ $ticket->ticket_number }}</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ $isSuperAdmin ? route('admin.support-tickets.index') : ($isStaff ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard')) }}" class="btn btn-secondary">
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
                                        <h4 class="mb-0" style="margin-right: 1rem;">Ticket #{{ $ticket->id }}</h4>
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
                                                <p><strong>Created:</strong> {{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                                                <p><strong>SLA Due:</strong> {{ $slaDue->format('M d, Y h:i A') }}
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
                            <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.update-status', $ticket->id) : ($isStaff ? route('staff.support-tickets.update-status', $ticket->id) : route('customer.support-tickets.update-status', $ticket->id)) }}">
                                @csrf
                                @method('patch')
                                <div class="row align-items-end">
                                    @if($isSuperAdmin)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control"  id="departmentSelect">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                <option value="{{$department}}">{{$department}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Assign To</label>
                                            <select class="form-control" name="assigned_to" id="staffSelect">
                                                <option value="">Select Staff Member</option>
                                                @foreach($staffMembers as $staff)
                                                    <option value="{{ $staff->id }}" {{ $ticket->assigned_to == $staff->id ? 'selected' : '' }}>
                                                        {{ $staff->first_name }} {{ $staff->last_name }}
                                                    </option>
                                                @endforeach
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                @foreach($ticketStatuses as $status)
                                                    <option value="{{ $status->slug }}" {{ $ticket->status == $status->slug ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: -60px !important;">Update</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <!-- Closed Ticket Actions -->
                            <div class="row align-items-center">
                                    <div class="col-md-6 text-center">
                                        <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.update-status', $ticket->id) : ($isStaff ? route('admin.support-tickets.update-status', $ticket->id) : route('admin.support-tickets.update-status', $ticket->id)) }}">
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
                                        <p><strong>Resolved On:</strong> {{ $ticket->closed_at ? $ticket->closed_at->format('M d, Y h:i A') : 'N/A' }}</p>
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
                                            $currentUserId = $isStaff ? auth()->user()->id : auth('admin')->user()->id;
                                            $isTicketCreatorCurrentUser = $ticket->creator && $ticket->creator->id == $currentUserId;
                                            $creatorName = $ticket->creator_name;
                                            $creatorType = $ticket->creator_type;
                                        @endphp
                                        <div class="message-item {{ $isTicketCreatorCurrentUser ? 'note-dark mb-3' : 'note-light mb-3' }}">
                                            <div class="message-header d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong>{{ $creatorName }}</strong>
                                                    <small class="message-time" style="margin-left: 1rem;">{{ $ticket->created_at->format('M d, Y h:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="message-body">
                                                <p>{{ nl2br($ticket->description) }}</p>
                                                @if($ticket->attachments && !empty(json_decode($ticket->attachments)))
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

                                        <!-- Comments -->
                                        @if($comments->count() > 0)
                                            @foreach ($comments as $comment)
                                                @php
                                                    $isCommentAuthorCurrentUser = $comment->user_id == $currentUserId;
                                                    $commentAuthorName = $comment->author_name;
                                                    $commentAuthorType = $comment->author_type;
                                                @endphp
                                                <div class="message-item {{ $isCommentAuthorCurrentUser ? 'note-dark mb-3' : 'note-light mb-3' }}">
                                                    <div class="message-header d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <strong>{{ $commentAuthorName }}</strong>
                                                            <small class="message-time" style="margin-left: 1rem;">{{ $comment->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="message-body">
                                                        <p>{{ nl2br($comment->comment) }}</p>
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
                                            @endforeach
                                        @endif

                                        <!-- Add Comment Form -->
                                        @if($ticket->status !== 'closed')
                                        <div class="add-comment-section mt-4">
                                            <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.add-comment', $ticket->id) : ($isStaff ? route('staff.support-tickets.add-comment', $ticket->id) : route('customer.support-tickets.add-comment', $ticket->id)) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group" style="width:92%;">
                                                    <textarea class="form-control" name="comment" rows="3" placeholder="Type your message here..." required style="border-radius: 20px;"></textarea>
                                                </div>
                                                <input class="form-control" name="commented_by" value="{{ $isSuperAdmin ? 'superadmin' : ($isStaff ? 'staff' : 'customer') }}" style="display:none;">
                                                <div class="form-group" style="margin-top: 0px;">
                                                    <div style="margin-right: 16px;">
                                                        <label class="btn btn-link p-0 text-success">
                                                            <i class="fa fa-paperclip fa-lg"></i>
                                                            <input type="file" name="attachments[]" multiple style="display: none;" class="attachment-input">
                                                        </label>
                                                        <div class="attachment-preview mt-2" id="attachmentPreview"></div>
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
                                                    @if($ticket->status == 'closed')
                                                    <tr>
                                                        <th>Resolved On</th>
                                                        <td>{{ $ticket->resolved_at ? $ticket->resolved_at->format('M d, Y h:i A') : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Resolved By</th>
                                                        <td>{{ $ticket->assignedTo ? $ticket->assignedTo->first_name . ' ' . $ticket->assignedTo->last_name : 'N/A' }}</td>
                                                    </tr>
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
                                                        <td>{{ $ticket->created_at->format('M d, Y h:i A') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Updated At</th>
                                                        <td>{{ $ticket->updated_at->format('M d, Y h:i A') }}</td>
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
                                                            <small class="message-time" style="margin-left: 1rem;">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                        @if($note->user_id == $currentUserId)
                                                            <button type="button" class="btn btn-sm btn-outline-primary edit-note-btn" data-note-id="{{ $note->id }}" data-note-content="{{ $note->note }}">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="note-body">
                                                        <p>{{ nl2br($note->note) }}</p>
                                                        @if($note->attachments && !empty(json_decode($note->attachments)))
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
                                                    <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.update-internal-note', $ticket->id) : route('staff.support-tickets.update-internal-note', $ticket->id) }}" id="editNoteForm" enctype="multipart/form-data">
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
                                                            <div class="attachment-preview mt-2" id="editNoteAttachmentPreview"></div>
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
                                            <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.add-internal-note', $ticket->id) : route('staff.support-tickets.add-internal-note', $ticket->id) }}" enctype="multipart/form-data">
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
                                                    <div class="attachment-preview mt-2" id="internalNoteAttachmentPreview"></div>
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
                                            if($ticket->attachments && !empty(json_decode($ticket->attachments))) {
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
                                                        'date' => $ticket->created_at->format('M d, Y h:i A'),
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
                                                                'date' => $comment->created_at->format('M d, Y h:i A'),
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
                                                                'date' => $note->created_at->format('M d, Y h:i A'),
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
                                                                <strong><i class="fa fa-paperclip"></i> {{ $attachment['name'] ?? (is_array($attachment['path']) ? basename($attachment['path']['path'] ?? $attachment['path']) : basename($attachment['path'])) }}</strong>
                                                                <small class="text-muted d-block mt-1">{{ $attachment['date'] }}</small>
                                                            </div>
                                                            <a href="{{ asset('storage/app/public/' . (is_array($attachment['path']) ? $attachment['path']['path'] ?? $attachment['path'] : $attachment['path'])) }}" target="_blank" class="btn btn-sm btn-outline-primary flex-shrink-0">
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
                                <h2 class="ticket-closed-title">Ticket #{{ $ticket->id }}</h2>
                                <h4 class="ticket-closed-title">{{ $ticket->ticket_number }}</h4>
                                <span class="badge bg-success badge-lg mb-3">Closed</span>
                                <p class="ticket-closed-message">
                                    This ticket was closed on {{ $ticket->closed_at ? $ticket->closed_at->format('M d, Y h:i A') : $ticket->updated_at->format('M d, Y h:i A') }}
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
                                    <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.submit-rating', $ticket->id) : ($isStaff ? route('staff.support-tickets.submit-rating', $ticket->id) : route('customer.support-tickets.submit-rating', $ticket->id)) }}">
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
                                    <a href="{{ $isSuperAdmin ? route('admin.support-tickets.index') : ($isStaff ? route('staff.support-tickets.dashboard') : route('customer.support-tickets.dashboard')) }}" class="btn btn-primary btn-lg">
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
                                        <h4 class="mb-0" style="margin-right: 1rem;">Ticket #{{ $ticket->id }}</h4>
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
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Created:</strong> {{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                                                <p><strong>Last Updated:</strong> {{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
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
                                                        <td>{{ $ticket->created_at->format('M d, Y h:i A') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Updated At</th>
                                                        <td>{{ $ticket->updated_at->format('M d, Y h:i A') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Conversation Tab -->
                                <div class="tab-pane fade" id="conversation" role="tabpanel">
                                    <div class="conversation-section {{ $isSuperAdmin ? 'superadmin-conversation' : 'user-conversation' }}">
                                        <!-- Initial Ticket Message -->
                                        @php
                                            $currentUserId = $isStaff ? auth()->user()->id : auth('admin')->user()->id;
                                            $isTicketCreatorCurrentUser = $ticket->creator && $ticket->creator->id == $currentUserId;
                                            $creatorName = $ticket->creator_name;
                                            $creatorType = $ticket->creator_type;
                                        @endphp
                                        <div class="message-item {{ $isTicketCreatorCurrentUser ? 'note-dark  mb-3' : 'note-light mb-3' }}">
                                            <div class="message-header d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong>{{ $creatorName }}</strong>
                                                    <small class="message-time" style="margin-left: 1rem;">{{ $ticket->created_at->format('M d, Y h:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="message-body">
                                                <p>{{ nl2br($ticket->description) }}</p>
                                                @if($ticket->attachments && !empty(json_decode($ticket->attachments)))
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

                                        <!-- Comments -->
                                        @if($comments->count() > 0)
                                            @foreach ($comments as $comment)
                                                @php
                                                    $isCommentAuthorCurrentUser = $comment->user_id == $currentUserId;
                                                    $commentAuthorName = $comment->author_name;
                                                    $commentAuthorType = $comment->author_type;
                                                @endphp
                                                <div class="message-item {{ $isCommentAuthorCurrentUser ? 'note-dark mb-3' : 'note-light mb-3' }}">
                                                    <div class="message-header d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <strong>{{ $commentAuthorName }}</strong>
                                                            <small class="message-time" style="margin-left: 1rem;">{{ $comment->created_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="message-body">
                                                        <p>{{ nl2br($comment->comment) }}</p>
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
                                            @endforeach
                                        @endif

                                        <!-- Add Comment Form -->
                                        @if($ticket->status !== 'closed')
                                        <div class="add-comment-section mt-4">
                                            <form method="post" action="{{ $isSuperAdmin ? route('admin.support-tickets.add-comment', $ticket->id) : ($isStaff ? route('staff.support-tickets.add-comment', $ticket->id) : route('customer.support-tickets.add-comment', $ticket->id)) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group" style="width:92%;">
                                                    <textarea class="form-control" name="comment" rows="3" placeholder="Type your message here..." required style="border-radius: 20px;"></textarea>
                                                </div>
                                                <div class="form-group" style="float: inline-end; margin-top: -65px;">
                                                    <div style="float: inline-start;  margin-right: 16px;">
                                                        <label class="btn btn-link p-0 text-success">
                                                            <i class="fa fa-paperclip fa-lg"></i>
                                                            <input type="file" name="attachments[]" multiple style="display: none;" class="attachment-input">
                                                        </label>
                                                        <div class="attachment-preview mt-2" id="userAttachmentPreview"></div>
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
                                            if($ticket->attachments && !empty(json_decode($ticket->attachments))) {
                                                foreach(json_decode($ticket->attachments) as $attachment) {
                                                    $allAttachments[] = [
                                                        'path' => $attachment,
                                                        'source' => 'Ticket',
                                                        'date' => $ticket->created_at->format('M d, Y h:i A'),
                                                    ];
                                                }
                                            }
                                            // Add comment attachments
                                            foreach($comments as $comment) {
                                                if($comment->attachments && !empty($comment->attachments)) {
                                                    $commentAttachments = is_array($comment->attachments) ? $comment->attachments : json_decode($comment->attachments, true);
                                                    if($commentAttachments && !empty($commentAttachments)) {
                                                        foreach($commentAttachments as $attachment) {
                                                            $allAttachments[] = [
                                                                'path' => $attachment,
                                                                'source' => 'Comment by ' . ($comment->user ? $comment->user->name : 'Unknown'),
                                                                'date' => $comment->created_at->format('M d, Y h:i A'),
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
                                                                <strong><i class="fa fa-paperclip"></i> {{ $attachment['name'] ?? (is_array($attachment['path']) ? basename($attachment['path']['path'] ?? $attachment['path']) : basename($attachment['path'])) }}</strong>
                                                                <small class="text-muted d-block mt-1">{{ $attachment['date'] }}</small>
                                                            </div>
                                                            <a href="{{ asset('storage/app/public/' . (is_array($attachment['path']) ? $attachment['path']['path'] ?? $attachment['path'] : $attachment['path'])) }}" target="_blank" class="btn btn-sm btn-outline-primary flex-shrink-0">
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
                    <form method="post" action="{{ route('admin.support-tickets.update-company-name', $ticket->id) }}">
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
            font-size: 14px;
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

        @if($isSuperAdmin)
        #departmentSelect {
            cursor: pointer;
        }

        #staffSelect {
            cursor: pointer;
        }
        @endif
        
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
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
            $('.attachment-input').on('change', function() {
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

                                var iconInputContainer = $('<div class="icon-input-container"></div>');
                                iconInputContainer.append(previewItem.find('.file-icon, img'));
                                previewItem.append(iconInputContainer);
                                previewItem.append('<div class="file-name">' + file.name + '</div>');
                                previewItem.append('<button type="button" class="remove-file">×</button>');

                                // Add custom name input separately before the preview container
                                var customNameInput = $('<div class="custom-name-wrapper"><input type="text" class="form-control custom-file-name" placeholder="Custom name for ' + file.name + '" value="" required></div>');
                                previewContainer.append(customNameInput);
                                
                                previewContainer.append(previewItem);
                            };
                            
                            reader.readAsDataURL(file);
                        })(input.files[i], i);
                    }
                }
            });
            
            // Remove file from preview
            $(document).on('click', '.remove-file', function() {
                var previewItem = $(this).closest('.attachment-preview-item');
                var fileNameToRemove = previewItem.data('file-name');
                var input = $(this).closest('.form-group').find('.attachment-input')[0];
                
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
                var fileCountElement = $(this).closest('.form-group').find('#file-count');
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

                // Collect custom file names from custom-name-wrapper divs
                form.find('.custom-name-wrapper').each(function(index) {
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
            @if($isSuperAdmin)
            $('#departmentSelect').on('change', function() {
                var departmentId = $(this).val();
                var staffSelect = $('#staffSelect');
                var currentAssignedTo = '{{ $ticket->assigned_to ?? '' }}';

                // Show loading state
                staffSelect.html('<option value="">Loading...</option>');

                if (departmentId) {
                    // Fetch staff members by department via AJAX
                    $.ajax({
                        url: '{{ route('admin.get-staff-by-department') }}',
                        type: 'GET',
                        data: { department_id: departmentId },
                        success: function(response) {
                            staffSelect.empty();
                            staffSelect.append('<option value="">Select Staff Member</option>');

                            if (response.staff && response.staff.length > 0) {
                                response.staff.forEach(function(staff) {
                                    var selected = staff.id == currentAssignedTo ? 'selected' : '';
                                    staffSelect.append('<option value="' + staff.id + '" ' + selected + '>' + staff.first_name + ' ' + staff.last_name + '</option>');
                                });
                            } else {
                                staffSelect.append('<option value="">No staff members found</option>');
                            }
                        },
                        error: function(xhr) {
                            staffSelect.empty();
                            staffSelect.append('<option value="">Error loading staff</option>');
                        }
                    });
                } else {
                    // Reset to all staff members
                    staffSelect.empty();
                    staffSelect.append('<option value="">Select Staff Member</option>');
                    @foreach($staffMembers as $staff)
                    staffSelect.append('<option value="{{ $staff->id }}" {{ $ticket->assigned_to == $staff->id ? 'selected' : '' }}>{{ $staff->first_name }} {{ $staff->last_name }}</option>');
                    @endforeach
                }
            });
            @endif
            
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
            
            // Change priority function
            window.changePriority = function(priority) {
                var ticketId = {{ $ticket->id }};
                var route = "{{ $isSuperAdmin ? route('admin.support-tickets.update-status', $ticket->id) : ($isStaff ? route('admin.support-tickets.update-status', $ticket->id) : route('admin.support-tickets.update-status', $ticket->id)) }}";
                
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
        });
    </script>
@endsection