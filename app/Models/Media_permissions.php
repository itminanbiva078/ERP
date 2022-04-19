<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Media_permissions extends Model {
	

	use SoftDeletes;
	use HasFactory;

	public $timestamps = false;
	
	public function media() {
		$this->hasOne( 'App\Models\Media' );
	}


	

}
