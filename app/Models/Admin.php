<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard_name = 'web';
    protected $fillable = [
        'name',
        'email',
        'password',
        'plain_password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function adminDetail()
    {
        return $this->hasOne(AdminDetail::class, 'admin_id', 'id');
    }
    
    public function getCompanyNameAttribute()
    {
        return $this->adminDetail ? $this->adminDetail->company_name : null;
    }

    public function kycDocuments()
    {
        return $this->hasMany(AdminKycDocument::class, 'admin_id', 'id');
    }

    public function createdSupportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'created_by');
    }

    public function assignedSupportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to');
    }

    public function supportTicketComments()
    {
        return $this->hasMany(SupportTicketComment::class, 'user_id');
    }

}
