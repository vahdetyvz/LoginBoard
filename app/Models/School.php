<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function board() {
		return $this->hasMany(Board::class, 'school_id', 'id');
	}
}
