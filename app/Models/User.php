<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    
    protected $guard_name = 'web';
    protected $guarded = ['id'];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'plain_password',
    //     'is_active'
    // ];

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

    protected static function boot()
    {
        parent::boot();

        // Cascade delete staff-specific data when user is deleted
        static::deleting(function ($user) {
            // Delete departments and designations created by this staff member
            if ($user->role_id == 2) {
                $user->departments()->delete();
                $user->designations()->delete();
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientid', 'client_id');
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'agent_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'staff_id');
    }

    public function designations()
    {
        return $this->hasMany(Designation::class, 'staff_id');
    }

    public function userDepartments()
    {
        return $this->hasMany(UserDepartment::class, 'user_id');
    }

    public function getDepartmentNamesAttribute()
    {
        // First check if there are departments in the user_department table
        $userDeptNames = [];
        if ($this->relationLoaded('userDepartments') && $this->userDepartments) {
            $userDeptNames = $this->userDepartments->pluck('department_name')->toArray();
        } elseif (!$this->relationLoaded('userDepartments')) {
            // If not loaded, load it first
            $this->load('userDepartments');
            if ($this->userDepartments) {
                $userDeptNames = $this->userDepartments->pluck('department_name')->toArray();
            }
        }
        
        // If user_department table has departments, use those
        if (!empty($userDeptNames) && is_array($userDeptNames)) {
            return $userDeptNames;
        }
        
        // Otherwise, if the user has a primary department in the users table, use that
        if (!empty($this->department)) {
            return [$this->department];
        }
        
        return [];
    }

    public function syncDepartments(array $departmentNames)
    {
        // Update primary department in users table (first department)
        if (!empty($departmentNames) && is_array($departmentNames)) {
            $this->update(['department' => $departmentNames[0]]);
        }
        
        // Sync all departments in user_department table
        $this->userDepartments()->delete();
        foreach ($departmentNames as $departmentName) {
            if (!empty($departmentName)) {
                $this->userDepartments()->create([
                    'department_name' => $departmentName
                ]);
            }
        }
    }
}
