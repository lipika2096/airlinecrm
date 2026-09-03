<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;
use App\Models\Admin;

class UniqueEmailAcrossTables implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if email exists in users table
        $existsInUsers = User::where('email', $value)->exists();
        
        // Check if email exists in admins table
        $existsInAdmins = Admin::where('email', $value)->exists();
        
        // If email exists in either table, fail validation
        if ($existsInUsers || $existsInAdmins) {
            $fail('Email address already registered. Please use a different email address.');
        }
    }
}
