<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function school() {
		return $this->belongsTo(School::class, 'school_id', 'id');
	}
	
	public function grup() {
		return $this->belongsTo(Grup::class, 'grup_id', 'id');
	}
}
