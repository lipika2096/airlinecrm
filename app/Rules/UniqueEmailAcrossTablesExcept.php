<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;
use App\Models\Admin;

class UniqueEmailAcrossTablesExcept implements ValidationRule
{
    protected $exceptId;
    protected $table;

    public function __construct($exceptId = null, $table = null)
    {
        $this->exceptId = $exceptId;
        $this->table = $table;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if email exists in users table (excluding current user if editing)
        $existsInUsers = User::where('email', $value);
        if ($this->table === 'users' && $this->exceptId) {
            $existsInUsers->where('id', '!=', $this->exceptId);
        }
        $existsInUsers = $existsInUsers->exists();
        
        // Check if email exists in admins table (excluding current admin if editing)
        $existsInAdmins = Admin::where('email', $value);
        if ($this->table === 'admins' && $this->exceptId) {
            $existsInAdmins->where('id', '!=', $this->exceptId);
        }
        $existsInAdmins = $existsInAdmins->exists();
        
        // If email exists in either table, fail validation
        if ($existsInUsers || $existsInAdmins) {
            $fail('Email address already registered. Please use a different email address.');
        }
    }
}
