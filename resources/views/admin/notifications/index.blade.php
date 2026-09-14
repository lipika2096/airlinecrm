<!DOCTYPE html>
<html lang="en">

<head>

    <?= $title_meta ?>


    <?= $this->include('partials/head-css') ?>

    <style>
        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .notification-item:hover {
            background-color: #f9f9f9;
        }
        .notification-item.unread {
            background-color: #f0f7ff;
            border-left: 3px solid #ed5b24;
        }
        .notification-item .notification-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .notification-item .notification-message {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }
        .notification-item .notification-ticket {
            font-size: 12px;
            color: #999;
            margin-bottom: 5px;
        }
        .notification-item .notification-time {
            font-size: 12px;
            color: #999;
        }
    </style>

</head>

<?= $this->include('partials/body') ?>

<div class="main-wrapper">
<?= $this->include('partials/menu') ?>

    <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Notifications</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ \App\Helpers\RouteHelper::getDashboardRoute() }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Notifications</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="card-title mb-0">All Notifications</h5>
                                        </div>
                                        <div class="col-auto">
                                            @if($unreadCount > 0)
                                                <a href="#" onclick="markAllAsRead(event)" class="btn btn-sm btn-primary">Mark All as Read ({{ $unreadCount }})</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($notifications->count() > 0)
                                        <div class="notification-list">
                                            @foreach($notifications as $notification)
                                                <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" data-id="{{ $notification->id }}">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <div class="notification-title">
                                                                {{ $notification->title }}
                                                                @if(!$notification->is_read)
                                                                    <span class="badge bg-danger ms-2">New</span>
                                                                @endif
                                                            </div>
                                                            <div class="notification-message">{{ $notification->message }}</div>
                                                            @if($notification->supportTicket)
                                                                <div class="notification-ticket">
                                                                    <small class="text-muted">Ticket: #{{ $notification->supportTicket->ticket_number }} - {{ $notification->supportTicket->subject }}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                                            <button onclick="deleteNotification({{ $notification->id }}, event)" class="btn btn-sm btn-link text-danger p-0">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $notifications->links() }}
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fa fa-bell-slash fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No notifications found</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /Page Wrapper -->



<!-- JAVASCRIPT -->
<?= $this->include('partials/vendor-scripts') ?>

<script>
function markAllAsRead(event) {
    event.preventDefault();
    $.ajax({
        url: '/notifications/read-all',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function() {
            location.reload();
        },
        error: function() {
            alert('Failed to mark all as read');
        }
    });
}

function deleteNotification(id, event) {
    event.preventDefault();
    event.stopPropagation();
    
    if(confirm('Are you sure you want to delete this notification?')) {
        $.ajax({
            url: '/notifications/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                location.reload();
            },
            error: function() {
                alert('Failed to delete notification');
            }
        });
    }
}

$(document).on('click', '.notification-item.unread', function() {
    const id = $(this).data('id');
    $.ajax({
        url: '/notifications/' + id + '/read',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function() {
            location.reload();
        }
    });
});
</script>

</body>

</html>
