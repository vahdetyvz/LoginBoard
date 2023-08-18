<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\School;
use App\Models\Board;
use DB;

class LanguageController extends \App\Http\Controllers\Controller
{
    public function getLanguage() {
		$lang = Language::all();
		return response()->json($lang,200);
	}
}
