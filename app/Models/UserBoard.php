<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBoard extends Model
{
    public function board() {
		return $this->belongsTo(Board::class, 'board_id', 'id');
	}
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
