<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function towns() {
		return $this->hasMany(Town::class, 'cityId');
	}
}
