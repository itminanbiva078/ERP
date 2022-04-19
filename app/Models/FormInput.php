<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormInput extends Model
{
    use HasFactory;
    use SoftDeletes;


    function navigation()
    {

        return $this->belongsTo(Navigation::class, 'navigation_id', 'id');
    }
}