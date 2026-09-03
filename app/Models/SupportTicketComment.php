<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $casts = [
        'attachments' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function user()
    {
        // Handle both Admin and User relationships
        // This method should return the actual user/admin relationship
        // We'll determine the type dynamically when accessing
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        // Explicit relationship to Admin model
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function getAuthorNameAttribute()
    {
        // Determine if the user_id belongs to Admin or User table
        $admin = Admin::find($this->user_id);
        if ($admin) {
            return $admin->hasRole('SuperAdmin') ? 'Super Admin' : $admin->name;
        }
        
        $user = User::find($this->user_id);
        if ($user) {
            return $user->first_name . ' ' . $user->last_name;
        }
        
        return 'Unknown';
    }

    public function getAuthorTypeAttribute()
    {
        // Determine the author type
        $admin = Admin::find($this->user_id);
        if ($admin) {
            return $admin->hasRole('SuperAdmin') ? 'superadmin' : 'customer';
        }
        
        $user = User::find($this->user_id);
        if ($user) {
            return 'staff';
        }
        
        return 'unknown';
    }
}
