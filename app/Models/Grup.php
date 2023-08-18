<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    public function school() {
		return $this->belongsTo(School::class, 'school_id', 'id');
	}
	
	public function board() {
		return $this->hasMany(Board::class, 'grup_id', 'id');
	}
}
