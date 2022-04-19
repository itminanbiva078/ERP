<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleAccess extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'role_accesses';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
}