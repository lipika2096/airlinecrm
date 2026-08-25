<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
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
        return $this->userDepartments->pluck('department_name')->toArray();
    }

    public function syncDepartments(array $departmentNames)
    {
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
