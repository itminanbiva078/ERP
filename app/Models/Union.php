<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Union extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function upazila()
    {
        return $this->belongsTo(Upazila::class,'upazila_id', 'id');
    }

}
