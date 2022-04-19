<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'task_statuses';
    protected $guarded = array();

    public function taskStatusCategory()
    {
        return $this->belongsTo(TaskCategory::class, 'task_statuse_id', 'id');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', Helper::companyId());
    }
    
}
