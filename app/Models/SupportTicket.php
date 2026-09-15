<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'ticket_number',
        'department',
        'subject',
        'description',
        'priority',
        'status',
        'created_by',
        'assigned_to',
        'related_user_id',
        'booking_reference',
        'attachments',
        'rating',
        'rating_comment',
        'final_comment',
        'closed_by',
        'resolved_by',
        'resolved_at',
        'closed_at',
        'company_name',
    ];

    protected $casts = [
        'priority' => 'string',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'attachments' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'resolved_at',
        'closed_at',
    ];

    public function creator()
    {
        // Handle both Admin and User creators
        // Check if the ID exists in admins table first
        if ($this->created_by && \App\Models\Admin::where('id', $this->created_by)->exists()) {
            return $this->belongsTo(Admin::class, 'created_by');
        } else {
            return $this->belongsTo(User::class, 'created_by');
        }
    }

    public function getCreatorNameAttribute()
    {
        // Determine if the created_by belongs to Admin or User table
        $admin = Admin::find($this->created_by);
        if ($admin) {
            return $admin->hasRole('SuperAdmin') ? 'Super Admin' : $admin->name;
        }
        
        $user = User::find($this->created_by);
        if ($user) {
            return $user->first_name . ' ' . $user->last_name;
        }
        
        return 'Unknown';
    }

    public function getCompanyNameAttribute()
    {
        // If ticket has company_name set in database, use it
        if (isset($this->attributes['company_name']) && !empty($this->attributes['company_name'])) {
            return $this->attributes['company_name'];
        }

        // If ticket was created by staff (User), check if staff was created by a customer (Admin)
        $user = User::find($this->created_by);
        if ($user && $user->created_by) {
            $admin = Admin::find($user->created_by);
            if ($admin && $admin->adminDetail) {
                return $admin->adminDetail->company_name;
            }
        }

        // If ticket was created by Admin directly, use their company name
        $admin = Admin::find($this->created_by);
        if ($admin && $admin->adminDetail) {
            return $admin->adminDetail->company_name;
        }

        return null;
    }

    public function getCreatorTypeAttribute()
    {
        // Determine the creator type
        $admin = Admin::find($this->created_by);
        if ($admin) {
            return $admin->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        }
        
        $user = User::find($this->created_by);
        if ($user) {
            return 'staff';
        }
        
        return 'unknown';
    }

    public function assignedTo()
    {
        // Handle both Admin and User assignments
        if ($this->assigned_to && \App\Models\Admin::find($this->assigned_to)) {
            return $this->belongsTo(Admin::class, 'assigned_to');
        } else {
            return $this->belongsTo(User::class, 'assigned_to');
        }
    }

    public function relatedUser()
    {
        // Handle both Admin and User related users
        if ($this->related_user_id && \App\Models\Admin::find($this->related_user_id)) {
            return $this->belongsTo(Admin::class, 'related_user_id');
        } else {
            return $this->belongsTo(User::class, 'related_user_id');
        }
    }

    public function comments()
    {
        return $this->hasMany(SupportTicketComment::class, 'support_ticket_id');
    }

    public function internalNotes()
    {
        return $this->hasMany(InternalNote::class);
    }

    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'status', 'slug');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('created_by', $userId)
                    ->orWhere('assigned_to', $userId)
                    ->orWhere('related_user_id', $userId);
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Get the name of the user who closed the ticket
     * Checks if it's a staff member (users table) or admin (admins table)
     */
    public function getClosedByNameAttribute()
    {
        if (!$this->closed_by) {
            return 'N/A';
        }

        // First check if it's a staff member (users table)
        $user = User::find($this->closed_by);
        if ($user) {
            return $user->first_name . ' ' . $user->last_name;
        }

        // Then check if it's an admin (admins table)
        $admin = Admin::find($this->closed_by);
        if ($admin) {
            return $admin->hasRole('SuperAdmin') ? 'Super Admin' : $admin->name;
        }

        return 'Unknown';
    }

    /**
     * Get the name of the user who resolved the ticket
     * Checks if it's a staff member (users table) or admin (admins table)
     */
    public function getResolvedByNameAttribute()
    {
        if (!$this->resolved_by) {
            return 'N/A';
        }

        // First check if it's a staff member (users table)
        $user = User::find($this->resolved_by);
        if ($user) {
            return $user->first_name . ' ' . $user->last_name;
        }

        // Then check if it's an admin (admins table)
        $admin = Admin::find($this->resolved_by);
        if ($admin) {
            return $admin->hasRole('SuperAdmin') ? 'Super Admin' : $admin->name;
        }

        return 'Unknown';
    }

    /**
     * Get the customer details from admins table
     */
    public function getCustomerDetailsAttribute()
    {
        if (!$this->created_by) {
            return null;
        }

        // Check if the creator is an admin (customer)
        $admin = Admin::find($this->created_by);
        if ($admin) {
            return $admin;
        }

        // If creator is staff, get their customer (admin who created them)
        $user = User::find($this->created_by);
        if ($user && $user->created_by) {
            return Admin::find($user->created_by);
        }

        return null;
    }
}
