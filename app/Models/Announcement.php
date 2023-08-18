<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public function grup() {
		return $this->belongsTo(Grup::class, 'grup_id', 'id');
	}
}
