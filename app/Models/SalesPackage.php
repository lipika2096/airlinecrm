<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class SalesPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'modules' => 'array',
        'rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'annual_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getModulesListAttribute()
    {
        if (!is_array($this->modules) || empty($this->modules)) return '-';
        
        $permissions = Permission::whereIn('id', $this->modules)->pluck('name');
        return $permissions->implode(', ');
    }
}
